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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // 學員姓名
        $table->text('contact_info')->nullable(); // 聯絡資訊
        // parent_id 關聯到 users 表，記錄家長是哪位使用者
        $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('set null');
        // school_id 關聯到未來的 schools 表
        $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null'); 
        $table->boolean('is_trial')->default(false); // 是否為體驗課學生，預設為否
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
