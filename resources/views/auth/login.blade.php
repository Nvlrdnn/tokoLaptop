<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechLaptop POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl space-y-6">
        
        <!-- Header / Logo -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-cyan-400 flex items-center justify-center text-white mx-auto shadow-lg shadow-indigo-500/30">
                <i class="fa-solid fa-laptop-code text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">TechLaptop POS</h1>
            <p class="text-xs text-slate-400">Silakan login menggunakan akun role Anda</p>
        </div>

        <!-- Alert Error -->
        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3 rounded-xl text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl text-xs">
                <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@toko.com" class="w-full bg-slate-800 border border-slate-700/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <!-- Ikon Gembok Kiri -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    
                    <!-- Input Password dengan ID inputPassword -->
                    <input type="password" name="password" id="inputPassword" placeholder="••••••••" class="w-full bg-slate-800 border border-slate-700/80 rounded-xl pl-10 pr-10 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" required>
                    
                    <!-- Tombol Toggle Mata Kanan -->
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-white transition">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition">
                Masuk Sistem &rarr;
            </button>
        </form>

        <!-- Informasi Akun Uji Coba -->
        <!--<div class="border-t border-slate-800 pt-4 space-y-2 text-xs text-slate-400">
            <p class="font-semibold text-slate-300">Daftar Akun Pengujian:</p>
            <div class="bg-slate-950/60 p-3 rounded-xl space-y-1 font-mono text-[11px]">
                <p><span class="text-indigo-400 font-bold">Admin Gudang:</span> admin@toko.com | gudang111</p>
                <p><span class="text-emerald-400 font-bold">Kasir:</span> kasir@toko.com | kasir321</p>
                <p><span class="text-amber-400 font-bold">Bos:</span> bos@toko.com | bos123</p>
            </div>
        </div>-->
    </div>

    <script>
    function togglePasswordVisibility() {
        const inputPassword = document.getElementById('inputPassword');
        const eyeIcon = document.getElementById('eyeIcon');

        if (inputPassword.type === 'password') {
            inputPassword.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            inputPassword.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>

</body>
</html>