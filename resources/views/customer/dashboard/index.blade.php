@extends('customer.layouts.app')

@section('title', 'Dashboard - Pelanggan')

@section('page-content')

<!-- Welcome Hero Banner (Neon Style) -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-900 border border-slate-700 shadow-xl mb-8 group w-full">
    <!-- Animated background accents -->
    <div class="absolute -right-20 -top-20 w-64 h-64 bg-cyan-500 rounded-full blur-[80px] opacity-20 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700"></div>
    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-blue-600 rounded-full blur-[60px] opacity-20 group-hover:opacity-50 transition-all duration-700"></div>
    
    <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row items-center justify-between">
        <div class="mb-6 md:mb-0 md:pr-10">
            <div class="inline-block px-3 py-1 bg-cyan-500/20 border border-cyan-400/30 rounded-full text-cyan-300 text-[10px] font-bold tracking-widest mb-4">
                <i class="fas fa-satellite-dish mr-1 animate-pulse"></i> SYSTEM ONLINE
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-2 tracking-tight">Selamat Datang, <span class="text-cyan-400">{{ explode(' ', auth()->user()->name)[0] }}</span>!</h2>
            <p class="text-slate-300 text-sm font-medium w-full max-w-lg leading-relaxed">
                Kendaraan Anda adalah prioritas kami. Pantau riwayat servis, jadwal perawatan, dan info penting kendaraan Anda langsung dari Control Center ini.
            </p>
        </div>
        
        <div class="hidden lg:flex items-center justify-center relative">
            <!-- 3D/Tech Illustration fallback via FontAwesome -->
            <div class="relative w-32 h-32 flex items-center justify-center">
                <div class="absolute inset-0 bg-blue-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
                <i class="fas fa-car-side text-6xl text-slate-100 drop-shadow-[0_0_15px_rgba(255,255,255,0.8)] z-10 mr-4 transform -scale-x-100"></i>
                <i class="fas fa-wrench text-4xl text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.8)] z-20 absolute bottom-2 right-2 animate-bounce"></i>
            </div>
        </div>
    </div>
</div>

<!-- Profile Card (Hidden, diganti Hero Banner & Sidebar) -->
<!-- <div class="bg-white rounded-lg shadow p-6 mb-8">...</div> -->

<!-- Jadwal Servis Berikutnya (Workshop Tech Theme) -->
<div class="bg-slate-900 border border-slate-700 rounded-xl p-6 md:p-8 shadow-lg mb-8 relative overflow-hidden group">
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-600/10"></div>
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyan-500 shadow-[0_0_10px_rgba(34,211,238,0.8)]"></div>
    
    <!-- Workshop Mechanics Animation Element -->
    <div class="absolute top-1/2 right-[10%] md:right-[20%] transform -translate-y-1/2 w-48 h-48 sm:w-64 sm:h-64 opacity-20 pointer-events-none flex items-center justify-center mix-blend-screen">
        <!-- Outer Glowing Gear -->
        <i class="fas fa-cog text-[10rem] text-cyan-500 animate-[spin_10s_linear_infinite] opacity-50 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]"></i>
        <!-- Inner Glowing Gear (reverse spin) -->
        <i class="fas fa-cog text-[6rem] text-blue-400 absolute animate-[spin_6s_linear_infinite_reverse] drop-shadow-[0_0_10px_rgba(59,130,246,0.8)]"></i>
        <!-- Center core pulse -->
        <div class="absolute w-8 h-8 bg-cyan-300 rounded-full animate-pulse shadow-[0_0_20px_rgba(34,211,238,1)]"></div>
    </div>
    
    <div class="relative z-10 flex flex-col justify-between h-full md:flex-row md:items-center">
        <div class="mb-5 md:mb-0">
            <h2 class="text-[10px] sm:text-xs font-black text-cyan-400 tracking-[0.2em] uppercase mb-2 flex items-center">
                <i class="fas fa-microchip mr-2 animate-pulse text-cyan-300"></i>
                DIAGNOSTIK JADWAL SERVIS
            </h2>
            <p class="text-3xl sm:text-4xl font-black text-white mt-2 tracking-tight drop-shadow-md">{{ $jadwal_servis_berikutnya }}</p>
            <p class="text-xs text-slate-400 mt-3 font-medium">
                <i class="fas fa-wrench mr-1 text-cyan-600"></i> Sinkronisasi ke buku panduan perawatan...
            </p>
        </div>
        
        <div class="flex flex-col items-center">
            <div class="text-[10px] text-cyan-500 font-bold mb-2 uppercase tracking-widest hidden md:block">Slot Servis Tersedia</div>
            <a href="{{ route('customer.orders.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-cyan-600 hover:bg-cyan-500 text-slate-950 font-black px-8 py-3.5 rounded-lg transition-all duration-300 shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_30px_rgba(34,211,238,0.7)] hover:scale-105 border border-cyan-400 relative overflow-hidden group-hover:border-white">
                <!-- Glare light sweep over button -->
                <div class="absolute top-0 -left-full w-1/2 h-full bg-gradient-to-r from-transparent via-white/40 to-transparent transform skew-x-[-20deg] group-hover:animate-[shimmer_1.5s_infinite]"></div>
                <i class="fas fa-tools mr-2 transition-transform group-hover:-rotate-45"></i> BOOKING SERVIS
            </a>
        </div>
    </div>
