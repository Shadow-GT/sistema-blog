<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSampleRichPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:create-sample-rich-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a sample post with rich text content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating sample rich text post...');

        $richContent = '
        <h2>Introducción al Desarrollo Web Moderno</h2>

        <p>El desarrollo web ha evolucionado significativamente en los últimos años. En este artículo exploraremos las <strong>tecnologías más importantes</strong> y las <em>mejores prácticas</em> para crear aplicaciones web modernas.</p>

        <h3>Tecnologías Frontend</h3>

        <p>Las tecnologías frontend más populares incluyen:</p>

        <ul>
            <li><strong>React</strong> - Biblioteca de JavaScript para interfaces de usuario</li>
            <li><strong>Vue.js</strong> - Framework progresivo para aplicaciones web</li>
            <li><strong>Angular</strong> - Plataforma completa para aplicaciones web</li>
            <li><strong>Svelte</strong> - Compilador de componentes web</li>
        </ul>

        <h3>Tecnologías Backend</h3>

        <p>Para el backend, tenemos varias opciones excelentes:</p>

        <ol>
            <li><strong>Laravel (PHP)</strong> - Framework elegante y expresivo</li>
            <li><strong>Node.js (JavaScript)</strong> - Entorno de ejecución del lado del servidor</li>
            <li><strong>Django (Python)</strong> - Framework web de alto nivel</li>
            <li><strong>Ruby on Rails</strong> - Framework web para desarrollo rápido</li>
        </ol>

        <blockquote>
            <p>"El mejor código es el que no necesitas escribir" - Un desarrollador sabio</p>
        </blockquote>

        <h3>Ejemplo de Código</h3>

        <p>Aquí tienes un ejemplo básico de un componente React:</p>

        <pre><code>function Welcome({ name }) {
    return (
        &lt;div className="welcome"&gt;
            &lt;h1&gt;¡Hola, {name}!&lt;/h1&gt;
            &lt;p&gt;Bienvenido a nuestro blog de tecnología.&lt;/p&gt;
        &lt;/div&gt;
    );
}</code></pre>

        <h3>Tabla Comparativa</h3>

        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; text-align: left;">Framework</th>
                    <th style="padding: 12px; text-align: left;">Lenguaje</th>
                    <th style="padding: 12px; text-align: left;">Dificultad</th>
                    <th style="padding: 12px; text-align: left;">Popularidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 8px;">Laravel</td>
                    <td style="padding: 8px;">PHP</td>
                    <td style="padding: 8px;">Media</td>
                    <td style="padding: 8px;">⭐⭐⭐⭐⭐</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="padding: 8px;">React</td>
                    <td style="padding: 8px;">JavaScript</td>
                    <td style="padding: 8px;">Media-Alta</td>
                    <td style="padding: 8px;">⭐⭐⭐⭐⭐</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">Vue.js</td>
                    <td style="padding: 8px;">JavaScript</td>
                    <td style="padding: 8px;">Baja-Media</td>
                    <td style="padding: 8px;">⭐⭐⭐⭐</td>
                </tr>
            </tbody>
        </table>

        <h3>Conclusión</h3>

        <p>El desarrollo web moderno ofrece muchas opciones emocionantes. La clave está en elegir las herramientas adecuadas para tu proyecto específico y mantenerse actualizado con las últimas tendencias.</p>

        <p>Para más información, puedes visitar <a href="https://developer.mozilla.org" target="_blank">MDN Web Docs</a> o seguir nuestro blog para más contenido sobre desarrollo web.</p>
        ';

        $post = \App\Models\Post::create([
            'title' => 'Guía Completa de Desarrollo Web Moderno con Contenido Enriquecido',
            'slug' => 'guia-completa-desarrollo-web-moderno-contenido-enriquecido',
            'content' => $richContent,
            'excerpt' => 'Una guía completa sobre las tecnologías y mejores prácticas del desarrollo web moderno, con ejemplos de código, tablas comparativas y contenido enriquecido.',
            'category_id' => 3, // Desarrollo Web
            'post_type_id' => 1, // Tutorial
            'user_id' => 1, // Admin user
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $this->info("✓ Created rich text post: {$post->title}");
        $this->info("✓ Post ID: {$post->id}");
        $this->info("✓ URL: /post/{$post->slug}");

        $this->info('Sample rich text post created successfully!');
    }
}
