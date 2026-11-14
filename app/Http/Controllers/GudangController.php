<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::latest()->get();
        return view('gudang.index', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_laptop' => 'required|string|max:150',
            'spesifikasi' => 'required|string',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        Gudang::create($request->all());

        return redirect()->route('gudang.index')->with('success', 'Laptop berhasil ditambahkan ke gudang!');
    }

    public function update(Request $request, $id)
    {
        $gudang = Gudang::findOrFail($id);

        $request->validate([
            'nama_laptop' => 'required|string|max:150',
            'spesifikasi' => 'required|string',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        $gudang->update($request->all());

        return redirect()->route('gudang.index')->with('success', 'Data gudang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Gudang::findOrFail($id)->delete();
        return redirect()->route('gudang.index')->with('success', 'Data laptop berhasil dihapus!');
    }
}