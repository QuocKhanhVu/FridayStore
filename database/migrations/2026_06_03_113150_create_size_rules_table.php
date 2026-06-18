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
        Schema::create('size_rules', function (Blueprint $table) {

            $table->id();

            $table->foreignId('costume_size_id')
                ->constrained('costume_sizes')
                ->cascadeOnDelete();

            $table->decimal('height_from', 5, 2)->nullable();

            $table->decimal('height_to', 5, 2)->nullable();

            $table->decimal('weight_from', 5, 2)->nullable();

            $table->decimal('weight_to', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_rules');
    }
};
