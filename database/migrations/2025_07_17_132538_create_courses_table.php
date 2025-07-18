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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();

        // 關聯到 course_templates (標準語法)
        $table->unsignedBigInteger('template_id');
        $table->foreign('template_id')->references('id')->on('course_templates')->onDelete('cascade');

        // 關聯到 schools (地點) (標準語法)
        $table->unsignedBigInteger('location_id')->nullable();
        $table->foreign('location_id')->references('id')->on('schools')->onDelete('set null');

        // 關聯到 users (老師) (標準語法)
        $table->unsignedBigInteger('teacher_id')->nullable();
        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');

        // 以下欄位不變
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        
        $table->unsignedInteger('capacity')->default(0);
        $table->unsignedInteger('current_enrollment')->default(0);
        $table->boolean('is_full')->default(false);
        
        $table->string('course_type')->nullable();
        
        $table->boolean('is_cancelled')->default(false);
        $table->text('cancellation_reason')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
