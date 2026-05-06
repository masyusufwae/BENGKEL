<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryMovementController extends Controller
{
    public function index()
    {
        $movements = InventoryMovement::with(['sparepart', 'workOrder.mekanik', 'workOrder.kendaraan.user'])
            ->latest()
            ->paginate(20);

        $summary = [
            'masuk' => (float) InventoryMovement::where('jenis', 'masuk')->sum('subtotal'),
            'keluar' => (float) InventoryMovement::where('jenis', 'keluar')->sum('subtotal'),
            'jumlah_masuk' => (int) InventoryMovement::where('jenis', 'masuk')->sum('jumlah'),
            'jumlah_keluar' => (int) InventoryMovement::where('jenis', 'keluar')->sum('jumlah'),
        ];

        $spareparts = Sparepart::orderBy('nama_part')->get();

        return view('admin.inventory.index', compact('movements', 'summary', 'spareparts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_part' => 'required|exists:sparepart,id_part',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $sparepart = Sparepart::findOrFail($validated['id_part']);
            $hargaSatuan = $validated['harga_satuan'] ?? ($validated['jenis'] === 'masuk' ? $sparepart->harga_beli : $sparepart->harga_jual);
            $subtotal = $hargaSatuan * $validated['jumlah'];

            if ($validated['jenis'] === 'masuk') {
                $sparepart->increment('stok', $validated['jumlah']);
            } else {
                if ($sparepart->stok < $validated['jumlah']) {
                    throw new \Exception('Stok tidak mencukupi untuk pengeluaran barang.');
                }

                $sparepart->decrement('stok', $validated['jumlah']);
            }

            InventoryMovement::create([
                'id_part' => $sparepart->id_part,
                'jenis' => $validated['jenis'],
                'jumlah' => $validated['jumlah'],
                'harga_satuan' => $hargaSatuan,
                'subtotal' => $subtotal,
                'sumber' => $validated['jenis'] === 'masuk' ? 'pembelian' : 'manual',
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            DB::commit();

            return back()->with('success', 'Mutasi barang berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
