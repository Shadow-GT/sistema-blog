<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, image, boolean, number
            $table->string('group')->default('general'); // general, appearance, seo, etc.
            $table->timestamps();
        });

        // Insert default settings
        DB::table('blog_settings')->insert([
            [
                'key' => 'site_name',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'navbar_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'header_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_settings');
    }
};
