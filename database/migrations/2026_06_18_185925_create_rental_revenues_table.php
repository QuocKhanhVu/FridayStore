<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_revenues', function (Blueprint $table) {

            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->foreignId('concept_id')
                ->constrained('concepts')
                ->cascadeOnDelete();

            $table->integer('student_count')->default(0);

            $table->decimal('price', 12, 0)->default(0);

            $table->decimal('discount_percent', 5, 2)->default(0);

            $table->decimal('total_amount', 12, 0)->default(0);

            $table->decimal('discount_amount', 12, 0)->default(0);

            $table->decimal('final_amount', 12, 0)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_revenues');
    }
};