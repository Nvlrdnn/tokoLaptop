<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Gudang Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
@extends('layouts.app')

@section('title', 'Inventaris Gudang Laptop')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Inventaris Gudang</h1>
            <p class="text-sm text-slate-400">Kelola ketersediaan barang dan spesifikasi laptop</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-xl font-medium text-sm flex items-center shadow-lg shadow-indigo-600/30 transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Laptop
        </button>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", background: '#1e293b', color: '#fff' });
        </script>
    @endif

    <!-- Tabel Gudang -->
    <div class="bg-slate-800/50 border border-slate-700/60 rounded-2xl overflow-hidden backdrop-blur">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/80 border-b border-slate-700/60 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="p-4">ID</th>
                        <th class="p-4">Nama Laptop</th>
                        <th class="p-4">Spesifikasi</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4">Harga Unit</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50 text-sm">
                    @forelse($gudangs as $item)
                    <tr class="hover:bg-slate-700/30 transition">
                        <td class="p-4 font-mono text-white">#{{ $item->id }}</td>
                        <td class="p-4 font-semibold text-white">{{ $item->nama_laptop }}</td>
                        <td class="p-4 text-white max-w-xs truncate">{{ $item->spesifikasi }}</td>
                        <td class="p-4">
                            @if($item->stok > 5)
                                <span class="bg-emerald-500/10 text-white border border-emerald-500/20 px-2.5 py-1 rounded-full text-xs font-medium">{{ $item->stok }} Unit</span>
                            @elseif($item->stok > 0)
                                <span class="bg-amber-500/10 text-white border border-amber-500/20 px-2.5 py-1 rounded-full text-xs font-medium">Sisa {{ $item->stok }} Unit</span>
                            @else
                                <span class="bg-rose-500/10 text-white border border-rose-500/20 px-2.5 py-1 rounded-full text-xs font-medium">Habis</span>
                            @endif
                        </td>
                        <td class="p-4 font-semibold text-white">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="p-4 text-right">
                            <button type="button" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->nama_laptop) }}', {{ $item->stok }}, {{ $item->harga }})" 
                                    class="text-amber-400 hover:text-amber-300 p-2 rounded-lg hover:bg-amber-500/10 transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('gudang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laptop ini dari gudang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 p-2 rounded-lg hover:bg-rose-500/10 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500">Belum ada data barang di gudang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Laptop -->
<div id="modalTambah" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="bg-slate-800 border border-slate-700/80 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex justify-between items-center border-b border-slate-700/60 pb-3">
            <h3 class="text-lg font-bold text-white">Tambah Laptop Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('gudang.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1">Nama / Merk Laptop</label>
                <input type="text" name="nama_laptop" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Stok (Unit)</label>
                    <input type="number" name="stok" min="0" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" min="0" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1">Spesifikasi Lengkap</label>
                <textarea name="spesifikasi" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:outline-none" required></textarea>
            </div>
            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-700/50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-medium shadow-lg shadow-indigo-600/30">Simpan Ke Gudang</button>
            </div>
        </form>
    </div>
</div>
<div id="editModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-2xl max-w-md w-full p-6 space-y-4">
        <h3 class="text-lg font-bold text-white">Edit Data Laptop</h3>

        <form id="editForm" method="POST" class="space-y-3">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs text-slate-400 mb-1">Nama Laptop</label>
                <input type="text" name="nama_laptop" id="editNama" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Stok</label>
                    <input type="number" name="stok" id="editStok" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white" required>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" id="editHarga" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white" required>
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-xs font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, stok, harga) {
        document.getElementById('editForm').action = '/gudang/' + id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editStok').value = stok;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection
</body>
</html>