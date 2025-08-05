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
        Schema::create('program_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('title'); // اسم المؤشر
            $table->enum('type', ['numeric', 'action']); // كمي / إجراء
            $table->unsignedInteger('target_value')->nullable(); // للنوع الكمي
            $table->boolean('is_required')->default(true); // هل هو إلزامي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_indicators');
    }
};
