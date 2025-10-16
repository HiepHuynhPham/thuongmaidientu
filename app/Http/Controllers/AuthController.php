<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('user_email', 'user_password');

        if ($this->authService->login($credentials)) {
            // Lấy thông tin user từ database
            $user = User::where('user_email', $credentials['user_email'])->first();
            if ($user) {
                $request->session()->put('email', $user->user_email);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('role_id', $user->role_id);
                return redirect()->route('home');
            }
        }

        return redirect()->back()->withErrors(['login' => 'Đăng nhập thất bại!']);
    }

    public function logout()
{
    auth()->logout();  // Đăng xuất người dùng
    session()->invalidate();  // Xóa tất cả session
    session()->regenerateToken();  // Tạo lại CSRF token để bảo mật
    return redirect()->route('home');
}


    public function showRegisterForm(){
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users',
            'user_password' => 'required|string|min:6|confirmed',
            'user_phone' => 'required|string|max:20',
            'user_address' => 'required|string|max:255',
        ]);

        $this->authService->register($validated);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }
}