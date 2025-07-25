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
    Schema::create('course_templates', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        // 換回標準的 decimal 類型
        $table->decimal('price', 8, 2)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_templates');
    }
};