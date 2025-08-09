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
        Schema::create('academic_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(); // مثل: الأسبوع التمهيدي، أسبوع الاختبارات...
            $table->unsignedTinyInteger('week_number'); // رقم الأسبوع داخل السنة
            $table->date('start_date'); // بداية الأسبوع
            $table->date('end_date');   // نهاية الأسبوع
            $table->boolean('status')->default(true); // لتفعيل / تعطيل الأسبوع
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade'); // ربط بالأعوام الدراسية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_weeks');
    }
};
