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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');

        // 確保 role_id 和 school_id 的外鍵都已正確設定
        $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
        $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null'); //
        $table->text('contact_info')->nullable(); //
        $table->json('available_times')->nullable(); //
        $table->decimal('hourly_rate_cram_school', 8, 2)->nullable(); //
        $table->decimal('hourly_rate_school', 8, 2)->nullable(); //

        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
