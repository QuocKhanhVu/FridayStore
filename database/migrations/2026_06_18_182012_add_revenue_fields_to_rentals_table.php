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
        Schema::table('rentals', function (Blueprint $table) {
            $table->decimal('concept_price', 12, 0)->default(0)->after('student_count');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('concept_price');
            $table->decimal('discount_amount', 12, 0)->default(0)->after('discount_percent');
            $table->decimal('final_amount', 12, 0)->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            //
        });
    }
};
