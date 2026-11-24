<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - TechLaptop POS</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col font-sans">

    <!-- Header -->
    <header class="bg-white border-b-2 border-red-700">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <a href="{{ route('katalog.index') }}" class="flex items-center gap-3">
                <i class="fa-solid fa-laptop text-red-700 text-3xl"></i>

                <span class="text-xl font-bold">
                    TechLaptop <span class="text-red-700">POS</span>
                </span>
            </a>

            <a href="{{ route('katalog.index') }}"
               class="text-sm text-gray-600 hover:text-red-700">
                Kembali ke Toko
            </a>

        </div>
    </header>

    <!-- Form Login -->
    <main class="flex-1 flex items-center justify-center p-5">

        <div class="w-full max-w-md bg-white border border-gray-300 rounded-md">

            <div class="px-7 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold">
                    Login Staff
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Masukkan email dan kata sandi akun Anda.
                </p>
            </div>

            <div class="p-7">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded mb-4 text-sm">

                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}"
                      method="POST"
                      class="space-y-5">

                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold mb-2">
                            Alamat Email
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan email"
                               autocomplete="username"
                               class="w-full border border-gray-300 rounded px-3 py-3 text-sm focus:outline-none focus:border-red-600"
                               required
                               autofocus>
                    </div>

                    <div>
                        <label for="inputPassword" class="block text-sm font-semibold mb-2">
                            Kata Sandi
                        </label>

                        <div class="relative">

                            <input type="password"
                                   name="password"
                                   id="inputPassword"
                                   placeholder="Masukkan kata sandi"
                                   autocomplete="current-password"
                                   class="w-full border border-gray-300 rounded pl-3 pr-12 py-3 text-sm focus:outline-none focus:border-red-600"
                                   required>

                            <button type="button"
                                    id="togglePassword"
                                    onclick="togglePasswordVisibility()"
                                    aria-label="Tampilkan kata sandi"
                                    aria-pressed="false"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">

                                <i id="eyeIcon" class="fa-solid fa-eye"></i>

                            </button>

                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-red-700 hover:bg-red-800 text-white py-3 rounded font-semibold">

                        Masuk

                    </button>

                </form>

                <p class="text-xs text-gray-500 text-center mt-6">
                    Halaman ini khusus untuk pengguna yang memiliki akun staff.
                </p>

            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-gray-200 text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} TechLaptop Store
    </footer>

    <script>
        function togglePasswordVisibility() {

            const password = document.getElementById('inputPassword');
            const icon = document.getElementById('eyeIcon');
            const button = document.getElementById('togglePassword');

            const visible = password.type === 'password';

            password.type = visible ? 'text' : 'password';

            icon.className = visible
                ? 'fa-solid fa-eye-slash'
                : 'fa-solid fa-eye';

            button.setAttribute('aria-pressed', String(visible));

            button.setAttribute(
                'aria-label',
                visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
            );
        }
    </script>

</body>
</html>