<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    //Kiểm tra xem người dùng đã đăng nhập hay chưa và Kiểm tra xem role_id của người dùng hiện tại có nằm trong mảng các vai trò ($roles) được phép truy cập hay không.
    if (!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
        return redirect()->route('error')->withErrors(['access' => 'Bạn không có quyền truy cập!']);
    }

    return $next($request);
}
}