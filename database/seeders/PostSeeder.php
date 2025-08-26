<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios, categorías y tipos de post existentes
        $users = User::where('role', '!=', 'guest')->get();
        $categories = Category::all();
        $postTypes = PostType::all();

        if ($users->isEmpty() || $categories->isEmpty() || $postTypes->isEmpty()) {
            $this->command->warn('Asegúrate de ejecutar UserSeeder, CategorySeeder y PostTypeSeeder primero.');
            return;
        }

        $samplePosts = [
            [
                'title' => 'Introducción a Laravel 10: Novedades y Características',
                'content' => "Laravel 10 ha llegado con muchas mejoras y nuevas características que hacen que el desarrollo web sea aún más eficiente.\n\nEntre las principales novedades encontramos:\n\n1. **Mejoras en el rendimiento**: Laravel 10 incluye optimizaciones significativas que mejoran la velocidad de las aplicaciones.\n\n2. **Nuevas funcionalidades de Eloquent**: Se han agregado nuevos métodos y características que facilitan el trabajo con bases de datos.\n\n3. **Mejor integración con herramientas modernas**: Laravel 10 se integra mejor con herramientas como Vite y otras tecnologías frontend modernas.\n\n4. **Seguridad mejorada**: Se han implementado nuevas medidas de seguridad para proteger mejor las aplicaciones.\n\nEn este artículo exploraremos cada una de estas características en detalle y veremos cómo pueden beneficiar a nuestros proyectos.",
                'excerpt' => 'Descubre las principales novedades y características de Laravel 10, el framework PHP más popular para desarrollo web.',
                'category' => 'Desarrollo Web',
                'post_type' => 'Tutorial',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Inteligencia Artificial en 2024: Tendencias y Predicciones',
                'content' => "La inteligencia artificial continúa evolucionando a un ritmo acelerado. En 2024, esperamos ver avances significativos en varias áreas.\n\n**Principales tendencias:**\n\n- **IA Generativa**: Los modelos como GPT-4 y similares seguirán mejorando\n- **Automatización inteligente**: Más procesos empresariales serán automatizados\n- **IA en el edge**: Procesamiento de IA directamente en dispositivos\n- **Ética en IA**: Mayor enfoque en el desarrollo responsable\n\nEstas tendencias transformarán la forma en que trabajamos y vivimos.",
                'excerpt' => 'Análisis de las principales tendencias en inteligencia artificial que marcarán el 2024.',
                'category' => 'Inteligencia Artificial',
                'post_type' => 'Artículo',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Guía Completa de Docker para Desarrolladores',
                'content' => "Docker ha revolucionado la forma en que desarrollamos y desplegamos aplicaciones. Esta guía te enseñará todo lo que necesitas saber.\n\n**¿Qué es Docker?**\n\nDocker es una plataforma de contenedorización que permite empaquetar aplicaciones con todas sus dependencias.\n\n**Ventajas de usar Docker:**\n\n1. Consistencia entre entornos\n2. Fácil escalabilidad\n3. Aislamiento de aplicaciones\n4. Despliegue simplificado\n\n**Comandos básicos:**\n\n- `docker build`: Construir una imagen\n- `docker run`: Ejecutar un contenedor\n- `docker ps`: Listar contenedores activos\n\nEn los siguientes capítulos profundizaremos en cada concepto.",
                'excerpt' => 'Aprende Docker desde cero con esta guía completa para desarrolladores.',
                'category' => 'DevOps',
                'post_type' => 'Tutorial',
                'status' => 'published',
                'is_featured' => false,
            ],
        ];

        foreach ($samplePosts as $postData) {
            $category = $categories->where('name', $postData['category'])->first();
            $postType = $postTypes->where('name', $postData['post_type'])->first();
            $user = $users->random();

            if ($category && $postType) {
                Post::create([
                    'title' => $postData['title'],
                    'slug' => \Illuminate\Support\Str::slug($postData['title']),
                    'content' => $postData['content'],
                    'excerpt' => $postData['excerpt'],
                    'status' => $postData['status'],
                    'is_featured' => $postData['is_featured'],
                    'views_count' => rand(50, 500),
                    'published_at' => now()->subDays(rand(1, 30)),
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'post_type_id' => $postType->id,
                ]);
            }
        }

        $this->command->info('Posts de ejemplo creados exitosamente.');
    }
}
