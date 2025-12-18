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
        Schema::create('qol_records', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('gender');
            $table->string('occupation_type');
            $table->decimal('avg_work_hours_per_day', 5, 2);
            $table->decimal('avg_rest_hours_per_day', 5, 2);
            $table->decimal('avg_sleep_hours_per_day', 5, 2);
            $table->decimal('avg_exercise_hours_per_day', 5, 2);
            $table->unsignedTinyInteger('age_at_death');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qol_records');
    }
};
