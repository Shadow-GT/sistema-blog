<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programación',
                'slug' => 'programacion',
                'description' => 'Artículos sobre lenguajes de programación, frameworks y desarrollo de software.',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Inteligencia Artificial',
                'slug' => 'inteligencia-artificial',
                'description' => 'Contenido sobre IA, machine learning y tecnologías emergentes.',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'description' => 'Frontend, backend, frameworks web y tecnologías relacionadas.',
                'color' => '#10B981',
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Automatización, CI/CD, contenedores y infraestructura.',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'Bases de Datos',
                'slug' => 'bases-de-datos',
                'description' => 'SQL, NoSQL, optimización y administración de bases de datos.',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Ciberseguridad',
                'slug' => 'ciberseguridad',
                'description' => 'Seguridad informática, vulnerabilidades y mejores prácticas.',
                'color' => '#6B7280',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
