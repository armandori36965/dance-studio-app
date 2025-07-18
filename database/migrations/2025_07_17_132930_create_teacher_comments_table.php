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
    Schema::create('teacher_comments', function (Blueprint $table) {
        $table->id();

        // 關聯到學員
        $table->unsignedBigInteger('student_id');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        // 關聯到老師 (也是 users 表)
        $table->unsignedBigInteger('teacher_id');
        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

        // 關聯到特定課程 (可選)
        $table->unsignedBigInteger('course_id')->nullable();
        $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');

        $table->text('comment'); // 評語內容
        $table->text('expectation')->nullable(); // 期許內容

        $table->timestamps(); // created_at 欄位
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_comments');
    }
};
