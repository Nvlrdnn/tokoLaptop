<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan Toko Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
@extends('layouts.app')

@section('title', 'POS Kasir Transaksi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Sisi Kiri: Form Transaksi Penjualan -->
    <div class="lg:col-span-1 bg-slate-800/50 border border-slate-700/60 rounded-2xl p-6 space-y-4 h-fit backdrop-blur">
        <h2 class="text-xl font-bold text-white flex items-center">
            <i class="fa-solid fa-cart-shopping text-indigo-400 mr-2.5"></i> Form Pembelian
        </h2>

        @if(session('error'))
            <script>
                Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", background: '#1e293b', color: '#fff' });
            </script>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" id="formKasir" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1">Pilih Laptop Gudang</label>
                <select name="gudang_id" id="selectLaptop" onchange="updateHarga()" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
                    <option value="" data-harga="0">-- Pilih Unit Laptop --</option>
                    @foreach($laptops as $laptop)
                        <option value="{{ $laptop->id }}" data-harga="{{ $laptop->harga }}" data-stok="{{ $laptop->stok }}">
                            {{ $laptop->nama_laptop }} (Stok: {{ $laptop->stok }}) - Rp {{ number_format($laptop->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-white mb-1">Jumlah</label>
                    <input type="number" name="jumlah" id="inputJumlah" value="1" min="1" oninput="hitungTotal()" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-white mb-1">Uang Bayar (Rp)</label>
                    <input type="number" name="bayar" id="inputBayar" min="0" oninput="hitungKembalian()" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
                </div>
            </div>

            <!-- Ringkasan Kalkulasi -->
            <div class="bg-slate-900/80 rounded-xl p-4 space-y-2 border border-slate-700/50">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Total Tagihan:</span>
                    <span class="font-bold text-indigo-400" id="labelTotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Kembalian:</span>
                    <span class="font-bold text-emerald-400" id="labelKembali">Rp 0</span>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/30 transition">
                <i class="fa-solid fa-print mr-2"></i> Memproses & Simpan Transaksi
            </button>
        </form>
    </div>

    <!-- Sisi Kanan: Riwayat Transaksi -->
    <div class="lg:col-span-2 bg-slate-800/50 border border-slate-700/60 rounded-2xl p-6 backdrop-blur">
        <h2 class="text-xl font-bold text-white mb-4">Riwayat Transaksi Penjualan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/80 border-b border-slate-700/60 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="p-3">Kode TRX</th>
                        <th class="p-3">Item Laptop</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Bayar</th>
                        <th class="p-3">Kembali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50 text-sm">
                    @forelse($transaksis as $trx)
                        @foreach($trx->gudangs as $laptop)
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="p-3 font-mono text-xs text-indigo-400 font-bold">{{ $trx->kode_transaksi }}</td>
                            <td class="p-3 text-white font-medium">{{ $laptop->nama_laptop }}</td>
                            <td class="p-3 text-slate-300">{{ $laptop->pivot->jumlah }} unit</td>
                            <td class="p-3 text-emerald-400 font-semibold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td class="p-3 text-slate-400">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                            <td class="p-3 text-slate-400">Rp {{ number_format($trx->kembali, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let hargaUnit = 0;
    let totalHarga = 0;

    function updateHarga() {
        const select = document.getElementById('selectLaptop');
        const selectedOption = select.options[select.selectedIndex];
        hargaUnit = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        hitungTotal();
    }

    function hitungTotal() {
        const qty = parseInt(document.getElementById('inputJumlah').value) || 1;
        totalHarga = hargaUnit * qty;
        document.getElementById('labelTotal').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
        hitungKembalian();
    }

    function hitungKembalian() {
        const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
        const kembali = bayar - totalHarga;
        const labelKembali = document.getElementById('labelKembali');

        if (kembali >= 0) {
            labelKembali.innerText = 'Rp ' + kembali.toLocaleString('id-ID');
            labelKembali.className = 'font-bold text-emerald-400';
        } else {
            labelKembali.innerText = 'Kurang Rp ' + Math.abs(kembali).toLocaleString('id-ID');
            labelKembali.className = 'font-bold text-rose-400';
        }
    }
</script>
@endpush
</body>
</html>