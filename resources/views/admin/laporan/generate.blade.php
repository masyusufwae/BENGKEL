@extends('admin.layouts.app')

@section('title', 'Hasil Laporan Servis')

@section('content')
<style>
    @media print {
        /* 1. Sembunyikan elemen navigasi dashboard */
        aside, nav, header, footer, .sidebar, .no-print {
            display: none !important;
        }

        /* 2. Sembunyikan elemen tambahan agar HANYA TABEL yang muncul */
        .print\:hidden,
        button,
        .hidden.print\:block, /* Menyembunyikan Header Bengkel Admin */
        .hidden.print\:flex,  /* Menyembunyikan Tanda Tangan/Footer */
        .grid,                /* Menyembunyikan Ringkasan Statistik (Total WO, dll) */
        h2.text-2xl           /* Menyembunyikan tulisan "Laporan Servis" */ {
            display: none !important;
        }

        /* 3. Atur layout kertas */
        .py-12 { padding: 0 !important; }
        .max-w-7xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .bg-white { background-color: transparent !important; }
        .shadow-sm, .sm\:rounded-lg {
            box-shadow: none !important;
            border: none !important;
        }

        /* 4. Optimasi Tabel */
        table {
            width: 100% !important;
            margin-top: 20px;
            border-collapse: collapse !important;
        }

        table, th, td {
            border: 1px solid #000 !important;
        }

        th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }

        @page {
            margin: 1cm;
            size: A4 portrait;
        }
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header Bengkel (Akan tersembunyi saat cetak karena CSS di atas) -->
        <div class="hidden print:block text-center mb-8 border-b-2 border-black pb-4">
            <h1 class="text-3xl font-bold uppercase">BENGKEL ADMIN</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Laporan Servis</h2>
                    <button onclick="window.print()" class="print:hidden bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                        Cetak Laporan
                    </button>
                </div>

                <!-- Informasi Periode (Tetap muncul agar tabel punya konteks waktu) -->
                <div class="mb-6">
                    <strong>Periode Laporan:</strong> {{ $dari->format('d/m/Y') }} - {{ $sampai->format('d/m/Y') }}
                </div>

                <!-- Ringkasan Statistik (Tersembunyi saat cetak karena selector .grid) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-100 p-4 rounded border border-blue-200">
                        <p class="text-sm">Total WO</p>
                        <p class="text-2xl font-bold">{{ $totalWO }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded border border-green-200">
                        <p class="text-sm">Total Pendapatan</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalPendapatan,0,',','.') }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded border border-yellow-200">
                        <p class="text-sm">WO Selesai</p>
                        <p class="text-2xl font-bold">{{ $totalSelesai }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded border border-purple-200">
                        <p class="text-sm">WO Diserahkan</p>
                        <p class="text-2xl font-bold">{{ $totalDiserahkan }}</p>
                    </div>
                </div>

                <!-- Tabel Data (Satu-satunya yang muncul dominan saat cetak) -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-start gap-4 flex-wrap mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Laporan Servis</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Periode {{ $dari->format('d/m/Y') }} - {{ $sampai->format('d/m/Y') }}
                            @if($idMekanik)
                                | Mekanik: {{ $mekaniks->firstWhere('id_mekanik', $idMekanik)?->nama_mekanik ?? '-' }}
                            @else
                                | Semua Mekanik
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.laporan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                        <a href="{{ route('admin.laporan.calendar', ['dari_tanggal' => $dari->format('Y-m-d'), 'sampai_tanggal' => $sampai->format('Y-m-d')]) }}" class="bg-slate-900 hover:bg-slate-700 text-white px-4 py-2 rounded">Kalender Servis</a>
                        <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Cetak</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">Total WO</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $totalWO }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalPendapatan,0,',','.') }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">WO Selesai</p>
                        <p class="text-2xl font-bold text-yellow-700">{{ $totalSelesai }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">WO Diserahkan</p>
                        <p class="text-2xl font-bold text-purple-700">{{ $totalDiserahkan }}</p>
                    </div>
                    <div class="bg-sky-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">Subtotal Servis</p>
                        <p class="text-2xl font-bold text-sky-700">Rp {{ number_format($totalServis,0,',','.') }}</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600">Subtotal Sparepart</p>
                        <p class="text-2xl font-bold text-amber-700">Rp {{ number_format($totalSparepart,0,',','.') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto mb-8">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">Mekanik</th>
                                <th class="py-2 px-4 border">Total WO</th>
                                <th class="py-2 px-4 border">Pendapatan</th>
                                <th class="py-2 px-4 border">Servis</th>
                                <th class="py-2 px-4 border">Sparepart</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryPerMekanik as $summary)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $summary['nama_mekanik'] }}</td>
                                    <td class="py-2 px-4 border">{{ $summary['total_wo'] }}</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($summary['total_servis'],0,',','.') }}</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($summary['total_sparepart'],0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada data untuk periode ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
>>>>>>> c8ee6f9 (update kalender & laporan per-mekanik)
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">No WO</th>
                                <th class="py-2 px-4 border">Tanggal Masuk</th>
                                <th class="py-2 px-4 border">Customer</th>
                                <th class="py-2 px-4 border">Mekanik</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporan as $wo)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $wo->nomor_wo }}</td>
                                    <td class="py-2 px-4 border">{{ $wo->tanggal_masuk->format('d/m/Y H:i') }}</td>
                                    <td class="py-2 px-4 border">{{ $wo->kendaraan?->user?->name ?? '-' }}</td>
                                    <td class="py-2 px-4 border">{{ $wo->mekanik?->nama_mekanik ?? '-' }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst(str_replace('_', ' ', $wo->status)) }}</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($wo->totalHarga,0,',','.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="border bg-gray-50 text-sm text-gray-700 p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="font-semibold mb-1">Servis</p>
                                                <ul class="list-disc ml-5 space-y-1">
                                                    @forelse($wo->detailServis as $detail)
                                                        <li>{{ $detail->jenisServis?->nama_servis ?? '-' }} - Rp {{ number_format($detail->harga_jasa,0,',','.') }}</li>
                                                    @empty
                                                        <li>Tidak ada detail servis</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <div>
                                                <p class="font-semibold mb-1">Sparepart</p>
                                                <ul class="list-disc ml-5 space-y-1">
                                                    @forelse($wo->penggunaanSparepart as $row)
                                                        <li>{{ $row->sparepart?->nama_part ?? '-' }} x{{ $row->jumlah }} - Rp {{ number_format($row->subtotal,0,',','.') }}</li>
                                                    @empty
                                                        <li>Tidak ada penggunaan sparepart</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada data untuk periode ini</td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tanda Tangan (Tersembunyi saat cetak karena selector .hidden.print:flex) -->
                <div class="hidden print:flex justify-between mt-12">
                    <div class="text-center">
                        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="text-center w-48">
                        <p>Kepala Bengkel,</p>
                        <br><br><br>
                        <p class="font-bold">( ............................ )</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
