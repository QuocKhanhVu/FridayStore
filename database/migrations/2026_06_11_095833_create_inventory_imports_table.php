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
        Schema::create('inventory_imports', function (Blueprint $table) {

        $table->id();

        $table->foreignId('costume_id')
            ->constrained('costumes')
            ->cascadeOnDelete();

        $table->foreignId('costume_size_id')
            ->constrained('costume_sizes')
            ->cascadeOnDelete();

        $table->integer('quantity');

        $table->text('note')
            ->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_imports');
    }
};
