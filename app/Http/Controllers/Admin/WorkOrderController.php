<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\Mekanik;
use App\Models\JenisServis;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis',
            'spareparts',
            // Fallback relations (mekanik flow) for summary columns.
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])
            ->latest()
            ->paginate(10);
        return view('admin.work-order.index', compact('workOrders'));
    }

    public function create()
    {
        $mekaniks = Mekanik::where('status', 'aktif')->get();
        $jenisServis = JenisServis::all();
        $spareparts = Sparepart::where('stok', '>', 0)->get();
        return view('admin.work-order.create', compact('mekaniks', 'jenisServis', 'spareparts'));
    }
// ghfhgfg
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan_pelanggan,id_kendaraan',
            'id_mekanik' => 'required|exists:mekanik,id_mekanik',
            'keluhan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'status' => 'required|in:antrian,dikerjakan,menunggu_part,selesai,diserahkan',
            'catatan_mekanik' => 'nullable|string',
            'servis_ids' => 'required|array|min:1',
            'servis_ids.*' => 'exists:jenis_servis,id_jenis',
            'sparepart_ids' => 'nullable|array',
            'sparepart_ids.*' => 'exists:sparepart,id_part',
            'jumlah_sparepart' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Buat WO
            $wo = WorkOrder::create([
                'id_kendaraan' => $validated['id_kendaraan'],
                'id_mekanik' => $validated['id_mekanik'],
                'keluhan' => $validated['keluhan'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'estimasi_selesai' => $validated['estimasi_selesai'] ?? null,
                'status' => $validated['status'],
                'catatan_mekanik' => $validated['catatan_mekanik'] ?? null,
            ]);

            // Simpan detail servis
            foreach ($request->servis_ids as $id_jenis) {
                $jenis = JenisServis::findOrFail($id_jenis);
                $wo->jenisServis()->attach($id_jenis, ['harga_satuan' => $jenis->harga_jasa]);
            }

            // Simpan detail sparepart & kurangi stok
            if ($request->has('sparepart_ids')) {
                foreach ($request->sparepart_ids as $index => $id_part) {
                    $sparepart = Sparepart::findOrFail($id_part);
                    $jumlah = $request->jumlah_sparepart[$index] ?? 1;
                    if ($sparepart->stok < $jumlah) {
                        throw new \Exception("Stok {$sparepart->nama_part} tidak mencukupi");
                    }
                    $wo->spareparts()->attach($id_part, [
                        'jumlah' => $jumlah,
                        'harga_satuan' => $sparepart->harga_jual
                    ]);
                    $sparepart->decrement('stok', $jumlah);
                }
            }

            DB::commit();
            return redirect()->route('admin.work-order.index')->with('success', 'Work Order berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $workOrder = WorkOrder::with(['jenisServis', 'spareparts'])->findOrFail($id);
        $mekaniks = Mekanik::where('status', 'aktif')->get();
        $jenisServis = JenisServis::all();
        $spareparts = Sparepart::all();
        return view('admin.work-order.edit', compact('workOrder', 'mekaniks', 'jenisServis', 'spareparts'));
    }

    public function update(Request $request, $id)
    {
        $wo = WorkOrder::findOrFail($id);
        $validated = $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan_pelanggan,id_kendaraan',
            'id_mekanik' => 'required|exists:mekanik,id_mekanik',
            'id_sparepart' => 'nullable|exists:sparepart,id_part',
            'keluhan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'estimasi_selesai' => 'nullable|date',
            'status' => 'required|in:antrian,dikerjakan,menunggu_part,selesai,diserahkan',
            'catatan_mekanik' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Auto-set tanggal_selesai when WO is completed.
            if (($validated['status'] ?? null) === 'selesai' && empty($validated['tanggal_selesai'])) {
                $validated['tanggal_selesai'] = now();
            }

            $wo->update($validated);
            // Update servis dan sparepart bisa dihandle secara terpisah (misal dengan form dinamis)
            // Untuk sederhananya, kita tidak update relasi many-to-many di sini (bisa dibuat fitur tersendiri)
            DB::commit();
            return redirect()->route('admin.work-order.index')->with('success', 'Work Order berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $wo = WorkOrder::findOrFail($id);
        $wo->delete();
        return redirect()->route('admin.work-order.index')->with('success', 'Work Order dihapus');
    }

    public function show($id)
    {
        $workOrder = WorkOrder::with([
            'mekanik',
            'jenisServis',
            'spareparts',
            'kendaraan.user',
            // Fallback relations (mekanik flow) so admin detail page still shows items.
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->findOrFail($id);
        return view('admin.work-order.show', compact('workOrder'));
    }
}