</div>


                <!-- Kendaraan Butuh Perhatian -->
                <div class="bg-white rounded-xl shadow border border-slate-200 p-6 mb-8 hover-3d-glow">
                    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-3">
                        <h2 class="text-lg font-black text-slate-800 tracking-tight">🚗 KENDARAAN TERDAFTAR</h2>
                        <a href="{{ route('customer.vehicles.index') }}" class="text-cyan-600 hover:text-cyan-700 text-sm font-bold bg-cyan-50 px-3 py-1 rounded-md transition-colors">Lihat Semua →</a>
                    </div>
                    @if(count($kendaraan_terdaftar) > 0)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($kendaraan_terdaftar as $kendaraan)
                                <div class="border border-slate-200 rounded-lg p-5 hover:shadow-lg hover:border-cyan-400 transition-all duration-300 bg-gradient-to-br from-white to-slate-50 group hover-3d-glow relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-16 h-16 bg-cyan-500 rounded-bl-full opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                    <div class="flex items-center mb-3 relative z-10">
                                        <div class="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-900 rounded-lg flex items-center justify-center text-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.3)] group-hover:shadow-[0_0_15px_rgba(34,211,238,0.6)] transition-all">
                                            <i class="fas fa-car-side text-xl transform group-hover:scale-110 transition-transform"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-900">{{ $kendaraan['nomor_polisi'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $kendaraan['merek'] }} {{ $kendaraan['model'] }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 border-t border-gray-200 pt-3">
                                        <p>📅 Tahun: {{ $kendaraan['tahun'] }}</p>
                                        <div class="mt-3 pt-2 border-t border-gray-100 bg-blue-50 rounded p-3">
                                            <p class="text-xs text-gray-600 font-medium">Jadwal Servis:</p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="text-lg">{{ $kendaraan['jadwal_icon'] }}</span>
                                                <p class="font-bold @if($kendaraan['jadwal_status'] === 'overdue' || $kendaraan['jadwal_status'] === 'urgent') text-red-600 @elseif($kendaraan['jadwal_status'] === 'warning') text-yellow-600 @else text-green-600 @endif">
                                                    {{ $kendaraan['jadwal_servis'] }}
                                                </p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">{{ $kendaraan['jadwal_tanggal'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 py-8 text-center">Belum ada kendaraan terdaftar</p>
                    @endif
                </div>

                <!-- Service Aktif -->
                @if(count($wo_aktif) > 0)
                    <div class="bg-white rounded-lg shadow p-6 mb-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Service Kendaraan Aktif</h2>
                        <div class="space-y-4">
                            @foreach($wo_aktif as $wo)
                                <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $wo['id_wo'] }}</h3>
                                            <p class="text-sm text-gray-600">{{ $wo['kendaraan'] }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 text-blue-800">
                                            {{ $wo['status'] }}
                                        </span>
                                    </div>
                                    <div class="space-y-2 text-xs text-gray-600">
                                        <p>Tanggal Masuk: {{ $wo['tanggal_masuk'] }}</p>
                                        <p>Estimasi Selesai: <span class="font-semibold text-blue-600">{{ $wo['estimasi'] }}</span></p>
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <p>Progress</p>
                                                <p>65%</p>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

@endsection
