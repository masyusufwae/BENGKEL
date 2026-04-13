<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mekanik;

class MekanikController extends Controller
{
    public function index()
    {
        $data = Mekanik::all();
        return view('admin.mekanik.index', compact('data'));
    }

    public function create()
    {
        return view('admin.mekanik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mekanik' => 'required',
            'nip' => 'required',
            'spesialisasi' => 'required',
            'status' => 'required'
        ]);

        Mekanik::create($request->all());

        return redirect()->route('mekanik.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Mekanik::findOrFail($id);
        return view('admin.mekanik.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mekanik' => 'required',
            'nip' => 'required',
            'spesialisasi' => 'required',
            'status' => 'required'
        ]);

        Mekanik::findOrFail($id)->update($request->all());

        return redirect()->route('mekanik.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Mekanik::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}