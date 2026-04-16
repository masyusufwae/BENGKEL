<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\KendaraanPelanggan;
use App\Models\JenisServis;
use App\Models\Sparepart;
use App\Models\DetailServisWo;
use App\Models\PenggunaanSparepart;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $kendaraans = KendaraanPelanggan::all();
        return view('mekanik.work-order.create', compact('kendaraans'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_wo' => 'required|string|max:50|unique:work_order,nomor_wo',
            'status' => 'required|in:antrian,dikerjakan,menunggu_part,selesai',
            'id_kendaraan' => 'required|exists:kendaraan_pelanggan,id_kendaraan',
            'estimasi_selesai' => 'nullable|date',
            'keluhan' => 'required|string|max:500',
            'catatan_mekanik' => 'nullable|string|max:1000',
        ]);

        WorkOrder::create([
            'id_mekanik' => auth()->id(),
            'nomor_wo' => $validated['nomor_wo'],
            'status' => $validated['status'],
            'id_kendaraan' => $validated['id_kendaraan'],
            'estimasi_selesai' => $validated['estimasi_selesai'] ?? null,
            'keluhan' => $validated['keluhan'],
            'catatan_mekanik' => $validated['catatan_mekanik'] ?? null,
            'tanggal_masuk' => now(),
        ]);

        return redirect()->route('mekanik.work-order.index')
            ->with('success', 'Work Order berhasil ditambahkan!');
    }

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
    // RIWAYAT - ARSIP SERVICE SELESAI
    // =========================
    public function riwayat(Request $request)
    {
        $query = WorkOrder::with('kendaraan')
            ->where('status', 'selesai')
            ->orderByDesc('tanggal_selesai');

        // Filter tanggal
        if ($tanggalDari = $request->tanggal_dari) {
            $query->whereDate('tanggal_masuk', '>=', $tanggalDari);
        }
        if ($tanggalSampai = $request->tanggal_sampai) {
            $query->whereDate('tanggal_masuk', '<=', $tanggalSampai);
        }

        // Filter plat nomor
        if ($plat = $request->plat) {
            $query->whereHas('kendaraan', function ($q) use ($plat) {
                $q->where('nomor_polisi', 'like', "%{$plat}%");
            });
        }

        $workOrdersSelesai = $query->paginate(15);

        return view('mekanik.riwayat.index', compact('workOrdersSelesai'));
    }

    // =========================
    // DETAIL
    // =========================

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
        $spareparts = Sparepart::all();

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
        ]);

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
    // TAMBAH JASA
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

        $subtotal = $sparepart->harga_jual * $request->jumlah;

        PenggunaanSparepart::create([
            'id_wo' => $request->id_wo,
            'id_part' => $request->id_part,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok
        $sparepart->decrement('stok', $request->jumlah);

        return redirect()->route('mekanik.work-order.detail', $request->id_wo)
            ->with('success', 'Sparepart ditambahkan');
    }
}
