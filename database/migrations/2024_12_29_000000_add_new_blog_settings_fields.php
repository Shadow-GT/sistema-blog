<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar nuevos registros de configuración sin afectar los existentes
        $newSettings = [
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
        ];

        foreach ($newSettings as $setting) {
            // Solo insertar si no existe (protege datos existentes)
            $exists = DB::table('blog_settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('blog_settings')->insert($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar solo los nuevos campos agregados
        DB::table('blog_settings')->whereIn('key', [
            'navbar_text',
            'header_text', 
            'footer_text',
            'footer_logo',
            'site_description'
        ])->delete();
    }
};
