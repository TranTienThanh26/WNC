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
        // 1. Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Kiểm tra có phải role 'admin' không
        // Lưu ý: Đảm bảo bảng 'users' của bạn có cột 'role'
        if (Auth::user()->role !== 'admin') {
            abort(403, '⛔ Bạn không có quyền truy cập trang quản trị!');
        }

        return $next($request);
    }
}