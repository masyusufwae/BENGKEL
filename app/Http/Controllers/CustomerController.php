<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\KendaraanPelanggan;
use App\Models\InvoiceServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Vehicles Index - Tampilkan daftar kendaraan pelanggan
     */
    public function vehiclesIndex()
    {
        $user = Auth::user();

        $kendaraan_terdaftar = KendaraanPelanggan::where('id_pelanggan', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($kendaraan) {
                return [
                    'id_kendaraan' => $kendaraan->id_kendaraan,
                    'nomor_polisi' => $kendaraan->nomor_polisi,
                    'merek' => $kendaraan->merek,
                    'model' => $kendaraan->model,
                    'tahun' => $kendaraan->tahun,
                    'warna' => $kendaraan->warna,
                    'jenis_bahan_bakar' => $kendaraan->jenis_bahan_bakar,
                ];
            })->toArray();

        return view('customer.vehicles.index', [
            'kendaraan_terdaftar' => $kendaraan_terdaftar,
        ]);
    }

    /**
     * Vehicles Create - Form tambah kendaraan
     */
    public function vehiclesCreate()
    {
        return view('customer.vehicles.create');
    }

    /**
     * Vehicles Store - Simpan kendaraan baru
     */
    public function vehiclesStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_polisi' => 'required|unique:kendaraan_pelanggan',
            'merek' => 'required',
            'model' => 'required',
            'tahun' => 'required|numeric',
            'warna' => 'nullable',
            'nomor_rangka' => 'nullable',
            'nomor_mesin' => 'nullable',
            'jenis_bahan_bakar' => 'nullable',
        ]);

        $validated['id_pelanggan'] = Auth::id();

        KendaraanPelanggan::create($validated);

        return redirect()->route('customer.vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan');
    }

    /**
     * Vehicles Edit - Form edit kendaraan
     */
    public function vehiclesEdit($id)
    {
        $user = Auth::user();

        $kendaraan = KendaraanPelanggan::where('id_kendaraan', $id)
            ->where('id_pelanggan', $user->id)
            ->firstOrFail();

        return view('customer.vehicles.edit', [
            'kendaraan' => $kendaraan,
        ]);
    }

    /**
     * Vehicles Update - Update kendaraan
     */
    public function vehiclesUpdate(Request $request, $id)
    {
        $user = Auth::user();

        $kendaraan = KendaraanPelanggan::where('id_kendaraan', $id)
            ->where('id_pelanggan', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'nomor_polisi' => 'required|unique:kendaraan_pelanggan,nomor_polisi,' . $id . ',id_kendaraan',
            'merek' => 'required',
            'model' => 'required',
            'tahun' => 'required|numeric',
            'warna' => 'nullable',
            'nomor_rangka' => 'nullable',
            'nomor_mesin' => 'nullable',
            'jenis_bahan_bakar' => 'nullable',
        ]);

        $kendaraan->update($validated);

        return redirect()->route('customer.vehicles.index')
            ->with('success', 'Kendaraan berhasil diperbarui');
    }

    /**
     * Vehicles Destroy - Hapus kendaraan
     */
    public function vehiclesDestroy($id)
    {
        $user = Auth::user();

        $kendaraan = KendaraanPelanggan::where('id_kendaraan', $id)
            ->where('id_pelanggan', $user->id)
            ->firstOrFail();

        // Hapus semua work order terkait
        WorkOrder::where('id_kendaraan', $id)->delete();

        // Hapus kendaraan
        $kendaraan->delete();

        return redirect()->route('customer.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus');
    }

    /**
     * Orders Index - Tampilkan daftar pesanan service
     */
    public function ordersIndex()
    {
        $user = Auth::user();

        $riwayat_servis = WorkOrder::where(function($query) use ($user) {
            $query->whereHas('kendaraan', function($q) use ($user) {
                $q->where('id_pelanggan', $user->id);
            });
        })->with(['kendaraan', 'invoice'])
        ->orderBy('tanggal_masuk', 'desc')
        ->get()
        ->map(function($wo) {
            $invoice = $wo->invoice && is_iterable($wo->invoice) ? collect($wo->invoice)->first() : null;
            return [
                'id_wo' => $wo->nomor_wo,
                'tanggal' => $wo->tanggal_selesai ? $wo->tanggal_selesai->format('Y-m-d') : '-',
                'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model,
                'jenis' => $wo->keluhan,
                'total' => $invoice ? $invoice->total_bayar : 0,
                'status_bayar' => $invoice ? $invoice->status_bayar : 'belum',
            ];
        })->toArray();

        return view('customer.orders.index', [
            'riwayat_servis' => $riwayat_servis,
        ]);
    }

    /**
     * Orders Create - Form pesan service
     */
    public function ordersCreate()
    {
        $user = Auth::user();
        $kendaraan = KendaraanPelanggan::where('id_pelanggan', $user->id)->get();

        return view('customer.orders.create', [
            'kendaraan' => $kendaraan,
        ]);
    }

    /**
     * Orders Store - Simpan pesanan service baru
     */
    public function ordersStore(Request $request)
    {
        $validated = $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan_pelanggan,id_kendaraan',
            'keluhan' => 'required',
        ]);

        // Generate nomor WO
        $lastWO = WorkOrder::orderBy('id_wo', 'desc')->first();
        $nextNum = ($lastWO ? (int)str_replace('WO-', '', $lastWO->nomor_wo) : 0) + 1;

        WorkOrder::create([
            'id_kendaraan' => $validated['id_kendaraan'],
            'id_mekanik' => 1, // TODO: Assign mekanik otomatis
            'nomor_wo' => 'WO-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT),
            'keluhan' => $validated['keluhan'],
            'tanggal_masuk' => now(),
            'status' => 'antrian',
        ]);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan service berhasil dibuat');
    }

    /**
     * Invoices Index - Tampilkan daftar invoice
     */
    public function invoicesIndex()
    {
        $user = Auth::user();

        $riwayat_servis = WorkOrder::where(function($query) use ($user) {
            $query->whereHas('kendaraan', function($q) use ($user) {
                $q->where('id_pelanggan', $user->id);
            });
        })->with(['kendaraan', 'invoice'])
        ->orderBy('tanggal_selesai', 'desc')
        ->get()
        ->map(function($wo) {
            $invoice = $wo->invoice && is_iterable($wo->invoice) ? collect($wo->invoice)->first() : null;
            return [
                'id_wo' => $wo->nomor_wo,
                'tanggal' => $wo->tanggal_selesai ? $wo->tanggal_selesai->format('Y-m-d') : '-',
                'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model,
                'jenis' => $wo->keluhan,
                'total' => $invoice ? $invoice->total_bayar : 0,
                'status_bayar' => $invoice ? $invoice->status_bayar : 'belum',
            ];
        })->toArray();

        return view('customer.invoices.index', [
            'riwayat_servis' => $riwayat_servis,
        ]);
    }
}
