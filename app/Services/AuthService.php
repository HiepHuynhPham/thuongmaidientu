<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AuthService
{
    public function login($credentials)
    {
        // Tìm người dùng theo email
        $user = User::where('user_email', $credentials['user_email'])->first();

        if ($user && Hash::check($credentials['user_password'], $user->user_password)) {
            // Đăng nhập
            Auth::login($user);
            return true;
        }

        return false;
    }

    public function logout()
    {
        Auth::logout();
    }

    public function checkRole($roleId)
    {
        return Auth::check() && Auth::user()->role_id === $roleId;
    }

    public function register(array $data)
    {
        // Đặt tên mới cho avatar mặc định
        $avatarName = Str::random(20) . '.jpg';
        $avatarPath = 'avatars/' . $avatarName;

        // Sao chép ảnh mặc định từ thư mục public sang storage
        $defaultAvatar = public_path('storage/avatars/default-avatar.jpg');
        Storage::disk('public')->put($avatarPath, file_get_contents($defaultAvatar));

        // Tạo người dùng mới
        User::create([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'user_password' => Hash::make($data['user_password']),
            'user_phone' => $data['user_phone'],
            'user_address' => $data['user_address'],
            'user_avatar' => $avatarName,
            'role_id' => 3, // Người dùng thường
        ]);
    }
}