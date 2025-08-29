<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogSetting;

class UpdateBlogSettings extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'blog:update-settings';

    /**
     * The console command description.
     */
    protected $description = 'Update blog settings with new fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Actualizando configuración del blog...');

        // Agregar nuevos campos si no existen
        $newSettings = [
            'navbar_text' => config('app.name', 'Mi Blog'),
            'header_text' => config('app.name', 'Mi Blog'),
            'footer_text' => config('app.name', 'Mi Blog'),
            'footer_logo' => null,
            'site_description' => 'Tu fuente confiable de información sobre tecnología, programación y desarrollo web.',
        ];

        foreach ($newSettings as $key => $value) {
            $exists = BlogSetting::where('key', $key)->exists();
            if (!$exists) {
                BlogSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => $key === 'footer_logo' ? 'image' : 'text',
                    'group' => 'general',
                ]);
                $this->info("✓ Agregado: {$key}");
            } else {
                $this->info("- Ya existe: {$key}");
            }
        }

        // Limpiar cache
        BlogSetting::clearCache();
        
        $this->info('✓ Configuración actualizada correctamente');
        return 0;
    }
}
