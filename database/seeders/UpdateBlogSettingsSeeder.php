<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BlogSetting;

class UpdateBlogSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Agregar nuevos campos si no existen
        $newSettings = [
            [
                'key' => 'navbar_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'header_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'footer_text',
                'value' => config('app.name', 'Mi Blog'),
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'footer_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'site_description',
                'value' => 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.',
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($newSettings as $setting) {
            // Solo insertar si no existe
            $exists = BlogSetting::where('key', $setting['key'])->exists();
            if (!$exists) {
                BlogSetting::create([
                    'key' => $setting['key'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]);
            }
        }

        // Limpiar cache
        BlogSetting::clearCache();
    }
}
