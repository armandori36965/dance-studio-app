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
    Schema::create('attendance', function (Blueprint $table) {
        $table->id();

        // 關聯到 courses 表
        $table->unsignedBigInteger('course_id');
        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

        // 關聯到 students 表
        $table->unsignedBigInteger('student_id');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        // 記錄出勤狀態
        $table->string('status')->default('缺課'); // 例如：到場、請假、缺課
        $table->text('leave_reason')->nullable(); // 請假原因
        $table->boolean('is_make_up_eligible')->default(false); // 是否可補課
        $table->integer('make_up_count')->nullable(); // 補習班補課剩餘次數

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
