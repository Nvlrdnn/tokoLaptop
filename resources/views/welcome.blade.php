@extends('layouts.app')

@section('title', 'Transaksi Kasir - TechLaptop POS')

@section('content')

<!-- Judul Halaman -->
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">

    <div>

        <h1 class="text-2xl font-bold text-gray-900">

            Transaksi Kasir

        </h1>

        <p class="text-sm text-gray-500 mt-1">

            Catat penjualan laptop dan lihat riwayat transaksi.

        </p>

    </div>

    <!-- Pilihan Tampilan -->
    <div class="flex flex-wrap gap-2">

        <button type="button"
                id="btnForm"
                onclick="changeMode('form')"
                aria-pressed="true"
                class="btn-primary">

            <i class="fa-solid fa-list mr-2"></i>

            Form Penjualan

        </button>

        <button type="button"
                id="btnCatalog"
                onclick="changeMode('catalog')"
                aria-pressed="false"
                class="btn-secondary">

            <i class="fa-solid fa-table-cells mr-2"></i>

            Katalog Laptop

        </button>

    </div>

</div>

<!-- Konten Transaksi -->
<div id="transactionLayout"
     class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

    <!-- Form Pembayaran -->
    <section id="paymentPanel" class="panel lg:col-span-1">

        <h2 class="panel-title">

            <i class="fa-solid fa-cart-shopping mr-2"></i>

            Penjualan Laptop

        </h2>

        <form action="{{ route('transaksi.store') }}"
              method="POST"
              id="formKasir"
              class="p-5 space-y-5">

            @csrf

            <!-- Pilih Laptop -->
            <div>

                <label for="selectLaptop" class="form-label">

                    Pilih Laptop

                </label>

                <select name="gudang_id"
                        id="selectLaptop"
                        onchange="updateHarga()"
                        class="form-input"
                        required>

                    <option value="" data-harga="0" data-stok="0">

                        -- Pilih Unit Laptop --

                    </option>

                    @foreach($laptops as $laptop)

                        <option value="{{ $laptop->id }}"
                                data-harga="{{ $laptop->harga }}"
                                data-stok="{{ $laptop->stok }}"
                                {{ $laptop->stok <= 0 ? 'disabled' : '' }}
                                {{ (string) old('gudang_id') === (string) $laptop->id && $laptop->stok > 0 ? 'selected' : '' }}>

                            {{ $laptop->nama_laptop }}

                            (Stok: {{ $laptop->stok }})

                            - Rp {{ number_format($laptop->harga, 0, ',', '.') }}

                        </option>

                    @endforeach

                </select>

                <p id="infoLaptop"
                   class="text-xs text-gray-500 mt-2">

                    Pilih laptop yang akan dibeli.

                </p>

            </div>

            <!-- Jumlah Pembelian -->
            <div>

                <label for="inputJumlah" class="form-label">

                    Jumlah Pembelian

                </label>

                <div class="flex items-center">

                    <button type="button"
                            onclick="changeQuantity(-1)"
                            aria-label="Kurangi jumlah"
                            class="border border-gray-300 bg-gray-100 hover:bg-gray-200 rounded-l px-4 py-2.5">

                        <i class="fa-solid fa-minus"></i>

                    </button>

                    <input type="number"
                           name="jumlah"
                           id="inputJumlah"
                           value="{{ old('jumlah', 1) }}"
                           min="1"
                           step="1"
                           oninput="hitungTotal()"
                           class="w-full border-y border-gray-300 py-2.5 text-center text-sm focus:outline-none"
                           required>

                    <button type="button"
                            onclick="changeQuantity(1)"
                            aria-label="Tambah jumlah"
                            class="border border-gray-300 bg-gray-100 hover:bg-gray-200 rounded-r px-4 py-2.5">

                        <i class="fa-solid fa-plus"></i>

                    </button>

                </div>

                <p id="stockWarning"
                   class="text-xs text-red-700 mt-2"
                   aria-live="polite"></p>

            </div>

            <!-- Uang Pembayaran -->
            <div>

                <label for="inputBayar" class="form-label">

                    Uang Bayar (Rp)

                </label>

                <input type="number"
                       name="bayar"
                       id="inputBayar"
                       value="{{ old('bayar') }}"
                       min="0"
                       step="1"
                       placeholder="Masukkan nominal pembayaran"
                       oninput="hitungKembalian()"
                       class="form-input"
                       required>

                <button type="button"
                        onclick="bayarPas()"
                        class="mt-2 text-sm text-red-700 hover:underline">

                    Gunakan Uang Pas

                </button>

            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="bg-gray-100 border border-gray-200 rounded p-4 space-y-3"
                 aria-live="polite">

                <div class="flex flex-wrap justify-between items-center gap-2">

                    <span class="font-semibold text-sm">

                        Total Tagihan

                    </span>

                    <span id="labelTotal"
                          class="text-xl font-bold text-red-700">

                        Rp 0

                    </span>

                </div>

                <hr class="border-gray-300">

                <div class="flex flex-wrap justify-between items-center gap-2">

                    <span class="font-semibold text-sm">

                        Kembalian

                    </span>

                    <span id="labelKembali"
                          class="text-lg font-bold text-gray-800">

                        Rp 0

                    </span>

                </div>

            </div>

            <p id="paymentWarning"
               class="text-sm text-red-700"
               aria-live="polite"></p>

            <!-- Tombol Simpan -->
            <button type="submit"
                    id="btnSimpan"
                    class="btn-primary w-full">

                <i class="fa-solid fa-floppy-disk mr-2"></i>

                Simpan Transaksi

            </button>

        </form>

    </section>

    <!-- Riwayat Transaksi -->
    <section id="historyPanel" class="panel lg:col-span-2">

        <h2 class="panel-title">

            <i class="fa-solid fa-receipt mr-2"></i>

            Riwayat Penjualan

        </h2>

        <div class="p-4 border-b border-gray-200">

            <div class="flex items-center">

                <input type="search"
                       id="searchTransaksi"
                       oninput="filterTransaksi()"
                       placeholder="Cari kode transaksi atau nama laptop..."
                       aria-label="Cari transaksi"
                       class="form-input">

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="data-table">

                <thead>

                    <tr>

                        <th>Kode TRX</th>

                        <th>Nama Laptop</th>

                        <th>Jumlah</th>

                        <th>Total</th>

                        <th>Bayar</th>

                        <th>Kembali</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($transaksis as $trx)

                        <tr class="transaction-row"
                            data-search="{{ $trx->kode_transaksi }} {{ $trx->gudangs->pluck('nama_laptop')->implode(' ') }}">

                            <td class="font-semibold whitespace-nowrap">

                                {{ $trx->kode_transaksi }}

                            </td>

                            <td class="min-w-[140px]">

                                @forelse($trx->gudangs as $laptop)

                                    <div>

                                        {{ $laptop->nama_laptop }}

                                    </div>

                                @empty

                                    <span class="text-gray-500">

                                        Detail tidak tersedia

                                    </span>

                                @endforelse

                            </td>

                            <td class="whitespace-nowrap">

                                @forelse($trx->gudangs as $laptop)

                                    <div>

                                        {{ $laptop->pivot->jumlah }} Unit

                                    </div>

                                @empty

                                    -

                                @endforelse

                            </td>

                            <td class="font-semibold whitespace-nowrap">

                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}

                            </td>

                            <td class="whitespace-nowrap">

                                Rp {{ number_format($trx->bayar, 0, ',', '.') }}

                            </td>

                            <td class="text-green-700 whitespace-nowrap">

                                Rp {{ number_format($trx->kembali, 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="!text-center !py-12 text-gray-500">

                                <i class="fa-solid fa-receipt text-3xl block mb-3"></i>

                                Belum ada riwayat transaksi.

                            </td>

                        </tr>

                    @endforelse

                    <tr id="emptyTransaksi" hidden>

                        <td colspan="6"
                            class="!text-center !py-10 text-gray-500">

                            Transaksi tidak ditemukan.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        @if(method_exists($transaksis, 'links'))

            <div class="p-4 border-t border-gray-200">

                {{ $transaksis->links() }}

                <p class="text-xs text-gray-500 mt-2">

                    Pencarian berlaku pada halaman yang sedang ditampilkan.

                </p>

            </div>

        @endif

    </section>

    <!-- Katalog Kasir -->
    <section id="catalogPanel"
             class="panel lg:col-span-2"
             hidden>

        <h2 class="panel-title">

            <i class="fa-solid fa-laptop mr-2"></i>

            Daftar Laptop

        </h2>

        <div class="p-4">

            <!-- Pencarian Produk -->
            <div class="flex flex-wrap gap-3 mb-4">

                <input type="search"
                       id="searchLaptop"
                       placeholder="Cari nama laptop..."
                       aria-label="Cari laptop"
                       oninput="filterCatalog()"
                       class="form-input flex-1 min-w-[160px]">

                <select id="filterBrand"
                        onchange="filterCatalog()"
                        aria-label="Filter merek"
                        class="form-input sm:!w-40">

                    <option value="all">

                        Semua Merek

                    </option>

                </select>

            </div>

            <p id="catalogCount"
               class="text-sm text-gray-500 mb-4"></p>

            <!-- Kartu Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

                @foreach($laptops as $laptop)

                    @php

                        $brand = $laptop->merek
                            ?? explode(' ', trim($laptop->nama_laptop))[0];

                    @endphp

                    <article class="product-card catalog-item"
                             data-id="{{ $laptop->id }}"
                             data-brand="{{ strtolower($brand) }}"
                             data-search="{{ $laptop->nama_laptop }} {{ $brand }} {{ $laptop->spesifikasi ?? '' }}">

                        <div class="bg-gray-100 h-28 rounded flex items-center justify-center">

                            <i class="fa-solid fa-laptop text-5xl text-gray-400"></i>

                        </div>

                        <p class="text-xs font-semibold text-red-700">

                            {{ strtoupper($brand) }}

                        </p>

                        <h3 class="font-semibold text-sm">

                            {{ $laptop->nama_laptop }}

                        </h3>

                        <p class="text-lg font-bold text-red-700">

                            Rp {{ number_format($laptop->harga, 0, ',', '.') }}

                        </p>

                        <div class="mb-2">

                            @if($laptop->stok > 0)

                                <span class="bg-green-100 text-green-800 text-xs rounded px-2 py-1">

                                    Stok: {{ $laptop->stok }}

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 text-xs rounded px-2 py-1">

                                    Stok Habis

                                </span>

                            @endif

                        </div>

                        <button type="button"
                                data-id="{{ $laptop->id }}"
                                onclick="selectProduct(this.dataset.id)"
                                class="btn-primary w-full mt-auto"
                                {{ $laptop->stok <= 0 ? 'disabled' : '' }}>

                            <i class="fa-solid fa-cart-shopping mr-2"></i>

                            {{ $laptop->stok > 0 ? 'Pilih Laptop' : 'Stok Habis' }}

                        </button>

                    </article>

                @endforeach

            </div>

            <div id="catalogEmpty"
                 class="text-center text-gray-500 py-10"
                 hidden>

                Tidak ada laptop yang ditemukan.

            </div>

        </div>

    </section>

</div>

@endsection

@push('scripts')

<script>

    let hargaUnit = 0;

    let totalHarga = 0;

    const selectLaptop = document.getElementById('selectLaptop');

    const inputJumlah = document.getElementById('inputJumlah');

    const inputBayar = document.getElementById('inputBayar');

    const formKasir = document.getElementById('formKasir');

    const btnSimpan = document.getElementById('btnSimpan');

    // Format Rupiah

    function formatRupiah(angka) {

        return 'Rp ' + Math.round(angka).toLocaleString('id-ID');

    }

    // Memperbarui Harga dan Stok

    function updateHarga() {

        const option = selectLaptop.options[selectLaptop.selectedIndex];

        hargaUnit = Number(option.dataset.harga) || 0;

        const stok = Number(option.dataset.stok) || 0;

        if (selectLaptop.value) {

            inputJumlah.max = stok;

            document.getElementById('infoLaptop').textContent =

                'Stok tersedia: ' + stok +
                ' Unit | Harga: ' + formatRupiah(hargaUnit);

        } else {

            inputJumlah.removeAttribute('max');

            document.getElementById('infoLaptop').textContent =

                'Pilih laptop yang akan dibeli.';

        }

        document.querySelectorAll('.catalog-item').forEach(card => {

            card.classList.toggle(
                'selected',
                card.dataset.id === selectLaptop.value
            );

        });

        hitungTotal();

    }

    // Mengatur Jumlah Pembelian

    function changeQuantity(change) {

        let jumlah = Number(inputJumlah.value) || 1;

        jumlah += change;

        const option = selectLaptop.options[selectLaptop.selectedIndex];

        const stok = Number(option.dataset.stok) || 0;

        if (jumlah < 1) {
            jumlah = 1;
        }

        if (selectLaptop.value && stok > 0 && jumlah > stok) {
            jumlah = stok;
        }

        inputJumlah.value = jumlah;

        hitungTotal();

    }

    // Menghitung Total Tagihan

    function hitungTotal() {

        const jumlah = Number(inputJumlah.value);

        const option = selectLaptop.options[selectLaptop.selectedIndex];

        const stok = Number(option.dataset.stok) || 0;

        const warning = document.getElementById('stockWarning');

        if (selectLaptop.value && jumlah > stok) {

            warning.textContent =

                'Jumlah pembelian melebihi stok yang tersedia.';

        } else if (!Number.isInteger(jumlah) || jumlah < 1) {

            warning.textContent =

                'Jumlah pembelian minimal 1 unit.';

        } else {

            warning.textContent = '';

        }

        totalHarga = Number.isFinite(jumlah) && jumlah > 0

            ? hargaUnit * jumlah

            : 0;

        document.getElementById('labelTotal').textContent =

            formatRupiah(totalHarga);

        hitungKembalian();

    }

    // Menghitung Kembalian

    function hitungKembalian() {

        const bayar = Number(inputBayar.value) || 0;

        const kembali = bayar - totalHarga;

        const labelKembali = document.getElementById('labelKembali');

        const warning = document.getElementById('paymentWarning');

        warning.textContent = '';

        if (!selectLaptop.value || inputBayar.value === '') {

            labelKembali.textContent = 'Rp 0';

            labelKembali.className = 'text-lg font-bold text-gray-800';

        } else if (kembali >= 0) {

            labelKembali.textContent = formatRupiah(kembali);

            labelKembali.className = 'text-lg font-bold text-green-700';

        } else {

            labelKembali.textContent =

                'Kurang ' + formatRupiah(Math.abs(kembali));

            labelKembali.className = 'text-lg font-bold text-red-700';

            warning.textContent =

                'Uang pembayaran belum mencukupi.';

        }

        validateTransaction();

    }

    // Pembayaran Uang Pas

    function bayarPas() {

        if (!selectLaptop.value) {
            return;
        }

        inputBayar.value = totalHarga;

        hitungKembalian();

    }

    // Validasi Transaksi

    function validateTransaction() {

        const option = selectLaptop.options[selectLaptop.selectedIndex];

        const stok = Number(option.dataset.stok) || 0;

        const jumlah = Number(inputJumlah.value);

        const bayar = Number(inputBayar.value);

        const harga = Number(option.dataset.harga);

        const laptopValid = !!selectLaptop.value && !option.disabled;

        const hargaValid = Number.isFinite(harga) && harga >= 0;

        const jumlahValid =

            Number.isInteger(jumlah) &&
            jumlah >= 1 &&
            jumlah <= stok;

        const bayarValid =

            inputBayar.value !== '' &&
            Number.isFinite(bayar) &&
            bayar >= 0 &&
            bayar >= totalHarga;

        inputJumlah.setCustomValidity(

            laptopValid && !jumlahValid

                ? 'Jumlah pembelian harus sesuai stok.'

                : ''

        );

        inputBayar.setCustomValidity(

            laptopValid && jumlahValid && inputBayar.value !== '' && !bayarValid

                ? 'Uang pembayaran tidak mencukupi.'

                : ''

        );

        const valid =

            laptopValid &&
            hargaValid &&
            jumlahValid &&
            bayarValid &&
            formKasir.checkValidity();

        btnSimpan.disabled = !valid;

        return valid;

    }

    formKasir.addEventListener('submit', function(event) {

        hitungTotal();

        if (!validateTransaction()) {

            event.preventDefault();

            formKasir.reportValidity();

        } else {

            btnSimpan.disabled = true;

            btnSimpan.textContent = 'Menyimpan Transaksi...';

        }

    });

    // Memilih Laptop dari Katalog

    function selectProduct(id) {

        const option = Array.from(selectLaptop.options)
            .find(item => item.value === String(id));

        if (!option || option.disabled) {
            return;
        }

        selectLaptop.value = String(id);

        inputJumlah.value = 1;

        inputBayar.value = '';

        updateHarga();

        if (window.innerWidth < 1024) {

            document.getElementById('paymentPanel').scrollIntoView({

                behavior: 'smooth',

                block: 'start'

            });

        }

        inputJumlah.focus({ preventScroll: true });

    }

    // Mengganti Mode Tampilan

    function changeMode(mode) {

        const catalog = document.getElementById('catalogPanel');

        const payment = document.getElementById('paymentPanel');

        const history = document.getElementById('historyPanel');

        const layout = document.getElementById('transactionLayout');

        const btnForm = document.getElementById('btnForm');

        const btnCatalog = document.getElementById('btnCatalog');

        if (mode === 'catalog') {

            catalog.hidden = false;

            layout.appendChild(catalog);

            layout.appendChild(payment);

            layout.appendChild(history);

            history.className = 'panel lg:col-span-3';

            btnForm.className = 'btn-secondary';

            btnCatalog.className = 'btn-primary';

            btnForm.setAttribute('aria-pressed', 'false');

            btnCatalog.setAttribute('aria-pressed', 'true');

        } else {

            catalog.hidden = true;

            layout.appendChild(payment);

            layout.appendChild(history);

            layout.appendChild(catalog);

            history.className = 'panel lg:col-span-2';

            btnForm.className = 'btn-primary';

            btnCatalog.className = 'btn-secondary';

            btnForm.setAttribute('aria-pressed', 'true');

            btnCatalog.setAttribute('aria-pressed', 'false');

        }

    }

    // Filter Katalog Laptop

    function filterCatalog() {

        const keyword = document.getElementById('searchLaptop')

            .value.toLowerCase().trim();

        const brand = document.getElementById('filterBrand').value;

        let count = 0;

        document.querySelectorAll('.catalog-item').forEach(card => {

            const matchName = card.dataset.search

                .toLowerCase()

                .includes(keyword);

            const matchBrand =

                brand === 'all' || card.dataset.brand === brand;

            card.hidden = !(matchName && matchBrand);

            if (!card.hidden) {

                count++;

            }

        });

        document.getElementById('catalogCount').textContent =

            count + ' laptop ditampilkan';

        document.getElementById('catalogEmpty').hidden =

            count !== 0;

    }

    // Menampilkan Merek dari Data Gudang

    const brands = [

        ...new Set(

            Array.from(document.querySelectorAll('.catalog-item'))

                .map(card => card.dataset.brand)

        )

    ].sort();

    brands.forEach(brand => {

        const option = document.createElement('option');

        option.value = brand;

        option.textContent = brand.toUpperCase();

        document.getElementById('filterBrand').appendChild(option);

    });

    // Pencarian Riwayat Transaksi

    function filterTransaksi() {

        const keyword = document.getElementById('searchTransaksi')

            .value.toLowerCase().trim();

        const rows = document.querySelectorAll('.transaction-row');

        let count = 0;

        rows.forEach(row => {

            const match = row.dataset.search

                .toLowerCase()

                .includes(keyword);

            row.hidden = !match;

            if (match) {

                count++;

            }

        });

        document.getElementById('emptyTransaksi').hidden =

            count !== 0 || rows.length === 0;

    }

    // Inisialisasi

    updateHarga();

    filterCatalog();

</script>

@endpush