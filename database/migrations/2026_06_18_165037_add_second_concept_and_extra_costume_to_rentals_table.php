<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {

            $table->foreignId('second_concept_id')
                ->nullable()
                ->after('concept_id')
                ->constrained('concepts')
                ->nullOnDelete();

            $table->foreignId('extra_costume_id')
                ->nullable()
                ->after('second_concept_id')
                ->constrained('costumes')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {

            $table->dropConstrainedForeignId('extra_costume_id');

            $table->dropConstrainedForeignId('second_concept_id');

        });
    }
};