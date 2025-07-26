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
        Schema::create('responsibilities', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique(); // اسم المهمة
            $table->string('code')->unique(); // رمز فريد للمهمة
            $table->text('description')->nullable(); // وصف المهمة
            $table->boolean('active')->default(true); // حالة التفعيل
            $table->string('scope_type')->nullable(); // كيان المهمة مثل (program, school, etc.)
            $table->unsignedBigInteger('scope_id')->nullable(); // id للكيان المرتبط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsibilities');
    }
};
