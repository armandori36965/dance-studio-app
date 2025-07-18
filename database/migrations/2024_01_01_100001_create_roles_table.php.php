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
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // 角色名稱，例如 'Admin', 'Teacher'
        $table->text('permissions')->nullable(); // 權限列表，例如 ['manage_courses']
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
