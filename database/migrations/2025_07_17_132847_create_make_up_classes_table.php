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
    Schema::create('make_up_classes', function (Blueprint $table) {
        $table->id();

        // 關聯到學員
        $table->unsignedBigInteger('student_id');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        // 關聯到原始請假的課程
        $table->unsignedBigInteger('original_course_id');
        $table->foreign('original_course_id')->references('id')->on('courses')->onDelete('cascade');

        // 關聯到實際補課的課程
        $table->unsignedBigInteger('make_up_course_id')->nullable();
        $table->foreign('make_up_course_id')->references('id')->on('courses')->onDelete('set null');
        
        // 補課狀態
        $table->string('make_up_status')->default('待補'); // 例如：待補、已補、已失效

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('make_up_classes');
    }
};
