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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('is_active');
            $table->enum('author_request_status', ['none', 'pending', 'approved', 'rejected'])
                  ->default('none')->after('profile_photo');
            $table->timestamp('author_requested_at')->nullable()->after('author_request_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo', 'author_request_status', 'author_requested_at']);
        });
    }
};
