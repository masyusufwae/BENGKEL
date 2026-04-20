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

        $workOrders = WorkOrder::with('kendaraan')
            ->when($search, function ($query, $search) {
                $query->whereHas('kendaraan', function ($q) use ($search) {
                    $q->where('nomor_polisi', 'like', "%$search%");
                });
            })
            ->orderByDesc('tanggal_masuk')
            ->paginate(10);

        return view('mekanik.work-order.index', compact('workOrders'));
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

        return view('mekanik.work-order.edit', compact('wo'));
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
            'status' => 'required|in:antrian,dikerjakan,menunggu_part,selesai',
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

        return redirect()->route('mekanik.work-order.detail', $id)
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
    public function storeServis(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $wo = WorkOrder::findOrFail($id);

            // JASA SERVIS
            if ($request->jenis_servis) {
                foreach ($request->jenis_servis as $servis) {
                    $jenis = JenisServis::findOrFail($servis);

                    DetailServisWo::create([
                        'id_wo' => $wo->id_wo,
                        'id_jenis' => $servis,
                        'harga_jasa' => $jenis->harga_jasa,
                    ]);
                }
            }

            // SPAREPART
            if ($request->sparepart) {
                foreach ($request->sparepart as $partId => $qty) {

                    $part = Sparepart::find($partId);

                    if ($part && $qty > 0) {

                        if ($qty > $part->stok) {
                            throw new \Exception("Stok {$part->nama_part} tidak cukup!");
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

            // Update status
            $wo->update([
                'status' => 'dikerjakan'
            ]);
        });

        return back()->with('success', 'Data servis berhasil disimpan!');
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
