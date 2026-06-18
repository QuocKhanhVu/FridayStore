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
       Schema::create('costumes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained('costume_categories')
                ->cascadeOnDelete();

            $table->string('code')->unique();

            $table->string('name');

            $table->enum('gender', [
                'male',
                'female',
                'unisex'
            ])->default('unisex');

            $table->decimal('rental_price', 12, 0)->default(0);

            $table->string('image')->nullable();

            $table->text('description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costumes');
    }
};
