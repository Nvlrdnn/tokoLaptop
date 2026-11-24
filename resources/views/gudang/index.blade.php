@extends('layouts.app')

@section('title', 'Inventaris Gudang Laptop')

@section('content')

@php
    $items = $gudangs instanceof \Illuminate\Contracts\Pagination\Paginator
        ? collect($gudangs->items())
        : collect($gudangs);

    $totalJenis = $items->count();
    $totalStok = $items->sum('stok');

    $stokMenipis = $items->filter(function ($item) {
        return $item->stok > 0 && $item->stok <= 5;
    })->count();

    $cakupan = $gudangs instanceof \Illuminate\Contracts\Pagination\Paginator
        ? ' (halaman ini)'
        : '';
@endphp

<!-- Judul Halaman -->
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Inventaris Gudang
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola data laptop, harga, dan ketersediaan stok.
        </p>
    </div>

    <button type="button"
            onclick="document.getElementById('modalTambah').showModal()"
            class="btn-primary">

        <i class="fa-solid fa-plus mr-2"></i>
        Tambah Laptop

    </button>

</div>

<!-- Ringkasan Stok -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <div class="panel p-5">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm text-gray-500">
                    Jenis Laptop{{ $cakupan }}
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $totalJenis }}
                </h2>
            </div>

            <i class="fa-solid fa-laptop text-3xl text-gray-400"></i>

        </div>

    </div>

    <div class="panel p-5">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm text-gray-500">
                    Total Stok{{ $cakupan }}
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $totalStok }} Unit
                </h2>
            </div>

            <i class="fa-solid fa-boxes-stacked text-3xl text-gray-400"></i>

        </div>

    </div>

    <div class="panel p-5">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm text-gray-500">
                    Stok Menipis{{ $cakupan }}
                </p>

                <h2 class="text-2xl font-bold text-red-700 mt-1">
                    {{ $stokMenipis }} Item
                </h2>
            </div>

            <i class="fa-solid fa-circle-exclamation text-3xl text-red-600"></i>

        </div>

    </div>

</div>

<!-- Tabel Gudang -->
<section class="panel">

    <div class="panel-title">
        <i class="fa-solid fa-boxes-stacked mr-2"></i>
        Data Stok Laptop
    </div>

    <!-- Pencarian dan Filter -->
    <div class="p-4 flex flex-wrap gap-3 border-b border-gray-200">

        <input type="search"
               id="searchGudang"
               placeholder="Cari nama laptop atau spesifikasi..."
               aria-label="Cari laptop"
               class="form-input flex-1 min-w-[180px]">

        <select id="filterStok"
                aria-label="Filter stok"
                class="form-input sm:!w-48">

            <option value="all">Semua Status</option>
            <option value="available">Stok Tersedia</option>
            <option value="low">Stok Menipis</option>
            <option value="empty">Stok Habis</option>

        </select>

    </div>

    <div class="overflow-x-auto">

        <table class="data-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Laptop</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                    <th>Harga Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="gudangTable">

                @foreach($gudangs as $item)

                    <tr class="gudang-row"
                        data-search="{{ $item->nama_laptop }} {{ $item->spesifikasi }}"
                        data-stock="{{ $item->stok }}">

                        <td class="text-gray-500">
                            #{{ $item->id }}
                        </td>

                        <td class="font-semibold">
                            {{ $item->nama_laptop }}
                        </td>

                        <td class="min-w-[200px]">
                            {{ $item->spesifikasi }}
                        </td>

                        <td class="whitespace-nowrap">

                            @if($item->stok > 5)

                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                    {{ $item->stok }} Unit
                                </span>

                            @elseif($item->stok > 0)

                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">
                                    Sisa {{ $item->stok }} Unit
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">
                                    Habis
                                </span>

                            @endif

                        </td>

                        <td class="font-semibold whitespace-nowrap">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        <td>

                            <div class="flex items-center gap-2">

                                <button type="button"
                                        data-url="{{ \Illuminate\Support\Facades\Route::has('gudang.update') ? route('gudang.update', $item->id) : url('/gudang/' . $item->id) }}"
                                        data-nama="{{ $item->nama_laptop }}"
                                        data-stok="{{ $item->stok }}"
                                        data-harga="{{ $item->harga }}"
                                        onclick="openEditModal(this)"
                                        class="border border-blue-300 text-blue-700 hover:bg-blue-50 rounded px-3 py-1.5 text-xs whitespace-nowrap">

                                    <i class="fa-solid fa-pen mr-1"></i>
                                    Edit

                                </button>

                                <form action="{{ route('gudang.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus laptop ini dari gudang?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="border border-red-300 text-red-700 hover:bg-red-50 rounded px-3 py-1.5 text-xs whitespace-nowrap">

                                        <i class="fa-solid fa-trash mr-1"></i>
                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

                <tr id="emptyGudang" hidden>
                    <td colspan="6" class="!text-center text-gray-500 !py-10">
                        Tidak ada data laptop yang ditemukan.
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    @if(method_exists($gudangs, 'links'))
        <div class="p-4 border-t border-gray-200">
            {{ $gudangs->links() }}

            <p class="text-xs text-gray-500 mt-2">
                Pencarian dan filter berlaku pada halaman yang sedang ditampilkan.
            </p>
        </div>
    @endif

