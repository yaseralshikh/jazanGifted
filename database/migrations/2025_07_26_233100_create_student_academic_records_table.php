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
        Schema::create('student_academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // الطالب
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade'); // العام الدراسي
            $table->foreignId('school_id')->constrained()->onDelete('cascade');

            $table->enum('grade', [
                'KG1', 'KG2',
                'G1', 'G2', 'G3', 'G4', 'G5', 'G6',
                'G7', 'G8', 'G9',
                'G10', 'G11', 'G12'
            ]); // الصف الدراسي

            $table->enum('stage', ['kindergarten', 'primary', 'middle', 'secondary']); // المرحلة الدراسية

            $table->float('talent_score')->nullable(); // نتيجة مقياس موهبة
            $table->enum('talent_type', ['promising', 'talented', 'exceptionally_talented'])->nullable(); // التصنيف

            $table->boolean('promoted')->default(false); // هل انتقل للسنة التالية
            $table->boolean('transferred')->default(false); // هل تم نقله لمدرسة أخرى
            $table->text('note')->nullable(); // ملاحظات إضافية

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_academic_records');
    }
};
