<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role user saat ini ada di dalam daftar role yang diperbolehkan
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak berhak, tampilkan error 403 Forbidden
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}