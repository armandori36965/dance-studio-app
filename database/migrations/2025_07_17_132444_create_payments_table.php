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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // 關聯到 students 表
        $table->decimal('amount', 8, 2); // 付款金額
        $table->date('payment_date'); // 付款日期
        $table->string('payment_method')->nullable(); // 付款方式
        $table->text('description')->nullable(); // 備註說明
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
