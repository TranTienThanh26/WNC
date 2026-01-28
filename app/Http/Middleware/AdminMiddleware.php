<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Chưa đăng nhập → đá về login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Đã đăng nhập nhưng không phải admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
