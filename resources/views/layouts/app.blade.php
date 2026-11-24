<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TechLaptop POS')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        [hidden] {
            display: none !important;
        }

        /* Panel */

        .panel {
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            min-width: 0;
            overflow: hidden;
        }

        .panel-title {
            padding: 13px 16px;
            background: #eceef0;
            border-bottom: 1px solid #d1d5db;
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Form */

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151;
        }

        .form-input {
            display: block;
            width: 100%;
            background: #ffffff;
            border: 1px solid #cbd0d6;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
            color: #1f2937;
        }

        .form-input:focus {
            border-color: #b91c1c;
            outline: 2px solid #fecaca;
        }

        /* Tombol */

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #b91c1c;
            color: white;
            border-color: #b91c1c;
        }

        .btn-primary:hover {
            background: #991b1b;
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background: #ffffff;
            border-color: #d1d5db;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
        }

        /* Tabel */

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .data-table thead {
            background: #eceef0;
            color: #374151;
        }

        .data-table th {
            padding: 12px 14px;
            font-weight: 700;
            white-space: nowrap;
            border-bottom: 1px solid #d1d5db;
        }

        .data-table td {
            padding: 13px 14px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Navigasi */

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            border-radius: 4px 4px 0 0;
        }

        .nav-link:hover {
            background: #f3f4f6;
            color: #b91c1c;
        }

        .nav-link.active {
            background: #b91c1c;
            color: white;
        }

        /* Modal */

        .modal-box {
            width: calc(100% - 32px);
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            margin: auto;
            padding: 0;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            color: #1f2937;
        }

        .modal-box::backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        /* Kartu Produk */

        .product-card {
            border: 1px solid #d1d5db;
            border-radius: 5px;
            background: #ffffff;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product-card:hover {
            border-color: #b91c1c;
        }

        .product-card.selected {
            border: 2px solid #b91c1c;
            background: #fffafa;
        }

        @media (max-width: 640px) {

            .nav-link {
                font-size: 12px;
                padding: 10px;
            }

            .data-table th,
            .data-table td {
                padding: 10px;
            }

        }

    </style>

    @stack('styles')

</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    @php

        $role = auth()->user()->role ?? '';

        $roleName = [
            'kasir' => 'Kasir',
            'admin_gudang' => 'Admin Gudang',
            'bos' => 'Bos'
        ];

    @endphp

    <!-- Header -->
    <header class="bg-white border-b-2 border-red-700">

        <div class="max-w-[1440px] mx-auto px-4 md:px-6">

            <div class="min-h-[70px] py-3 flex flex-wrap items-center justify-between gap-4">

                <!-- Logo -->
                <div class="flex items-center gap-4">

                    <a href="{{ route('katalog.index') }}"
                       class="flex items-center gap-3">

                        <i class="fa-solid fa-laptop text-3xl text-red-700"></i>

                        <span class="text-xl font-bold text-gray-900">

                            TechLaptop <span class="text-red-700">POS</span>

                        </span>

                    </a>

                    <span class="hidden lg:block border-l border-gray-300 pl-4 text-sm text-gray-500">

                        Sistem Penjualan Toko Laptop

                    </span>

                </div>

                <!-- Informasi Pengguna -->
                @auth

                    <div class="flex items-center gap-4">

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center">

                                <i class="fa-solid fa-user text-gray-600"></i>

                            </div>

                            <div>

                                <p class="font-semibold text-sm">

                                    {{ auth()->user()->name }}

                                </p>

                                <p class="text-xs text-gray-500">

                                    {{ $roleName[$role] ?? ucfirst($role) }}

                                </p>

                            </div>

                        </div>

                        <form action="{{ route('logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="border border-red-300 text-red-700 hover:bg-red-50 rounded px-3 py-2 text-sm font-semibold">

                                <i class="fa-solid fa-right-from-bracket mr-1"></i>

                                Keluar

                            </button>

                        </form>

                    </div>

                @else

                    <a href="{{ route('login') }}"
                       class="btn-primary">

                        Login Staff

                    </a>

                @endauth

            </div>

            <!-- Navigasi -->
            <nav class="flex flex-wrap gap-1">

                @if(in_array($role, ['kasir', 'bos']))

                    <a href="{{ route('transaksi.index') }}"
                       class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-cart-shopping"></i>

                        Transaksi Kasir

                    </a>

                @endif

                @if(in_array($role, ['admin_gudang', 'bos']))

                    <a href="{{ route('gudang.index') }}"
                       class="nav-link {{ request()->routeIs('gudang.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-boxes-stacked"></i>

                        Inventaris Gudang

                    </a>

                @endif

                <a href="{{ route('katalog.index') }}"
                   target="_blank"
                   rel="noopener"
                   class="nav-link">

                    <i class="fa-solid fa-store"></i>

                    Lihat Toko

                </a>

            </nav>

        </div>

    </header>

    <!-- Konten Utama -->
    <main class="flex-1 max-w-[1440px] w-full mx-auto px-4 md:px-6 py-6">

        <!-- Notifikasi Berhasil -->
        @if(session('success'))

            <div class="bg-green-50 border border-green-200 text-green-800 rounded px-4 py-3 mb-5 text-sm"
                 role="status">

                <i class="fa-solid fa-circle-check mr-2"></i>

                {{ session('success') }}

            </div>

        @endif

        <!-- Notifikasi Gagal -->
        @if(session('error'))

            <div class="bg-red-50 border border-red-200 text-red-700 rounded px-4 py-3 mb-5 text-sm"
                 role="alert">

                <i class="fa-solid fa-circle-exclamation mr-2"></i>

                {{ session('error') }}

            </div>

        @endif

        <!-- Validasi -->
        @if(isset($errors) && $errors->any())

            <div class="bg-red-50 border border-red-200 text-red-700 rounded px-4 py-3 mb-5 text-sm"
                 role="alert">

                <p class="font-semibold mb-1">
                    Periksa kembali data yang dimasukkan.
                </p>

                <ul class="list-disc pl-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-300 py-4">

        <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between gap-2 text-xs text-gray-500">

            <span>

                &copy; {{ date('Y') }} TechLaptop POS

            </span>

            <span>

                Sistem Manajemen Penjualan dan Inventaris

            </span>

        </div>

    </footer>

    @stack('scripts')

</body>

</html>