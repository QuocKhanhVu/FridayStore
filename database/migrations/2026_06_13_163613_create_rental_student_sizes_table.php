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
       Schema::create('rental_student_sizes', function (Blueprint $table) {

        $table->id();

        $table->foreignId(
            'rental_student_id'
        )
        ->constrained()
        ->cascadeOnDelete();

        $table->foreignId(
            'costume_id'
        )
        ->constrained()
        ->cascadeOnDelete();

        $table->foreignId(
            'costume_size_id'
        )
        ->constrained()
        ->cascadeOnDelete();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_student_sizes');
    }
};
