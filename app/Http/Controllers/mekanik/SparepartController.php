<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::orderBy('nama_part')->paginate(10);
        $stokMenipis = Sparepart::whereColumn('stok', '<=', 'stok_minimum')->count();
        $totalSparepart = Sparepart::count();
        return view('mekanik.sparepart.index', compact('spareparts', 'stokMenipis', 'totalSparepart'));
    }

    public function create()
    {
        return view('mekanik.sparepart.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_part' => 'required|unique:sparepart,kode_part',
            'nama_part' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'stok_minimum' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        Sparepart::create($request->only([
            'kode_part', 'nama_part', 'satuan', 'stok_minimum',
            'stok', 'harga_jual'
        ]));

        return redirect()->route('mekanik.sparepart.index')
            ->with('success', 'Sparepart berhasil ditambahkan');
    }


    public function detail($id)
    {
        $sparepart = Sparepart::with('penggunaanSparepart.workOrder')->findOrFail($id);
        return view('mekanik.sparepart.detail', compact('sparepart'));
    }

    public function edit($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('mekanik.sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);

        $request->validate([
            'kode_part' => 'required|unique:sparepart,kode_part,' . $id,
            'nama_part' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'stok_minimum' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $sparepart->update($request->only([
            'kode_part', 'nama_part', 'satuan', 'stok_minimum',
            'stok', 'harga_jual'
        ]));

        return redirect()->route('mekanik.sparepart.index')
            ->with('success', 'Sparepart berhasil diupdate');
    }

    public function updateStok(Request $request)
    {
        $request->validate([
            'id_part' => 'required|exists:sparepart,id_part',
            'stok' => 'required|integer',
        ]);
        $sparepart = Sparepart::findOrFail($request->id_part);
        $sparepart->stok += $request->stok;
        $sparepart->save();
        return redirect()->route('mekanik.sparepart.index')->with('success', 'Stok berhasil diupdate');
    }
}


