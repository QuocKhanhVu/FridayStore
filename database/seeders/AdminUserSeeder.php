<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@fridaystore.vn',
            ],
            [
                'name' => 'Admin FridayStore',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'is_active' => true,
                'paid_until' => null,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'oldwarehouse@fridaystore.vn',
            ],
            [
                'name' => 'Kho dữ liệu cũ',
                'password' => Hash::make('123456'),
                'role' => 'warehouse',
                'is_active' => true,
                'paid_until' => null,
            ]
        );
    }
}
