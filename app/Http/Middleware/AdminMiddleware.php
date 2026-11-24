<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (strtolower(trim(Auth::user()->ROLE)) !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Kamu tidak memiliki akses Admin.');
        }

        return $next($request);
    }
}
