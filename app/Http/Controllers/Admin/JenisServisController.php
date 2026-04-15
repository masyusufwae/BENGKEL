<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisServis;
use Illuminate\Http\Request;

class JenisServisController extends Controller
{
    public function index()
    {
        $data = JenisServis::all();
        return view('admin.jenis_servis.index', compact('data'));
    }

    public function create()
    {
        return view('admin.jenis_servis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_servis' => 'required',
            'harga_jasa' => 'required',
            'estimasi_waktu' => 'required',
        ]);

        JenisServis::create($request->all());

        return redirect()->route('jenis-servis.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = JenisServis::findOrFail($id);
        return view('admin.jenis_servis.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_servis' => 'required',
            'harga_jasa' => 'required',
            'estimasi_waktu' => 'required',
        ]);

        JenisServis::findOrFail($id)->update($request->all());

        return redirect()->route('jenis-servis.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisServis::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
    
}
