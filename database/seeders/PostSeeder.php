<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            [
                'title' => 'Dominando los Índices en MySQL: Rendimiento al Máximo',
                'content' => "Los índices son una de las herramientas más poderosas para optimizar el rendimiento de tus consultas en MySQL.\n\n**¿Por qué importan los índices?**\n\nUn índice permite a la base de datos encontrar filas sin escanear toda la tabla. Sin ellos, cada consulta haría un *full table scan*.\n\n**Tipos de índices más usados:**\n\n1. Índices primarios (PRIMARY KEY)\n2. Índices únicos (UNIQUE)\n3. Índices compuestos\n4. Índices de texto completo (FULLTEXT)\n\n**Buenas prácticas:**\n\n- Indexa las columnas que aparecen en WHERE, JOIN y ORDER BY\n- Evita indexar columnas con baja cardinalidad\n- Usa EXPLAIN para analizar tus consultas",
                'excerpt' => 'Todo lo que necesitas saber sobre índices en MySQL para acelerar tus consultas.',
                'category' => 'Bases de Datos',
                'post_type' => 'Tutorial',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'OWASP Top 10: Las Vulnerabilidades Web Más Críticas',
                'content' => "Conocer las vulnerabilidades más comunes es el primer paso para construir aplicaciones seguras.\n\n**El OWASP Top 10 incluye:**\n\n1. **Broken Access Control**: Fallos en el control de acceso\n2. **Cryptographic Failures**: Errores criptográficos\n3. **Injection**: Inyección (SQL, XSS, etc.)\n4. **Insecure Design**: Diseño inseguro\n5. **Security Misconfiguration**: Configuración insegura\n\nCada categoría representa un riesgo real que debes mitigar en tus proyectos. La defensa en profundidad y la validación estricta de entradas son tus mejores aliados.",
                'excerpt' => 'Repaso de las 10 vulnerabilidades web más críticas según OWASP y cómo prevenirlas.',
                'category' => 'Ciberseguridad',
                'post_type' => 'Artículo',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Vue 3 vs React: ¿Cuál Elegir en tu Próximo Proyecto?',
                'content' => "La eterna pregunta del desarrollo frontend moderno. Ambos frameworks son excelentes, pero tienen filosofías distintas.\n\n**React:**\n\n- Mayor ecosistema y comunidad\n- Más ofertas de trabajo\n- JSX y flexibilidad total\n\n**Vue 3:**\n\n- Curva de aprendizaje más suave\n- Composition API muy potente\n- Excelente documentación\n\n**Conclusión:** No hay una respuesta única. Elige según las necesidades del proyecto y la experiencia de tu equipo.",
                'excerpt' => 'Comparativa práctica entre Vue 3 y React para ayudarte a decidir.',
                'category' => 'Desarrollo Web',
                'post_type' => 'Review',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Cómo Migramos un Monolito a Microservicios',
                'content' => "En este caso de estudio compartimos nuestra experiencia migrando una aplicación monolítica a una arquitectura de microservicios.\n\n**El punto de partida:**\n\nUna aplicación monolítica de 500.000 líneas con despliegues lentos y acoplamiento alto.\n\n**La estrategia:**\n\n1. Identificar los dominios (DDD)\n2. Extraer servicios de forma incremental (Strangler Fig)\n3. Implementar un API Gateway\n4. Migrar la base de datos por servicio\n\n**Resultados:**\n\n- Despliegues 10x más rápidos\n- Mejor escalabilidad por servicio\n- Mayor complejidad operativa (el trade-off)",
                'excerpt' => 'Lecciones aprendidas migrando un monolito a microservicios en producción.',
                'category' => 'DevOps',
                'post_type' => 'Caso de Estudio',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'PHP 8.3: Las Nuevas Características que Debes Conocer',
                'content' => "PHP sigue evolucionando y la versión 8.3 trae mejoras interesantes para el desarrollo moderno.\n\n**Novedades destacadas:**\n\n- **Typed class constants**: Constantes de clase con tipo\n- **json_validate()**: Validar JSON sin decodificarlo\n- **#[\\Override]**: Atributo para marcar métodos sobrescritos\n- Mejoras de rendimiento en el motor\n\nActualizar a las últimas versiones de PHP no solo aporta nuevas características, también mejoras de seguridad y rendimiento.",
                'excerpt' => 'Un recorrido por las nuevas características de PHP 8.3.',
                'category' => 'Programación',
                'post_type' => 'Noticia',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Patrones de Diseño en la Práctica: Repository y Service',
                'content' => "Los patrones de diseño nos ayudan a escribir código más mantenible y testeable.\n\n**Patrón Repository:**\n\nAbstrae el acceso a datos, permitiendo cambiar la fuente sin tocar la lógica de negocio.\n\n**Patrón Service:**\n\nEncapsula la lógica de negocio fuera de los controladores, manteniéndolos delgados.\n\nCombinar ambos patrones resulta en una arquitectura limpia donde cada capa tiene una única responsabilidad. Este artículo aún está en revisión editorial.",
                'excerpt' => 'Aplicando los patrones Repository y Service en proyectos reales.',
                'category' => 'Programación',
                'post_type' => 'Tutorial',
                'status' => 'pending',
                'is_featured' => false,
            ],
            [
                'title' => 'Kubernetes para Principiantes: Tu Primer Cluster',
                'content' => "Kubernetes puede parecer intimidante al principio, pero con esta guía darás tus primeros pasos.\n\n**Conceptos clave:**\n\n- **Pod**: La unidad mínima de despliegue\n- **Deployment**: Gestiona réplicas de pods\n- **Service**: Expone tus pods a la red\n- **Namespace**: Aísla recursos\n\nEmpieza con minikube en local antes de saltar a un cluster en la nube. Borrador pendiente de completar con ejemplos prácticos.",
                'excerpt' => 'Primeros pasos con Kubernetes: conceptos y tu primer cluster local.',
                'category' => 'DevOps',
                'post_type' => 'Tutorial',
                'status' => 'pending',
                'is_featured' => false,
            ],
            [
                'title' => 'Redes Neuronales Explicadas de Forma Sencilla',
                'content' => "Las redes neuronales son la base del deep learning. En este borrador intentamos explicarlas sin matemáticas complejas.\n\nUna red neuronal imita, de forma muy simplificada, cómo funcionan las neuronas del cerebro: recibe entradas, las pondera y produce una salida.\n\nEste contenido está en fase de borrador y será ampliado con diagramas e interactivos.",
                'excerpt' => 'Una introducción amigable a las redes neuronales y el deep learning.',
                'category' => 'Inteligencia Artificial',
                'post_type' => 'Artículo',
                'status' => 'draft',
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
                    'slug' => Str::slug($postData['title']),
                    'content' => $postData['content'],
                    'excerpt' => $postData['excerpt'],
                    'status' => $postData['status'],
                    'is_featured' => $postData['is_featured'],
                    'views_count' => rand(50, 500),
                    'published_at' => $postData['status'] === 'published'
                        ? now()->subDays(rand(1, 30))
                        : null,
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'post_type_id' => $postType->id,
                ]);
            }
        }

        $this->command->info('Posts de ejemplo creados exitosamente (' . count($samplePosts) . ' posts).');
    }
}
