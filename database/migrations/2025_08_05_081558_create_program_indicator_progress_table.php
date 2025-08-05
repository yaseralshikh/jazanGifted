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
        Schema::create('program_indicator_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_indicator_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('achieved_value')->nullable(); // للأرقام
            $table->date('progress_date'); // تاريخ التقدم
            $table->text('note')->nullable(); // للملاحظات
            $table->boolean('is_completed')->default(false); // للإجراء
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_indicator_progress');
    }
};
