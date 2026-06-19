<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WarehouseActiveMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->isWarehouse()) {
            abort(403, 'Tài khoản này không phải tài khoản kho.');
        }

        if ($user->isBlocked()) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tài khoản đã bị tạm khóa hoặc hết hạn sử dụng. Vui lòng liên hệ admin.',
                ]);
        }

        return $next($request);
    }
}