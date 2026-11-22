<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanamanDitanam;
use App\Models\KriteriaTanaman;

class DashboardController extends Controller
{
    public function index()
    {
        $tanamanAktif = TanamanDitanam::all();

        return view('admin.dashboard');
    }
    public function kelolaData(Request $request)
    {
        $query = KriteriaTanaman::query();

        if ($request->filled('cari')) {
            $query->where('nama_tanaman', 'like', '%' . $request->cari . '%');
        }

        $dataTanaman = $query->orderBy('id_tanaman', 'asc')->get();

        return view('tanaman.kelolaDataTanaman', compact('dataTanaman'));
    }

    public function storeKriteria(Request $request)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:150',
            'usia_panen'   => 'nullable|numeric',
            'pH_min'       => 'nullable|numeric',
            'pH_max'       => 'nullable|numeric',
            'suhu_min'     => 'nullable|numeric',
            'suhu_max'     => 'nullable|numeric',
        ]);

        KriteriaTanaman::create($validated);

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil ditambahkan ke database.');
    }

    public function updateKriteria(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_tanaman' => 'required|string|max:150',
            'usia_panen'   => 'nullable|numeric',
            'pH_min'       => 'nullable|numeric',
            'pH_max'       => 'nullable|numeric',
            'suhu_min'     => 'nullable|numeric',
            'suhu_max'     => 'nullable|numeric',
        ]);

        $tanaman = KriteriaTanaman::findOrFail($id);
        $tanaman->update($validated);

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil diperbarui di database.');
    }

    public function destroyKriteria($id)
    {
        $tanaman = KriteriaTanaman::findOrFail($id);
        $tanaman->delete();

        return redirect()->route('admin.kelola-data')
            ->with('success', 'Data tanaman berhasil dihapus dari database.');
    }
}
