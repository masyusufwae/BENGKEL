@extends('customer.layouts.app')

@section('title', 'Invoice Service - Pelanggan')

@section('page-content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Invoice Service</h1>
                <p class="text-gray-600 mt-2">Daftar tagihan untuk layanan yang telah diterima</p>
            </div>

<!-- Invoices List -->
            @if(count($riwayat_servis) > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    No. Tagihan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Kendaraan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Service
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Status Bayar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($riwayat_servis as $invoice)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $invoice['id_wo'] }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ $invoice['tanggal'] }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ $invoice['kendaraan'] }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ $invoice['jenis'] }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        Rp {{ number_format($invoice['total'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $invoice['status_bayar'] == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($invoice['status_bayar']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium mr-3">Lihat</a>
                                        @if($invoice['status_bayar'] == 'belum')
                                            <a href="#" class="text-green-600 hover:text-green-700 font-medium">Bayar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Invoice</h3>
                    <p class="text-gray-600">Tagihan akan muncul setelah service selesai</p>
                </div>
            @endif

<!-- Summary Card -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Total Biaya</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format(collect($riwayat_servis)->sum('total') ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Sudah Dibayar</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        @php
                            $paid = collect($riwayat_servis)->where('status_bayar', 'lunas')->sum('total') ?? 0;
                        @endphp
                        Rp {{ number_format($paid, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Belum Dibayar</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        @php
                            $unpaid = collect($riwayat_servis)->where('status_bayar', '!=', 'lunas')->sum('total') ?? 0;
                        @endphp
                        Rp {{ number_format($unpaid, 0, ',', '.') }}
                    </p>
                </div>
            </div>
@endsection
