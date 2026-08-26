<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan baris ini

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Menggunakan Auth::check() agar terbaca oleh editor
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Menggunakan Auth::user()
        $userRole = Auth::user()->role ?? 'kasir';

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Anda tidak memiliki hak akses ke halaman ini.');
    }
}
