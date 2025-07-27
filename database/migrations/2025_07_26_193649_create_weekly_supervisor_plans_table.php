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
        Schema::create('weekly_supervisor_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->constrained()->onDelete('cascade');
            $table->date('week_start');
            $table->date('week_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_supervisor_plans');
    }
};
