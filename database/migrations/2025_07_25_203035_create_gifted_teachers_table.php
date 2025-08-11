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
        Schema::create('gifted_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialization_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('academic_qualification')->nullable();
            $table->integer('experience_years')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->enum('teacher_type', ['coordinator', 'dedicated', 'teaching']);
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifted_teachers');
    }
};
