<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);
        return view('admin.sparepart.index', compact('spareparts'));
    }

    public function create()
    {
        return view('admin.sparepart.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_part' => 'required|unique:sparepart|max:50',
            'nama_part' => 'required|string|max:255',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        Sparepart::create($validated);
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('admin.sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $validated = $request->validate([
            'kode_part' => 'required|max:50|unique:sparepart,kode_part,' . $id . ',id_part',
            'nama_part' => 'required|string|max:255',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $sparepart->update($validated);
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil diupdate');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil dihapus');
    }
     public function show($id)
{
    $sparepart = Sparepart::findOrFail($id);
    return view('admin.sparepart.show', compact('sparepart'));
}
}