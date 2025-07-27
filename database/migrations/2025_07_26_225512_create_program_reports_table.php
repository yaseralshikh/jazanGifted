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
        Schema::create('program_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->text('summary')->nullable();
            $table->unsignedInteger('attendees_count')->default(0);
            $table->text('achievements')->nullable();
            $table->text('evaluation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_reports');
    }
};
