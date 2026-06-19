<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'warehouse'])
                ->default('warehouse')
                ->after('password');

            $table->boolean('is_active')
                ->default(true)
                ->after('role');

            $table->timestamp('paid_until')
                ->nullable()
                ->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'is_active',
                'paid_until',
            ]);
        });
    }
};