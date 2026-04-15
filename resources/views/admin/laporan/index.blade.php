@extends('admin.layouts.app')
@section('title', 'Laporan Servis')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Generate Laporan Servis</h2>
                <form action="{{ route('admin.laporan.generate') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Generate Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection