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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->enum('educational_stage', ['kindergarten','primary','middle','secondary','complex']);
            $table->string('ministry_code');
            $table->foreignId('principal_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('gifted_teacher_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('gender', ['male', 'female']);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
