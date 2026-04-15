<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MekanikController extends Controller
{
    public function index()
    {
        $mekaniks = Mekanik::latest()->paginate(10);
        return view('admin.mekanik.index', compact('mekaniks'));
    }

    public function create()
    {
        return view('admin.mekanik.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_mekanik' => 'required|string|max:255',
        'nip' => 'required|string|unique:mekanik,nip',
        'spesialisasi' => 'nullable|string|max:255',
        'jam_masuk' => 'nullable|date_format:H:i',
        'jam_keluar' => 'nullable|date_format:H:i',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    // Add the currently logged-in user's ID
    $validated['id_user'] = auth()->id();  // or auth()->user()->id

    Mekanik::create($validated);
    return redirect()->route('admin.mekanik.index')->with('success', 'Mekanik berhasil ditambahkan');
}

    public function edit($id)
    {
        $mekanik = Mekanik::findOrFail($id);
        return view('admin.mekanik.edit', compact('mekanik'));
    }



public function update(Request $request, $id)
{
    $mekanik = Mekanik::findOrFail($id);

    // Konversi jam_masuk dan jam_keluar jika dalam format 12-jam (mengandung AM/PM)
    $request->merge([
        'jam_masuk' => $this->convertTo24Hour($request->jam_masuk),
        'jam_keluar' => $this->convertTo24Hour($request->jam_keluar),
    ]);

    $validated = $request->validate([
        'nama_mekanik' => 'required|string|max:255',
        'spesialisasi' => 'nullable|string|max:255',
        'nip' => 'nullable|string|max:50|unique:mekanik,nip,' . $mekanik->id_mekanik . ',id_mekanik',
        'jam_masuk' => 'nullable|date_format:H:i',
        'jam_keluar' => 'nullable|date_format:H:i',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    $mekanik->update($validated);

    return redirect()->route('admin.mekanik.index')
        ->with('success', 'Mekanik berhasil diupdate');
}

/**
 * Konversi format waktu 12-jam (08:00 AM) ke 24-jam (08:00)
 * Jika sudah format 24-jam, biarkan apa adanya.
 */
private function convertTo24Hour($time)
{
    if (empty($time)) {
        return null;
    }

    // Jika sudah format 24 jam (HH:MM)
    if (preg_match('/^\d{2}:\d{2}$/', $time)) {
        return $time;
    }

    // Jika mengandung AM/PM, konversi
    if (preg_match('/(AM|PM)$/i', $time)) {
        $parsed = Carbon::createFromFormat('h:i A', $time);
        return $parsed ? $parsed->format('H:i') : null;
    }

    return null;
}

    public function destroy($id)
    {
        $mekanik = Mekanik::findOrFail($id);
        $mekanik->delete();
        return redirect()->route('admin.mekanik.index')->with('success', 'Mekanik berhasil dihapus');
    }
    public function show($id)
{
    $mekanik = Mekanik::findOrFail($id);
    return view('admin.mekanik.show', compact('mekanik'));
}
}