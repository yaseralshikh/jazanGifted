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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->float('talent_score_1')->nullable();
            $table->float('talent_score_2')->nullable();
            $table->float('talent_score_3')->nullable();
            $table->date('year__score_1');
            $table->date('year__score_2');
            $table->date('year__score_3');
            $table->enum('talent_type', ['promising', 'talented', ' exceptionally_talented']);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
