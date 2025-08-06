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
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained()->onDelete('cascade'); // الربط بالمشرف
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('weekly_plan_item_id')->constrained()->onDelete('cascade'); // الربط بالمهمة الأسبوعية
            $table->dateTime('visited_at');
            $table->text('summary')->nullable();           // ملخص الزيارة
            $table->text('recommendations')->nullable();   // التوصيات
            $table->enum('status', ['done', 'delayed', 'cancelled'])->default('done');
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_reports');
    }
};
