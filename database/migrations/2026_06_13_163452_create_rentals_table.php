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
        Schema::create('rentals', function (Blueprint $table) {

        $table->id();

        $table->string('code')->unique();

        $table->foreignId('studio_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('concept_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('school_name');

        $table->string('class_name');

        $table->date('shooting_date');

        $table->date('rental_date');

        $table->date('return_date');

        $table->integer('student_count')
            ->default(0);

        $table->decimal(
            'total_amount',
            12,
            0
        )->default(0);

        $table->enum('status', [

            'draft',
            'sized',
            'approved',
            'renting',
            'returned',
            'cancelled'

        ])->default('draft');

        $table->text('note')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
