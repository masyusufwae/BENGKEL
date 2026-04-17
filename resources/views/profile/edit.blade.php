@extends('customer.layouts.app')

@section('title', 'PENGATURAN PROFIL')

@section('page-content')
<div class="row g-4">
    <!-- Kolom Update Info Profil -->
    <div class="col-lg-6">
        <div class="box shadow-sm border border-slate-200 rounded-xl overflow-hidden bg-white h-100">
            <div class="bg-blue-50 text-blue-800 px-5 py-3 border-b border-blue-100 flex items-center">
                <h5 class="m-0 fs-6 font-bold tracking-wider"><i class="fas fa-id-card text-blue-500 mr-2"></i> INFORMASI PROFIL</h5>
            </div>
            <div class="p-5">
                <div class="max-w-xl mx-auto lg:mx-0">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Update Password -->
    <div class="col-lg-6">
        <div class="box shadow-sm border border-slate-200 rounded-xl overflow-hidden bg-white h-100">
            <div class="bg-indigo-50 text-indigo-800 px-5 py-3 border-b border-indigo-100 flex items-center">
                <h5 class="m-0 fs-6 font-bold tracking-wider"><i class="fas fa-key text-indigo-500 mr-2"></i> UBAH PASSWORD</h5>
            </div>
            <div class="p-5">
                <div class="max-w-xl mx-auto lg:mx-0">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Hapus Akun -->
    <div class="col-12 mt-4">
        <div class="box shadow-sm border border-red-200 rounded-xl overflow-hidden bg-white">
            <div class="bg-red-50 text-red-800 px-5 py-3 border-b border-red-100 flex items-center">
                <h5 class="m-0 fs-6 font-bold tracking-wider"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> DANGER ZONE</h5>
            </div>
            <div class="p-5">
                <div class="max-w-xl mx-auto lg:mx-0">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
