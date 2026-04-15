<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisServis;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function index()
    {
        $servis = JenisServis::latest()->paginate(10);
        return view('admin.servis.index', compact('servis'));
    }

    public function create()
    {
        return view('admin.servis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_servis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'estimasi_waktu' => 'required|integer|min:1',
            'harga_jasa' => 'required|numeric|min:0',
            'kategori' => 'required|in:ringan,sedang,berat',
        ]);

        JenisServis::create($validated);
        return redirect()->route('admin.servis.index')->with('success', 'Jenis servis berhasil ditambahkan');
    }

    public function edit($id)
    {
        $servis = JenisServis::findOrFail($id);
        return view('admin.servis.edit', compact('servis'));
    }

    public function update(Request $request, $id)
    {
        $servis = JenisServis::findOrFail($id);
        $validated = $request->validate([
            'nama_servis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'estimasi_waktu' => 'required|integer|min:1',
            'harga_jasa' => 'required|numeric|min:0',
            'kategori' => 'required|in:ringan,sedang,berat',
        ]);

        $servis->update($validated);
        return redirect()->route('admin.servis.index')->with('success', 'Jenis servis berhasil diupdate');
    }

    public function destroy($id)
    {
        $servis = JenisServis::findOrFail($id);
        $servis->delete();
        return redirect()->route('admin.servis.index')->with('success', 'Jenis servis berhasil dihapus');
    }
     public function show($id)
{
    $servis = JenisServis::findOrFail($id);
    return view('admin.servis.show', compact('servis'));
}
}