<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Laptop App')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col font-sans">

    <!-- Header Navigation -->
    <header class="bg-slate-800/80 backdrop-blur border-b border-slate-700/60 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-laptop-code text-xl"></i>
                    </div>
                    <span class="font-bold text-lg bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">TechLaptop POS</span>
                </div>

                <!-- Navigation Links Berdasarkan Role -->
                <nav class="flex space-x-2">
                    @if(in_array(auth()->user()->role, ['admin_gudang', 'bos']))
                        <a href="{{ route('gudang.index') }}" class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('gudang.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                            <i class="fa-solid fa-boxes-stacked mr-1.5"></i> Inventaris Gudang
                        </a>
                    @endif

                    @if(in_array(auth()->user()->role, ['kasir', 'bos']))
                        <a href="{{ route('transaksi.index') }}" class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('transaksi.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                            <i class="fa-solid fa-cash-register mr-1.5"></i> POS Kasir
                        </a>
                    @endif
                </nav>
            </div>

            <!-- User Info & Logout Button -->
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-semibold text-white">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-indigo-400 uppercase font-bold tracking-wider">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center transition">
                        <i class="fa-solid fa-right-from-bracket mr-1.5"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6">
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Toko Laptop 
    </footer>

    @stack('scripts')
</body>
</html>