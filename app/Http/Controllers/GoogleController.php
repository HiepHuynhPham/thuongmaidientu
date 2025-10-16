<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->scopes(['openid', 'profile', 'email'])
        ->with(['prompt' => 'select_account consent']) // Thêm dòng này
        ->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $socialUser = Socialite::driver('google')->stateless()->user();
        $provider = 'GOOGLE';

        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->where('user_email', $socialUser->getEmail())
                    ->first();

        if ($user == null) {
            // 1. Lấy avatar URL
            $avatarUrl = $socialUser->getAvatar();

            // 2. Lấy nội dung ảnh
            $avatarContents = file_get_contents($avatarUrl); // Cần bật allow_url_fopen hoặc dùng Guzzle

            // 3. Đặt tên file ngẫu nhiên
            $fileName = Str::random(20) . '.jpg';

            // 4. Lưu ảnh vào storage/app/public/avatar/
            Storage::disk('public')->put("avatars/{$fileName}", $avatarContents);

            // 5. Lưu tên file vào DB
            $user = User::create([
                'user_name'     => $socialUser->getName(),
                'user_email'    => $socialUser->getEmail(),
                'role_id'       => 3,
                'provider'      => $provider,
                'provider_id'   => $socialUser->getId(),
                'user_avatar'   => $fileName, // tên file
                'user_password' => bcrypt('defaultpassword'),
            ]);
        }

        Auth::login($user);
        session()->regenerate();
        // Bổ sung thêm session như login thường
        session()->put('email', $user->user_email);
        session()->put('user_id', $user->id);
        session()->put('role_id', $user->role_id);
        return redirect('/');
    } catch (\Exception $e) {
        return redirect('/')->with('error', 'Đăng nhập Google thất bại!');
    }
}
}