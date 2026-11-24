<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TechLaptop Store - Katalog Laptop</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        [hidden] {
            display: none !important;
        }

        dialog {
            margin: auto;
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        .brand-btn.active {
            background: #b91c1c;
            color: white;
        }

        .brand-btn:not(.active):hover {
            background: #f3f4f6;
        }

    </style>

</head>

<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">

    <!-- Informasi Toko -->
    <div class="bg-red-700 text-white text-xs py-2">

        <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between gap-2">

            <span>
                <i class="fa-solid fa-shield-halved mr-1"></i>
                Garansi Resmi
            </span>

            <span>
                <i class="fa-brands fa-whatsapp mr-1"></i>
                Hubungi Kami: 0812-3456-7890
            </span>

        </div>

    </div>

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-300">

        <div class="max-w-7xl mx-auto px-4 py-5 flex flex-wrap items-center justify-between gap-5">

            <!-- Logo -->
            <a href="{{ route('katalog.index') }}"
               class="flex items-center gap-3">

                <i class="fa-solid fa-laptop text-4xl text-red-700"></i>

                <div>

                    <h1 class="text-2xl font-bold text-gray-900">
                        TechLaptop<span class="text-red-700"> Store</span>
                    </h1>

                    <p class="text-xs text-gray-500">
                        Pusat Penjualan Laptop
                    </p>

                </div>

            </a>

            <!-- Pencarian -->
            <div class="flex flex-1 min-w-[220px] max-w-xl order-3 md:order-none">

                <input type="search"
                       id="searchInput"
                       placeholder="Cari laptop, merek, atau spesifikasi..."
                       aria-label="Cari laptop"
                       class="w-full border border-gray-300 rounded-l px-4 py-2.5 text-sm focus:outline-none focus:border-red-600">

                <button type="button"
                        onclick="filterLaptops()"
                        aria-label="Cari"
                        class="bg-red-700 hover:bg-red-800 text-white px-5 rounded-r">

                    <i class="fa-solid fa-magnifying-glass"></i>

                </button>

            </div>

            <!-- Akses Staff -->
            <div>

                @auth

                    <a href="{{ auth()->user()->role === 'kasir' ? route('transaksi.index') : route('gudang.index') }}"
                       class="inline-flex items-center gap-2 border border-red-700 text-red-700 hover:bg-red-50 rounded px-4 py-2 text-sm font-semibold">

                        <i class="fa-solid fa-gauge"></i>

                        Dashboard

                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-100 rounded px-4 py-2 text-sm font-semibold">

                        <i class="fa-solid fa-user"></i>

                        Login Staff

                    </a>

                @endauth

            </div>

        </div>

        <!-- Menu Merek -->
        <div class="border-t border-gray-200">

            <nav class="max-w-7xl mx-auto px-4 flex flex-wrap text-sm font-medium">

                <a href="#katalog-produk"
                   onclick="filterByBrand('all')"
                   class="bg-red-700 text-white px-5 py-3">

                    <i class="fa-solid fa-list mr-2"></i>
                    Semua Produk

                </a>

                @foreach(['ASUS', 'Lenovo', 'Acer', 'HP', 'Apple', 'MSI', 'Dell'] as $brand)

                    <a href="#katalog-produk"
                       data-nav-brand="{{ strtolower($brand) }}"
                       class="px-5 py-3 hover:bg-gray-100 hover:text-red-700">

                        {{ $brand }}

                    </a>

                @endforeach

            </nav>

        </div>

    </header>

    <main class="max-w-7xl mx-auto px-4 py-6 w-full flex-1">

        <!-- Banner -->
        <section class="bg-white border border-gray-300 rounded-md mb-6 overflow-hidden">

            <div class="flex flex-col md:flex-row items-center">

                <div class="flex-1 p-7 md:p-10">

                    <p class="text-sm text-red-700 font-semibold mb-3">
                        TECHLAPTOP STORE
                    </p>

                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-3">

                        Laptop untuk Kerja,<br>
                        Kuliah, dan Gaming

                    </h2>

                    <p class="text-gray-600 text-sm max-w-md mb-6">

                        Temukan laptop sesuai kebutuhan Anda dengan informasi
                        spesifikasi, harga, dan stok yang tersedia.

                    </p>

                    <a href="#katalog-produk"
                       class="inline-flex bg-red-700 hover:bg-red-800 text-white px-5 py-3 rounded text-sm font-semibold">

                        Lihat Produk

                        <i class="fa-solid fa-arrow-right ml-2"></i>

                    </a>

                </div>

                <div class="w-full md:w-2/5 bg-gray-50 flex items-center justify-center min-h-[240px]">

                    <i class="fa-solid fa-laptop text-[130px] text-gray-400"></i>

                </div>

            </div>

        </section>

        <!-- Katalog -->
        <section id="katalog-produk"
                 class="grid grid-cols-1 lg:grid-cols-[220px_minmax(0,1fr)] gap-5">

            <!-- Sidebar Filter -->
            <aside class="bg-white border border-gray-300 rounded-md h-fit">

                <h3 class="bg-gray-200 px-4 py-3 font-bold border-b">

                    <i class="fa-solid fa-filter mr-2"></i>
                    Filter Produk

                </h3>

                <div class="p-4">

                    <h4 class="font-semibold mb-3">
                        Merek Laptop
                    </h4>

                    <div id="brandFilters"
                         class="space-y-1 text-sm">

                        <button type="button"
                                data-brand-filter="all"
                                class="brand-btn active text-left w-full px-3 py-2 rounded">

                            Semua Merek

                        </button>

                        @foreach(['ASUS', 'Lenovo', 'Acer', 'HP', 'Apple', 'MSI', 'Dell'] as $brand)

                            <button type="button"
                                    data-brand-filter="{{ strtolower($brand) }}"
                                    class="brand-btn text-left w-full px-3 py-2 rounded">

                                {{ $brand }}

                            </button>

                        @endforeach

                    </div>

                    <hr class="my-5">

                    <h4 class="font-semibold mb-3">
                        Ketersediaan
                    </h4>

                    <label class="flex items-center gap-2 text-sm cursor-pointer">

                        <input type="checkbox"
                               id="availableOnly"
                               class="accent-red-700">

                        Stok tersedia saja

                    </label>

                    <hr class="my-5">

                    <h4 class="font-semibold mb-3">
                        Urutkan Harga
                    </h4>

                    <select id="sortPrice"
                            class="w-full border border-gray-300 rounded p-2 text-sm">

                        <option value="default">Default</option>

                        <option value="asc">Termurah</option>

                        <option value="desc">Termahal</option>

                    </select>

                </div>

            </aside>

            <!-- Produk -->
            <div>

                <div class="flex flex-wrap justify-between items-center gap-2 mb-4">

                    <div>

                        <h2 class="text-2xl font-bold">
                            Katalog Laptop
                        </h2>

                        <p class="text-sm text-gray-500">
                            Pilih laptop yang sesuai dengan kebutuhan Anda.
                        </p>

                    </div>

                    <span id="productCount"
                          class="text-sm text-gray-500"></span>

                </div>

                <div id="laptopGrid"
                     class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

                    @foreach($laptops as $laptop)

                        @php

                            $brand = $laptop->merek
                                ?? explode(' ', trim($laptop->nama_laptop))[0];

                            $harga = $laptop->harga_jual ?? $laptop->harga;

                            $waMessage = urlencode(
                                "Halo Admin TechLaptop, saya tertarik dengan:\n"
                                . $laptop->nama_laptop
                                . "\nHarga: Rp "
                                . number_format($harga, 0, ',', '.')
                                . "\nApakah unit ini masih tersedia?"
                            );

                            $waUrl = 'https://wa.me/6281234567890?text=' . $waMessage;

                        @endphp

                        <article class="laptop-card bg-white border border-gray-300 rounded-md overflow-hidden flex flex-col hover:border-red-400"
                                 data-brand="{{ strtolower($brand) }}"
                                 data-search="{{ $laptop->nama_laptop }} {{ $laptop->spesifikasi ?? '' }} {{ $brand }}"
                                 data-price="{{ $harga }}"
                                 data-stock="{{ $laptop->stok }}"
                                 data-order="{{ $loop->index }}">

                            <!-- Gambar Produk -->
                            <div class="h-40 bg-gray-50 border-b border-gray-200 flex items-center justify-center relative">

                                <i class="fa-solid fa-laptop text-7xl text-gray-400"></i>

                                <span class="absolute top-3 left-3 text-xs font-semibold bg-white border px-2 py-1 rounded">

                                    {{ strtoupper($brand) }}

                                </span>

                            </div>

                            <div class="p-4 flex flex-col flex-1">

                                <h3 class="font-semibold text-gray-900 mb-2">

                                    {{ $laptop->nama_laptop }}

                                </h3>

                                <p class="text-xs text-gray-500 line-clamp-3 mb-4">

                                    {{ $laptop->spesifikasi ?? 'Hubungi toko untuk informasi spesifikasi.' }}

                                </p>

                                <p class="text-xl font-bold text-red-700 mb-2">

                                    Rp {{ number_format($harga, 0, ',', '.') }}

                                </p>

                                <div class="mb-4">

                                    @if($laptop->stok > 0)

                                        <span class="text-xs bg-green-100 text-green-800 rounded px-2 py-1">

                                            Stok: {{ $laptop->stok }} Unit

                                        </span>

                                    @else

                                        <span class="text-xs bg-red-100 text-red-700 rounded px-2 py-1">

                                            Stok Habis

                                        </span>

                                    @endif

                                </div>

                                <div class="grid grid-cols-2 gap-2 mt-auto">

                                    <button type="button"
                                            data-title="{{ $laptop->nama_laptop }}"
                                            data-brand="{{ $brand }}"
                                            data-specs="{{ $laptop->spesifikasi ?? '-' }}"
                                            data-price="Rp {{ number_format($harga, 0, ',', '.') }}"
                                            data-stock="{{ $laptop->stok }}"
                                            data-wa="{{ $waUrl }}"
                                            onclick="openDetailModal(this)"
                                            class="border border-gray-300 hover:bg-gray-100 py-2 rounded text-sm font-medium">

                                        Detail

                                    </button>

                                    @if($laptop->stok > 0)

                                        <a href="{{ $waUrl }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="bg-red-700 hover:bg-red-800 text-white text-center py-2 rounded text-sm font-medium">

                                            <i class="fa-brands fa-whatsapp mr-1"></i>

                                            Pesan

                                        </a>

                                    @else

                                        <button type="button"
                                                disabled
                                                class="bg-gray-200 text-gray-500 py-2 rounded text-sm cursor-not-allowed">

                                            Habis

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

                <div id="emptyCatalog"
                     class="bg-white border border-gray-300 rounded-md py-12 text-center"
                     hidden>

                    <i class="fa-solid fa-box-open text-4xl text-gray-400 mb-4"></i>

                    <p class="font-semibold">
                        Tidak ada laptop yang ditemukan.
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Coba gunakan kata kunci atau filter lainnya.
                    </p>

                </div>

            </div>

        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-300 mt-8">

        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap justify-between gap-5 text-sm">

            <div>

                <h3 class="font-bold text-lg">

                    TechLaptop <span class="text-red-700">Store</span>

                </h3>

                <p class="text-gray-500 mt-1">
                    Pusat Penjualan Laptop dan Aksesoris
                </p>

            </div>

            <div class="text-gray-600">

                <p>Jam Operasional</p>

                <p>Setiap Hari, 09.00 - 21.00 WIB</p>

            </div>

            <div class="text-gray-600">

                <p>Hubungi Kami</p>

                <p>0812-3456-7890</p>

            </div>

        </div>

        <div class="border-t border-gray-200 text-center text-xs text-gray-500 py-4">

            &copy; {{ date('Y') }} TechLaptop Store

        </div>

    </footer>

    <!-- Modal Detail -->
    <dialog id="detailModal"
            class="w-[calc(100%-2rem)] max-w-lg max-h-[90vh] overflow-y-auto bg-white rounded-md border border-gray-300 p-0">

        <div class="bg-gray-200 px-5 py-4 flex justify-between items-center border-b">

            <h3 class="font-bold text-lg">
                Detail Laptop
            </h3>

            <button type="button"
                    onclick="document.getElementById('detailModal').close()"
                    aria-label="Tutup">

                <i class="fa-solid fa-xmark text-xl"></i>

            </button>

        </div>

        <div class="p-5 space-y-4">

            <div>

                <p id="modalBrand"
                   class="text-sm font-semibold text-red-700"></p>

                <h2 id="modalTitle"
                    class="text-xl font-bold"></h2>

            </div>

            <div class="bg-gray-50 p-4 border rounded">

                <h4 class="font-semibold mb-2">
                    Spesifikasi
                </h4>

                <p id="modalSpecs"
                   class="text-sm text-gray-600 whitespace-pre-line"></p>

            </div>

            <div class="bg-gray-100 p-4 rounded">

                <p class="text-sm text-gray-500">
                    Harga
                </p>

                <p id="modalPrice"
                   class="text-2xl font-bold text-red-700"></p>

                <p id="modalStock"
                   class="text-sm mt-2"></p>

            </div>

            <div class="flex gap-3">

                <button type="button"
                        onclick="document.getElementById('detailModal').close()"
                        class="flex-1 border border-gray-300 rounded py-2.5">

                    Tutup

                </button>

                <a id="modalWaLink"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="flex-1 bg-red-700 hover:bg-red-800 text-white text-center rounded py-2.5">

                    <i class="fa-brands fa-whatsapp mr-1"></i>

                    Pesan Sekarang

                </a>

            </div>

        </div>

    </dialog>

    <script>

        let currentBrand = 'all';

        const grid = document.getElementById('laptopGrid');

        const cards = Array.from(
            document.querySelectorAll('.laptop-card')
        );

        function filterByBrand(brand) {

            currentBrand = brand;

            document.querySelectorAll('.brand-btn').forEach(button => {

                button.classList.toggle(
                    'active',
                    button.dataset.brandFilter === brand
                );

            });

            filterLaptops();

        }

        function filterLaptops() {

            const keyword = document.getElementById('searchInput')
                .value.toLowerCase().trim();

            const availableOnly =
                document.getElementById('availableOnly').checked;

            let count = 0;

            cards.forEach(card => {

                const nama = card.dataset.search.toLowerCase();

                const brand = card.dataset.brand.toLowerCase();

                const stok = Number(card.dataset.stock);

                const cocokNama = nama.includes(keyword);

                const cocokBrand =
                    currentBrand === 'all' ||
                    brand === currentBrand ||
                    (currentBrand === 'apple' && brand === 'macbook');

                const cocokStok =
                    !availableOnly || stok > 0;

                card.hidden = !(cocokNama && cocokBrand && cocokStok);

                if (!card.hidden) {
                    count++;
                }

            });

            document.getElementById('productCount').textContent =
                count + ' produk ditemukan';

            document.getElementById('emptyCatalog').hidden =
                count !== 0;

        }

        function sortProducts() {

            const sort = document.getElementById('sortPrice').value;

            const sorted = [...cards].sort((a, b) => {

                if (sort === 'asc') {
                    return Number(a.dataset.price) - Number(b.dataset.price);
                }

                if (sort === 'desc') {
                    return Number(b.dataset.price) - Number(a.dataset.price);
                }

                return Number(a.dataset.order) - Number(b.dataset.order);

            });

            sorted.forEach(card => grid.appendChild(card));

        }

        function openDetailModal(button) {

            const data = button.dataset;

            document.getElementById('modalTitle').textContent = data.title;

            document.getElementById('modalBrand').textContent = data.brand;

            document.getElementById('modalSpecs').textContent = data.specs;

            document.getElementById('modalPrice').textContent = data.price;

            document.getElementById('modalStock').textContent =
                'Stok: ' + data.stock + ' Unit';

            const waLink = document.getElementById('modalWaLink');

            waLink.href = data.wa;

            waLink.hidden = Number(data.stock) <= 0;

            document.getElementById('detailModal').showModal();

        }

        document.querySelectorAll('[data-brand-filter]').forEach(button => {

            button.addEventListener('click', () => {
                filterByBrand(button.dataset.brandFilter);
            });

        });

        document.querySelectorAll('[data-nav-brand]').forEach(link => {

            link.addEventListener('click', () => {
                filterByBrand(link.dataset.navBrand);
            });

        });

        document.getElementById('searchInput')
            .addEventListener('input', filterLaptops);

        document.getElementById('availableOnly')
            .addEventListener('change', filterLaptops);

        document.getElementById('sortPrice')
            .addEventListener('change', sortProducts);

        filterLaptops();

    </script>

</body>
</html>