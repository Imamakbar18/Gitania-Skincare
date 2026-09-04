<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki status is_admin == 1
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // Jika bukan admin, abort dengan pesan 403
        abort(403, 'Unauthorized action. Halaman ini khusus untuk Admin.');
    }
}
