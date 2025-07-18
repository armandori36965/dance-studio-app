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
    Schema::create('school_events', function (Blueprint $table) {
        $table->id(); // 主鍵 ID
        $table->string('title'); // 事件標題，例如「中秋節停課」
        $table->string('type'); // 事件類型，例如「停課」、「補課」、「活動」
        $table->date('start_date'); // 事件開始日期
        $table->date('end_date'); // 事件結束日期
        $table->text('description')->nullable(); // 事件的詳細說明，可留空
        $table->timestamps(); // created_at 和 updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};
