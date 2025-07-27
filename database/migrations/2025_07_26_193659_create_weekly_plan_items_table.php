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
        Schema::create('weekly_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_supervisor_plan_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('location');
            $table->string('title');
            $table->text('objectives')->nullable();
            $table->text('activities')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_plan_items');
    }
};
