<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        //$laptops = Gudang::where('stok', '>', 0)->get();
        //$transaksis = Transaksi::with('gudangs')->latest()->get();
        //return view('transaksi.index', compact('laptops', 'transaksis'));
        $laptops = Gudang::where('stok', '>', 0)->get();
    
        $transaksis = Transaksi::with('gudangs')->latest()->paginate(10);
        
        return view('transaksi.index', compact('laptops', 'transaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gudang_id' => 'required|exists:gudangs,id',
            'jumlah'    => 'required|integer|min:1',
            'bayar'     => 'required|numeric|min:0',
        ]);

        $laptop = Gudang::findOrFail($request->gudang_id);

        if ($laptop->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok laptop tidak mencukupi!');
        }

        $subtotal = $laptop->harga * $request->jumlah;
        $totalHarga = $subtotal;

        if ($request->bayar < $totalHarga) {
            return redirect()->back()->with('error', 'Nominal pembayaran kurang!');
        }

        $kembali = $request->bayar - $totalHarga;

        DB::transaction(function () use ($request, $laptop, $totalHarga, $subtotal, $kembali) {
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . date('YmdHis') . '-' . rand(100, 999),
                'tanggal'        => now(),
                'total_harga'    => $totalHarga,
                'bayar'          => $request->bayar,
                'kembali'        => $kembali,
            ]);

            // Menyimpan ke tabel pivot 'penjualans' via belongsToMany
            $transaksi->gudangs()->attach($laptop->id, [
                'jumlah'   => $request->jumlah,
                'subtotal' => $subtotal,
            ]);

            // Potong stok gudang
            $laptop->decrement('stok', $request->jumlah);
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi penjualan berhasil diproses!');
    }
    
}
