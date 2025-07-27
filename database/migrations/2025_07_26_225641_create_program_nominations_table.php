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
        Schema::create('program_nominations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('nominated_by')->constrained('users')->onDelete('set null'); // معلم أو مشرف
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_nominations');
    }
};
