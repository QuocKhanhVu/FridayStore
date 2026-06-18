<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_extra_costume', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->foreignId('costume_id')
                ->constrained('costumes')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'rental_id',
                'costume_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_extra_costume');
    }
};