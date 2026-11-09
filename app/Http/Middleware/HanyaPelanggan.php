<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HanyaPelanggan
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin hanya mengelola, jadi tidak boleh membuka menu atau memberi review
        if ($request->user() && $request->user()->apakahAdmin()) {
            return redirect()->route('dashboard')
                ->with('gagal', 'Admin tidak bisa membuka halaman menu atau memberi review. Gunakan menu Kelola.');
        }

        return $next($request);
    }
}