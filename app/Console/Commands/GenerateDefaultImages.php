<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GenerateDefaultImages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'blog:generate-default-images';

    /**
     * The console command description.
     */
    protected $description = 'Generate default images for Open Graph sharing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generando imágenes por defecto...');

        // Crear directorio si no existe
        $imagesPath = public_path('images');
        if (!file_exists($imagesPath)) {
            mkdir($imagesPath, 0755, true);
        }

        // Generar imagen por defecto para Open Graph (1200x630)
        $this->generateDefaultOgImage();
        
        // Generar imagen por defecto para posts (800x400)
        $this->generateDefaultPostImage();

        $this->info('✓ Imágenes por defecto generadas correctamente');
    }

    private function generateDefaultOgImage()
    {
        $siteName = \App\Models\BlogSetting::get('site_name', config('app.name'));
        $siteDescription = \App\Models\BlogSetting::get('site_description', 'Blog de contenido de calidad');

        // Crear imagen con GD
        $width = 1200;
        $height = 630;
        
        $image = imagecreatetruecolor($width, $height);
        
        // Colores
        $bgColor = imagecolorallocate($image, 59, 130, 246); // Azul
        $textColor = imagecolorallocate($image, 255, 255, 255); // Blanco
        $subtextColor = imagecolorallocate($image, 219, 234, 254); // Azul claro
        
        // Fondo degradado simulado
        imagefill($image, 0, 0, $bgColor);
        
        // Agregar texto
        $font = 5; // Fuente built-in de GD
        
        // Título
        $titleX = ($width - strlen($siteName) * 15) / 2;
        imagestring($image, $font, $titleX, 250, $siteName, $textColor);
        
        // Descripción
        $descX = ($width - strlen($siteDescription) * 10) / 2;
        imagestring($image, 3, $descX, 320, $siteDescription, $subtextColor);
        
        // Guardar imagen
        imagepng($image, public_path('images/default-og-image.jpg'));
        imagedestroy($image);
        
        $this->info('✓ Imagen Open Graph generada: public/images/default-og-image.jpg');
    }

    private function generateDefaultPostImage()
    {
        $width = 800;
        $height = 400;
        
        $image = imagecreatetruecolor($width, $height);
        
        // Colores
        $bgColor = imagecolorallocate($image, 99, 102, 241); // Índigo
        $textColor = imagecolorallocate($image, 255, 255, 255); // Blanco
        
        // Fondo
        imagefill($image, 0, 0, $bgColor);
        
        // Texto
        $text = "Artículo del Blog";
        $textX = ($width - strlen($text) * 12) / 2;
        imagestring($image, 5, $textX, 180, $text, $textColor);
        
        // Guardar imagen
        imagepng($image, public_path('images/default-post-image.jpg'));
        imagedestroy($image);
        
        $this->info('✓ Imagen de post por defecto generada: public/images/default-post-image.jpg');
    }
}
