<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\JenisServis;
use App\Models\Sparepart;
use App\Models\DetailServisWo;
use App\Models\PenggunaanSparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WorkOrderController extends Controller
{
    // =========================
    // INDEX + SEARCH
    // =========================
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status', 'all');
        $sort = $request->input('sort', 'default');

        $query = WorkOrder::with('kendaraan');

        // Search
        if ($search) {
            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('nomor_polisi', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Default sorting: status priority then newest
        $statusOrder = ['antrian' => 1, 'dikerjakan' => 2, 'selesai' => 3, 'ditolak' => 4];
        $query->orderByRaw("FIELD(status, 'antrian', 'dikerjakan', 'selesai', 'ditolak')")
              ->orderBy('tanggal_masuk', 'desc');

        // Override sort if specified
        if ($sort === 'terlama') {
            $query->orderBy('tanggal_masuk', 'asc');
        }

        $workOrders = $query->paginate(5)->withQueryString();

        return view('mekanik.work-order.index', compact('workOrders', 'statusFilter', 'sort'));
    }

    // =========================
    // DETAIL
    // =========================
    public function detail($id)
    {
        $wo = WorkOrder::with([
            'kendaraan.user',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->findOrFail($id);

        $jenisServis = JenisServis::all();
        $spareparts = Sparepart::all();

        return view('mekanik.work-order.detail', compact('wo', 'jenisServis', 'spareparts'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $wo = WorkOrder::with([
            'kendaraan.user',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->findOrFail($id);

        $jenisServis = JenisServis::all();
        $spareparts = Sparepart::where('stok', '>', 0)->get();

        return view('mekanik.work-order.edit', compact('wo', 'jenisServis', 'spareparts'));
    }

    // =========================
    // UPDATE DATA WO
    // =========================
    public function update(Request $request, $id)
    {
        $wo = WorkOrder::findOrFail($id);

        $validated = $request->validate([
            'nomor_wo' => 'required|string|max:50|unique:work_order,nomor_wo,' . $id . ',id_wo',
            'estimasi_selesai' => 'nullable|date',
            'catatan_mekanik' => 'nullable|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('work-order', 'public');
            $validated['gambar'] = $path;
        }

        $wo->update($validated);

        return redirect()->route('mekanik.work-order.edit', $id)
            ->with('success', 'Data Work Order berhasil diupdate!');
    }

    // =========================
    // UPDATE STATUS
    // =========================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
'status' => 'required|in:antrian,dikerjakan,selesai,ditolak',
        ]);

        $wo = WorkOrder::findOrFail($id);
        $wo->update(['status' => $request->status]);

        return redirect()->route('mekanik.work-order.detail', $id)
            ->with('success', 'Status berhasil diupdate');
    }

    // =========================
    // UPDATE CATATAN
    // =========================
    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan_mekanik' => 'nullable|string|max:1000',
        ]);

        $wo = WorkOrder::findOrFail($id);
        $wo->update([
            'catatan_mekanik' => $request->catatan_mekanik
        ]);

        return redirect()->route('mekanik.work-order.index')
            ->with('success', 'Catatan berhasil disimpan');
    }

    // =========================
    // TAMBAH JASA SERVIS
    // =========================
    public function storeDetailServis(Request $request)
    {
        $request->validate([
            'id_wo' => 'required|exists:work_order,id_wo',
            'id_jenis' => 'required|exists:jenis_servis,id_jenis',
        ]);

        $jenis = JenisServis::findOrFail($request->id_jenis);

        DetailServisWo::create([
            'id_wo' => $request->id_wo,
            'id_jenis' => $request->id_jenis,
            'keterangan' => $request->keterangan,
            'harga_jasa' => $jenis->harga_jasa,
        ]);

        return redirect()->route('mekanik.work-order.detail', $request->id_wo)
            ->with('success', 'Jasa servis ditambahkan');
    }

    // =========================
    // TAMBAH SPAREPART
    // =========================
    public function storePenggunaanPart(Request $request)
    {
        $request->validate([
            'id_wo' => 'required|exists:work_order,id_wo',
            'id_part' => 'required|exists:sparepart,id_part',
            'jumlah' => 'required|integer|min:1',
        ]);

        $sparepart = Sparepart::findOrFail($request->id_part);

        // Validasi stok
        if ($request->jumlah > $sparepart->stok) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $subtotal = $sparepart->harga_jual * $request->jumlah;

        PenggunaanSparepart::create([
            'id_wo' => $request->id_wo,
            'id_part' => $request->id_part,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $sparepart->harga_jual,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $sparepart->decrement('stok', $request->jumlah);

        return redirect()->route('mekanik.work-order.detail', $request->id_wo)
            ->with('success', 'Sparepart ditambahkan');
    }

    // =========================
    // HALAMAN SERVIS
    // =========================
    public function servis($id)
    {
        $wo = WorkOrder::with([
            'kendaraan',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart'
        ])->findOrFail($id);

        $jenisServis = JenisServis::all();
        $spareparts = Sparepart::where('stok', '>', 0)->get();

        return view('mekanik.work-order.servis', compact('wo', 'jenisServis', 'spareparts'));
    }

    // =========================
    // SIMPAN SERVIS (TRANSACTION)
    // =========================
    // =========================
// SIMPAN SERVIS (TRANSACTION)
// =========================
public function storeServis(Request $request, $id)
{
    try {
        DB::transaction(function () use ($request, $id) {

            $wo = WorkOrder::findOrFail($id);

            // 1. UPDATE DATA BASIC WO (Opsional, jika ada update catatan/gambar)
            if ($request->has('catatan_mekanik')) {
                $wo->catatan_mekanik = $request->catatan_mekanik;
            }

            // Upload gambar jika ada
            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('work-order', 'public');
                $wo->gambar = $path;
            }
            $wo->save();

            // 2. JASA SERVIS (Dropdown Multiple)
            if ($request->jenis_servis) {
                foreach ($request->jenis_servis as $id_jenis) {
                    $jenis = JenisServis::findOrFail($id_jenis);

                    DetailServisWo::create([
                        'id_wo' => $wo->id_wo,
                        'id_jenis' => $id_jenis,
                        'harga_jasa' => $jenis->harga_jasa,
                    ]);
                }
            }

            // 3. SPAREPART (Sesuai dengan input dropdown & qty)
            if ($request->sparepart_id) {
                foreach ($request->sparepart_id as $index => $partId) {
                    $qty = $request->sparepart_qty[$index] ?? 0;

                    if ($partId && $qty > 0) {
                        $part = Sparepart::findOrFail($partId);

                        if ($qty > $part->stok) {
                            throw new \Exception("Stok {$part->nama_part} tidak mencukupi!");
                        }

                        PenggunaanSparepart::create([
                            'id_wo' => $wo->id_wo,
                            'id_part' => $partId,
                            'jumlah' => $qty,
                            'harga_satuan' => $part->harga_jual,
                            'subtotal' => $qty * $part->harga_jual,
                        ]);

                        $part->decrement('stok', $qty);
                    }
                }
            }

            // 4. Mark servis completed (status remains dikerjakan)
            $wo->update(['servis_completed' => true]);
        });

        // REDIRECT KE INDEX setelah sukses
        return redirect()->route('mekanik.work-order.index')
            ->with('success', 'Data servis berhasil disimpan! Status servis selesai.');

    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}

    // =========================
    // API: Count Antrian WO
    // =========================
    public function apiAntrianCount()
    {
        $count = WorkOrder::where('status', 'antrian')->count();
        return response()->json(['count' => $count]);
    }

    // =========================
    // RIWAYAT SERVIS
    // =========================
    public function riwayat(Request $request)
    {
        $query = WorkOrder::with('kendaraan')
            ->where('status', 'selesai')
            ->orderByDesc('tanggal_selesai');

        if ($request->tanggal_dari) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_dari);
        }

        if ($request->tanggal_sampai) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_sampai);
        }

        if ($request->plat) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('nomor_polisi', 'like', "%{$request->plat}%");
            });
        }

        $workOrdersSelesai = $query->paginate(15);

        return view('mekanik.riwayat.index', compact('workOrdersSelesai'));
    }

}
