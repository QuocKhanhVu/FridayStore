<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where('role', 'warehouse')
            ->latest()
            ->paginate(10);

        return view('system.users.index', compact('users'));
    }

    public function create()
    {
        return view('system.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'paid_until' => ['nullable', 'date'],
        ], [
            'name.required' => 'Vui lòng nhập tên kho.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'warehouse',
            'is_active' => true,
            'paid_until' => $data['paid_until'] ?? null,
        ]);

        return redirect()
            ->route('system.users.index')
            ->with('success', 'Đã cấp tài khoản kho thành công.');
    }

    public function edit(User $user)
    {
        abort_if($user->role !== 'warehouse', 403);

        return view('system.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'warehouse', 403);

        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'paid_until' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'paid_until' => $data['paid_until'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('system.users.index')
            ->with('success', 'Đã cập nhật tài khoản kho.');
    }

    public function resetPassword(Request $request, User $user)
    {
        abort_if($user->role !== 'warehouse', 403);

        $data = $request->validate([
            'password' => ['required', 'min:6'],
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Đã đặt lại mật khẩu cho tài khoản kho.');
    }

    public function toggle(User $user)
    {
        abort_if($user->role !== 'warehouse', 403);

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái tài khoản.');
    }
}