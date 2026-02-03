<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Dùng Hash::make thay vì bcrypt (chuẩn hơn)

class AuthController extends Controller
{
    // 👇 FORM ĐĂNG NHẬP
    public function loginForm()
    {
        return view('auth.login');
    }

    // 👇 XỬ LÝ ĐĂNG NHẬP
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 🟢 Kiểm tra Role để chuyển hướng đúng nơi
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Chuyển đến Dashboard
            }

            return redirect()->route('home'); // Chuyển về trang chủ
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ]);
    }

    // 👇 FORM ĐĂNG KÝ
    public function registerForm()
    {
        return view('auth.register');
    }

    // 👇 XỬ LÝ ĐĂNG KÝ
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // confirmed yêu cầu input name="password_confirmation"
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // 🟢 Mặc định là user thường
        ]);

        // Đăng ký xong cho đăng nhập luôn (hoặc bắt đăng nhập lại tùy bạn)
        // Ở đây mình chuyển về login để họ tự đăng nhập
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // 👇 ĐĂNG XUẤT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}