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

            $table->unsignedBigInteger('graduation_costume_id')
                ->nullable()
                ->after('concept_id');

            $table->unsignedBigInteger('female_accessory_id')
                ->nullable()
                ->after('graduation_costume_id');

            $table->unsignedBigInteger('male_accessory_id')
                ->nullable()
                ->after('female_accessory_id');

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
