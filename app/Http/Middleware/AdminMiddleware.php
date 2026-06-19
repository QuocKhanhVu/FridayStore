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
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập khu vực admin hệ thống.');
        }

        return $next($request);
    }
}