<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postTypes = [
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Guías paso a paso para aprender nuevas tecnologías.',
                'icon' => '📚',
            ],
            [
                'name' => 'Artículo',
                'slug' => 'articulo',
                'description' => 'Artículos informativos y análisis técnicos.',
                'icon' => '📄',
            ],
            [
                'name' => 'Noticia',
                'slug' => 'noticia',
                'description' => 'Últimas noticias del mundo tecnológico.',
                'icon' => '📰',
            ],
            [
                'name' => 'Review',
                'slug' => 'review',
                'description' => 'Reseñas de herramientas, frameworks y tecnologías.',
                'icon' => '⭐',
            ],
            [
                'name' => 'Caso de Estudio',
                'slug' => 'caso-de-estudio',
                'description' => 'Análisis detallados de proyectos reales.',
                'icon' => '🔍',
            ],
        ];

        foreach ($postTypes as $postType) {
            PostType::create($postType);
        }
    }
}
