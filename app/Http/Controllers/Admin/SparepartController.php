<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $data = Sparepart::all();
        return view('admin.sparepart.index', compact('data'));
    }

    public function create()
    {
        return view('admin.sparepart.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_part' => 'required',
            'stok' => 'required',
            'harga_jual' => 'required',
        ]);

        Sparepart::create($request->all());

        return redirect()->route('sparepart.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Sparepart::findOrFail($id);
        return view('admin.sparepart.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_part' => 'required',
            'stok' => 'required',
            'harga_jual' => 'required',
        ]);

        Sparepart::findOrFail($id)->update($request->all());

        return redirect()->route('sparepart.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Sparepart::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}
