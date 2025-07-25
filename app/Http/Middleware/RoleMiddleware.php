<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        
        // Periksa apakah role pengguna sesuai dengan role yang diberikan
        if (Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
