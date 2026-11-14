<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechLaptop Store - Pusat Laptop Gaming & Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <!-- Top Info Bar ala Toko Komputer -->
    <div class="bg-indigo-600 text-white text-xs py-1.5 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-4">
                <span><i class="fa-solid fa-shield-halved mr-1"></i> Garansi Resmi 100% Original</span>
                <span class="hidden sm:inline"><i class="fa-solid fa-truck-fast mr-1"></i> Pengiriman Aman Packing Kayu</span>
            </div>
            <div class="flex items-center space-x-4 font-medium">
                <span><i class="fa-brands fa-whatsapp mr-1"></i> Konsultasi Rakit & Spek: 0812-3456-7890</span>
            </div>
        </div>
    </div>

    <!-- Main Navbar & Search -->
    <header class="bg-slate-900/95 backdrop-blur border-b border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3.5 flex flex-wrap items-center justify-between gap-4">
            
            <!-- Logo -->
            <a href="{{ route('katalog.index') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                    <i class="fa-solid fa-laptop-code text-xl"></i>
                </div>
                <div>
                    <span class="font-bold text-lg tracking-tight text-white block leading-none">TechLaptop</span>
                    <span class="text-[11px] text-cyan-400 font-semibold tracking-widest uppercase">Laptop Specialist</span>
                </div>
            </a>

            <!-- Live Search Bar -->
            <div class="flex-1 max-w-xl w-full order-3 md:order-2">
                <div class="relative">
                    <input type="text" id="searchInput" onkeyup="filterLaptops()" placeholder="Cari seri laptop, prosesor (i7, Ryzen 7, RTX 4060), atau merek..." class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
            </div>

            <!-- Tombol Akses Staff -->
            <div class="order-2 md:order-3">
                @auth
                    <a href="{{ auth()->user()->role === 'kasir' ? route('transaksi.index') : route('gudang.index') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-semibold flex items-center transition shadow-lg shadow-emerald-600/20">
                        <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard ({{ auth()->user()->name }})
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 px-4 py-2 rounded-xl text-xs font-semibold flex items-center transition">
                        <i class="fa-solid fa-user-lock mr-2 text-indigo-400"></i> Login Staff
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6 space-y-8">

        <!-- Hero Promo Banner Grid -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Banner Utama (Kiri - 2 Kolom) -->
            <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900 border border-indigo-500/30 p-6 sm:p-8 flex flex-col justify-between min-h-[240px]">
                <div class="relative z-10 max-w-lg space-y-3">
                    <span class="inline-block px-3 py-1 bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-bold rounded-full uppercase tracking-wider">
                        <i class="fa-solid fa-bolt mr-1"></i> Promo Spesial Bulan Ini
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
                        Upgrade Performa Kerja & Gaming Tanpa Kompromi
                    </h1>
                    <p class="text-sm text-slate-300">
                        Pilihan lengkap laptop Ultrabook tipis hingga seri Gaming RTX terbaru. Gratis instalasi Windows & Office siap pakai!
                    </p>
                    <div class="pt-2">
                        <a href="#katalog-produk" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-600/30 transition">
                            Lihat Katalog Stok <i class="fa-solid fa-arrow-down ml-2"></i>
                        </a>
                    </div>
                </div>
                <i class="fa-solid fa-laptop text-[180px] text-indigo-500/10 absolute -right-6 -bottom-6 rotate-12 pointer-events-none"></i>
            </div>

            <!-- Banner Samping (Kanan - 2 Kartu Promo) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                <div class="rounded-2xl bg-gradient-to-r from-cyan-950 to-slate-900 border border-cyan-500/30 p-5 flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-cyan-400 uppercase">Seri Mahasiswa & Office</span>
                        <h3 class="text-base font-bold text-white">Ringan, Baterai Awet</h3>
                        <p class="text-xs text-slate-400">Mulai dari Rp 5 Jutaan • Ready Stock</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/20 flex items-center justify-center text-cyan-400 text-xl shrink-0">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-r from-rose-950 to-slate-900 border border-rose-500/30 p-5 flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-rose-400 uppercase">Seri Gaming & Creator</span>
                        <h3 class="text-base font-bold text-white">RTX Series & Layar 144Hz+</h3>
                        <p class="text-xs text-slate-400">Bonus Tas Gaming & Mouse</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/20 flex items-center justify-center text-rose-400 text-xl shrink-0">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Merek Cepat -->
        <section id="katalog-produk" class="space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-white">Katalog Laptop Tersedia</h2>
                    <p class="text-xs text-slate-400">Stok terhubung langsung dengan sistem gudang kami (Real-Time)</p>
                </div>

                <!-- Tombol Filter Brand -->
                <div class="flex flex-wrap gap-2" id="brandFilters">
                    <button onclick="filterByBrand('all', this)" class="brand-btn active px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white transition">Semua Merek</button>
                    <button onclick="filterByBrand('asus', this)" class="brand-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">ASUS</button>
                    <button onclick="filterByBrand('lenovo', this)" class="brand-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">Lenovo</button>
                    <button onclick="filterByBrand('acer', this)" class="brand-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">Acer</button>
                    <button onclick="filterByBrand('hp', this)" class="brand-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">HP</button>
                    <button onclick="filterByBrand('apple', this)" class="brand-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">Apple / MacBook</button>
                </div>
            </div>

            <!-- Grid Kartu Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" id="laptopGrid">
                @forelse($laptops as $laptop)
                    @php
                        // Ambil kata pertama dari nama/merek untuk kategori filter otomatis
                        $brandTag = strtolower($laptop->merek ?? explode(' ', trim($laptop->nama_laptop))[0]);
                        $waMessage = urlencode("Halo Admin TechLaptop, saya tertarik dengan unit:\n*{$laptop->nama_laptop}*\nHarga: Rp " . number_format($laptop->harga_jual ?? $laptop->harga, 0, ',', '.') . "\nApakah unit ini masih ready?");
                    @endphp

                    <div class="laptop-card group bg-slate-900 border border-slate-800 hover:border-indigo-500/60 rounded-2xl overflow-hidden flex flex-col justify-between transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10"
                         data-name="{{ strtolower($laptop->nama_laptop . ' ' . ($laptop->spesifikasi ?? '') . ' ' . ($laptop->merek ?? '')) }}"
                         data-brand="{{ $brandTag }}">
                        
                        <div>
                            <!-- Area Visual Produk -->
                            <div class="relative h-44 bg-gradient-to-b from-slate-800/80 to-slate-900 p-4 flex items-center justify-center border-b border-slate-800/80">
                                <!-- Badge Stok -->
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                    Ready: {{ $laptop->stok }} Unit
                                </span>

                                <!-- Badge Merek -->
                                <span class="absolute top-3 right-3 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $laptop->merek ?? strtoupper(explode(' ', trim($laptop->nama_laptop))[0]) }}
                                </span>

                                <!-- Ilustrasi Icon Laptop -->
                                <i class="fa-solid fa-laptop text-6xl text-slate-600 group-hover:text-indigo-400 group-hover:scale-110 transition duration-300"></i>
                            </div>

                            <!-- Detail Spesifikasi -->
                            <div class="p-4 space-y-2.5">
                                <h3 class="font-bold text-sm text-white line-clamp-2 group-hover:text-indigo-400 transition">
                                    {{ $laptop->nama_laptop }}
                                </h3>

                                <!-- Kotak Spesifikasi Ringkas ala EnterKomputer -->
                                <div class="bg-slate-950/70 border border-slate-800/80 rounded-xl p-2.5 text-xs text-slate-400 space-y-1">
                                    <p class="line-clamp-3 leading-relaxed">
                                        <i class="fa-solid fa-microchip text-indigo-400 mr-1.5"></i>
                                        {{ $laptop->spesifikasi ?? 'Spesifikasi standar pabrik • Garansi Resmi' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Harga & Tombol Aksi -->
                        <div class="p-4 pt-0 space-y-3">
                            <div class="border-t border-slate-800/80 pt-3">
                                <span class="text-[11px] text-slate-400 block">Harga Cash / Tunai</span>
                                <span class="text-lg font-extrabold text-amber-400">
                                    Rp {{ number_format($laptop->harga_jual ?? $laptop->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button"
                                        onclick="openDetailModal('{{ addslashes($laptop->nama_laptop) }}', '{{ addslashes($laptop->merek ?? '-') }}', '{{ addslashes($laptop->spesifikasi ?? 'Hubungi admin untuk detail spesifikasi lengkap.') }}', 'Rp {{ number_format($laptop->harga_jual ?? $laptop->harga, 0, ',', '.') }}', '{{ $laptop->stok }}', 'https://wa.me/6281234567890?text={{ $waMessage }}')"
                                        class="py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-semibold transition text-center">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Detail
                                </button>

                                <a href="https://wa.me/6281234567890?text={{ $waMessage }}" target="_blank"
                                   class="py-2 px-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold transition text-center flex items-center justify-center">
                                    <i class="fa-brands fa-whatsapp mr-1.5 text-sm"></i> Pesan
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-slate-900 border border-slate-800 rounded-2xl p-12 text-center space-y-2">
                        <i class="fa-solid fa-box-open text-4xl text-slate-600"></i>
                        <h3 class="text-base font-bold text-slate-300">Belum Ada Unit Laptop Tersedia</h3>
                        <p class="text-xs text-slate-500">Silakan login sebagai Admin Gudang untuk menambahkan stok laptop ke dalam katalog.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-16 py-8 px-4 text-xs text-slate-400">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <span class="font-bold text-white">TechLaptop Store</span> &copy; {{ date('Y') }} — Pusat Penjualan Laptop & Aksesoris Terpercaya.
            </div>
            <div class="flex space-x-4">
                <span>Buka Setiap Hari: 09.00 - 21.00 WIB</span>
            </div>
        </div>
    </footer>

    <!-- Modal Detail Spesifikasi Produk -->
    <div id="detailModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl max-w-lg w-full p-6 space-y-5 shadow-2xl">
            <div class="flex justify-between items-start border-b border-slate-800 pb-3">
                <div>
                    <span id="modalBrand" class="text-[11px] font-bold uppercase tracking-wider text-indigo-400">BRAND</span>
                    <h3 id="modalTitle" class="text-lg font-bold text-white mt-0.5">Nama Laptop</h3>
                </div>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-white text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="space-y-3 text-sm">
                <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 space-y-1.5">
                    <span class="text-xs font-semibold text-slate-400 uppercase">Spesifikasi Teknis:</span>
                    <p id="modalSpecs" class="text-slate-200 leading-relaxed text-xs whitespace-pre-line"></p>
                </div>

                <div class="flex justify-between items-center bg-slate-800/50 p-3.5 rounded-xl">
                    <div>
                        <span class="text-xs text-slate-400 block">Harga Promo</span>
                        <span id="modalPrice" class="text-xl font-extrabold text-amber-400">Rp 0</span>
                    </div>
                    <span id="modalStock" class="px-3 py-1 rounded-lg text-xs font-bold bg-emerald-500/20 text-emerald-400">
                        Stok: 0
                    </span>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button onclick="closeDetailModal()" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                    Tutup
                </button>
                <a id="modalWaLink" href="#" target="_blank" class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center">
                    <i class="fa-brands fa-whatsapp mr-2 text-base"></i> Beli via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Script Pencarian, Filter Merek & Modal -->
    <script>
        let currentBrand = 'all';

        function filterByBrand(brand, btnElement) {
            currentBrand = brand;

            // Update tampilan tombol aktif
            document.querySelectorAll('.brand-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-slate-800', 'text-slate-300');
            });
            btnElement.classList.remove('bg-slate-800', 'text-slate-300');
            btnElement.classList.add('bg-indigo-600', 'text-white');

            filterLaptops();
        }

        function filterLaptops() {
            const keyword = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.laptop-card');

            cards.forEach(card => {
                const nameData = card.getAttribute('data-name');
                const brandData = card.getAttribute('data-brand');

                const matchesSearch = nameData.includes(keyword);
                const matchesBrand = (currentBrand === 'all') || brandData.includes(currentBrand) || nameData.includes(currentBrand);

                if (matchesSearch && matchesBrand) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function openDetailModal(title, brand, specs, price, stock, waUrl) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalBrand').innerText = brand;
            document.getElementById('modalSpecs').innerText = specs;
            document.getElementById('modalPrice').innerText = price;
            document.getElementById('modalStock').innerText = 'Ready: ' + stock + ' Unit';
            document.getElementById('modalWaLink').href = waUrl;

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>