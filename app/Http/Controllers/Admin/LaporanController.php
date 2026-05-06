<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mekanik;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $mekaniks = Mekanik::orderBy('nama_mekanik')->get();

        return view('admin.laporan.index', compact('mekaniks'));
    }

    public function generate(Request $request)
    {
       

        $validated = $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            'id_mekanik' => 'nullable|exists:mekanik,id_mekanik',
        ]);

        $dari = Carbon::parse($validated['dari_tanggal'])->startOfDay();
        $sampai = Carbon::parse($validated['sampai_tanggal'])->endOfDay();
        $idMekanik = $validated['id_mekanik'] ?? null;

        $query = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis' => function ($q) {
                $q->withPivot('harga_satuan');
            },
            'detailServis.jenisServis',
            'spareparts' => function ($q) {
                $q->withPivot('jumlah', 'harga_satuan');
            },
            'penggunaanSparepart.sparepart',
        ])
            ->whereBetween('tanggal_masuk', [$dari, $sampai]);

        if ($idMekanik) {
            $query->where('id_mekanik', $idMekanik);
        }

        $laporan = $query->orderBy('tanggal_masuk')->get();

        $totalPendapatan = (float) $laporan->where('status', 'diserahkan')->sum(fn ($wo) => $wo->totalHarga);
        $totalWO = $laporan->count();
        $totalSelesai = $laporan->where('status', 'selesai')->count();
        $totalDiserahkan = $laporan->where('status', 'diserahkan')->count();
        $totalServis = (float) $laporan->sum(fn ($wo) => $wo->subtotal_servis);
        $totalSparepart = (float) $laporan->sum(fn ($wo) => $wo->subtotal_sparepart);

        $summaryPerMekanik = $laporan
            ->groupBy('id_mekanik')
            ->map(function ($items) {
                $first = $items->first();

                return [
                    'id_mekanik' => $first?->id_mekanik,
                    'nama_mekanik' => $first?->mekanik?->nama_mekanik ?? '-',
                    'total_wo' => $items->count(),
                    'total_pendapatan' => (float) $items->where('status', 'diserahkan')->sum(fn ($wo) => $wo->totalHarga),
                    'total_servis' => (float) $items->sum(fn ($wo) => $wo->subtotal_servis),
                    'total_sparepart' => (float) $items->sum(fn ($wo) => $wo->subtotal_sparepart),
                ];
            })
            ->sortByDesc('total_pendapatan')
            ->values();

        $mekaniks = Mekanik::all();    

        return view('admin.laporan.generate', compact(
            'laporan',
            'dari',
            'sampai',
            'totalPendapatan',
            'totalWO',
            'totalSelesai',
            'totalDiserahkan',
            'totalServis',
            'totalSparepart',
            'summaryPerMekanik',
            'idMekanik',
            'mekaniks'
        ));
    }

    public function calendar(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'nullable|date',
            'sampai_tanggal' => 'nullable|date',
        ]);

        $start = $request->filled('dari_tanggal')
            ? Carbon::parse($request->dari_tanggal)->startOfDay()
            : now()->startOfMonth();
        $end = $request->filled('sampai_tanggal')
            ? Carbon::parse($request->sampai_tanggal)->endOfDay()
            : now()->endOfMonth();

        $workOrders = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis' => function ($q) {
                $q->withPivot('harga_satuan');
            },
            'detailServis.jenisServis',
            'spareparts' => function ($q) {
                $q->withPivot('jumlah', 'harga_satuan');
            },
            'penggunaanSparepart.sparepart',
        ])
            ->whereBetween('tanggal_masuk', [$start, $end])
            ->orderBy('tanggal_masuk')
            ->get();

        $calendarNotes = $workOrders
            ->groupBy(function ($wo) {
                return optional($wo->tanggal_selesai ?? $wo->tanggal_masuk)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->map(function ($wo) {
                    return [
                        'id_wo' => $wo->id_wo,
                        'nomor_wo' => $wo->nomor_wo,
                        'tanggal' => optional($wo->tanggal_selesai ?? $wo->tanggal_masuk)->format('d M Y H:i'),
                        'customer' => $wo->kendaraan?->user?->name ?? '-',
                        'mekanik' => $wo->mekanik?->nama_mekanik ?? '-',
                        'status' => $wo->status,
                        'keluhan' => $wo->keluhan,
                        'servis' => $wo->detailServis->map(function ($detail) {
                            return [
                                'nama' => $detail->jenisServis?->nama_servis ?? '-',
                                'harga' => (float) $detail->harga_jasa,
                            ];
                        })->values(),
                        'sparepart' => $wo->penggunaanSparepart->map(function ($row) {
                            return [
                                'nama' => $row->sparepart?->nama_part ?? '-',
                                'jumlah' => (int) $row->jumlah,
                                'subtotal' => (float) $row->subtotal,
                            ];
                        })->values(),
                        'total' => (float) $wo->totalHarga,
                    ];
                })->values();
            });

        $calendarCounts = $calendarNotes->map->count();

        return view('admin.laporan.calendar', compact(
            'start',
            'end',
            'calendarNotes',
            'calendarCounts'
        ));
    }
}
