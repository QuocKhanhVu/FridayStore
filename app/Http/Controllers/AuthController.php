<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();

            if ($user && $user->role === 'admin') {
                return redirect()->route('system.users.index');
            }

            if ($user && $user->role === 'warehouse') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu không hợp lệ.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Email hoặc mật khẩu không đúng.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->is_active) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tài khoản đã bị khóa. Vui lòng liên hệ admin.',
                ]);
        }

        if ($user->paid_until && now()->greaterThan($user->paid_until)) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tài khoản đã hết hạn sử dụng. Vui lòng liên hệ admin.',
                ]);
        }

        if ($user->role === 'admin') {
            return redirect()->route('system.users.index');
        }

        if ($user->role === 'warehouse') {
            return redirect()->route('admin.dashboard');
        }

        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Tài khoản không hợp lệ.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}