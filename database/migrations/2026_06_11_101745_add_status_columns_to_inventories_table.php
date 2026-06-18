<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventories', function ($table) {

            $table->integer('rented_quantity')
                ->default(0);

            $table->integer('broken_quantity')
                ->default(0);

            $table->integer('lost_quantity')
                ->default(0);

        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            //
        });
    }
};