</section>

<!-- Modal Tambah Laptop -->
<dialog id="modalTambah" class="modal-box">

    <div class="panel-title flex justify-between items-center">

        <span>Tambah Laptop Baru</span>

        <button type="button"
                onclick="document.getElementById('modalTambah').close()"
                aria-label="Tutup"
                class="text-gray-500 hover:text-red-700">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    <form action="{{ route('gudang.store') }}"
          method="POST"
          class="p-5 space-y-4">

        @csrf

        <div>
            <label for="namaTambah" class="form-label">
                Nama / Merek Laptop
            </label>

            <input type="text"
                   name="nama_laptop"
                   id="namaTambah"
                   class="form-input"
                   placeholder="Contoh: ASUS Vivobook 14"
                   required>
        </div>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label for="stokTambah" class="form-label">
                    Stok (Unit)
                </label>

                <input type="number"
                       id="stokTambah"
                       name="stok"
                       min="0"
                       step="1"
                       class="form-input"
                       required>
            </div>

            <div>
                <label for="hargaTambah" class="form-label">
                    Harga (Rp)
                </label>

                <input type="number"
                       id="hargaTambah"
                       name="harga"
                       min="0"
                       step="1"
                       class="form-input"
                       required>
            </div>

        </div>

        <div>
            <label for="spesifikasiTambah" class="form-label">
                Spesifikasi Lengkap
            </label>

            <textarea name="spesifikasi"
                      id="spesifikasiTambah"
                      rows="4"
                      class="form-input"
                      placeholder="Prosesor, RAM, penyimpanan, dan lainnya"
                      required></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-3 border-t">

            <button type="button"
                    onclick="document.getElementById('modalTambah').close()"
                    class="btn-secondary">

                Batal

            </button>

            <button type="submit" class="btn-primary">
                Simpan Laptop
            </button>

        </div>

    </form>

</dialog>

<!-- Modal Edit Laptop -->
<dialog id="editModal" class="modal-box">

    <div class="panel-title flex justify-between items-center">

        <span>Edit Data Laptop</span>

        <button type="button"
                onclick="document.getElementById('editModal').close()"
                aria-label="Tutup"
                class="text-gray-500 hover:text-red-700">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    <form id="editForm"
          method="POST"
          class="p-5 space-y-4">

        @csrf
        @method('PUT')

        <div>

            <label for="editNama" class="form-label">
                Nama Laptop
            </label>

            <input type="text"
                   name="nama_laptop"
                   id="editNama"
                   class="form-input"
                   required>

        </div>

        <div class="grid grid-cols-2 gap-4">

            <div>

                <label for="editStok" class="form-label">
                    Stok (Unit)
                </label>

                <input type="number"
                       name="stok"
                       id="editStok"
                       min="0"
                       step="1"
                       class="form-input"
                       required>

            </div>

            <div>

                <label for="editHarga" class="form-label">
                    Harga (Rp)
                </label>

                <input type="number"
                       name="harga"
                       id="editHarga"
                       min="0"
                       step="1"
                       class="form-input"
                       required>

            </div>

        </div>

        <div class="flex justify-end gap-3 pt-3 border-t">

            <button type="button"
                    onclick="document.getElementById('editModal').close()"
                    class="btn-secondary">

                Batal

            </button>

            <button type="submit" class="btn-primary">
                Simpan Perubahan
            </button>

        </div>

    </form>

</dialog>

@endsection

@push('scripts')

<script>
    function openEditModal(button) {

        const data = button.dataset;

        document.getElementById('editForm').action = data.url;
        document.getElementById('editNama').value = data.nama;
        document.getElementById('editStok').value = data.stok;
        document.getElementById('editHarga').value = data.harga;

        document.getElementById('editModal').showModal();

    }

    function filterGudang() {

        const keyword = document.getElementById('searchGudang')
            .value.toLowerCase().trim();

        const status = document.getElementById('filterStok').value;

        const rows = document.querySelectorAll('.gudang-row');

        let jumlahTampil = 0;

        rows.forEach(row => {

            const stok = Number(row.dataset.stock);

            const cocokNama = row.dataset.search
                .toLowerCase()
                .includes(keyword);

            const cocokStok =
                status === 'all' ||
                (status === 'available' && stok > 0) ||
                (status === 'low' && stok > 0 && stok <= 5) ||
                (status === 'empty' && stok <= 0);

            row.hidden = !(cocokNama && cocokStok);

            if (!row.hidden) {
                jumlahTampil++;
            }

        });

        document.getElementById('emptyGudang').hidden =
            jumlahTampil !== 0;

    }

    document.getElementById('searchGudang')
        .addEventListener('input', filterGudang);

    document.getElementById('filterStok')
        .addEventListener('change', filterGudang);

    filterGudang();

</script>

@endpush