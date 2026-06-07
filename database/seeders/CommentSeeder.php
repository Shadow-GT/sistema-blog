<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishedPosts = Post::where('status', 'published')->get();
        $registeredUsers = User::whereIn('role', ['admin', 'author'])->get();

        if ($publishedPosts->isEmpty()) {
            $this->command->warn('No hay posts publicados; se omite CommentSeeder.');
            return;
        }

        // Comentarios de invitados (sin cuenta) — author_name/author_email.
        $guestComments = [
            ['name' => 'María González', 'email' => 'maria@example.com', 'content' => '¡Excelente artículo! Me aclaró muchas dudas que tenía sobre el tema.'],
            ['name' => 'Carlos Ramírez', 'email' => 'carlos@example.com', 'content' => 'Muy buen contenido, ojalá publiquen más sobre esto pronto.'],
            ['name' => 'Lucía Fernández', 'email' => 'lucia@example.com', 'content' => '¿Podrían profundizar en la parte de configuración? Gracias.'],
            ['name' => 'Pedro Martín', 'email' => 'pedro@example.com', 'content' => 'Justo lo que necesitaba para mi proyecto. Mil gracias por compartir.'],
            ['name' => 'Ana Torres', 'email' => 'ana@example.com', 'content' => 'No estoy del todo de acuerdo con el punto 3, pero buen enfoque en general.'],
        ];

        // Comentarios de usuarios registrados.
        $userComments = [
            'Gran trabajo con este post, lo compartiré con mi equipo.',
            'Coincido totalmente, en mi experiencia esto funciona muy bien.',
            'Aporte de valor, gracias por el detalle en los ejemplos.',
        ];

        foreach ($publishedPosts as $index => $post) {
            // 2-3 comentarios de invitado por post, casi todos aprobados.
            $sample = collect($guestComments)->shuffle()->take(rand(2, 3));

            foreach ($sample as $i => $guest) {
                Comment::create([
                    'content' => $guest['content'],
                    'status' => 'approved',
                    'author_name' => $guest['name'],
                    'author_email' => $guest['email'],
                    'author_ip' => '127.0.0.1',
                    'post_id' => $post->id,
                    'user_id' => null,
                    'parent_id' => null,
                ]);
            }

            // Un comentario de usuario registrado (si hay).
            if ($registeredUsers->isNotEmpty()) {
                $parent = Comment::create([
                    'content' => $userComments[array_rand($userComments)],
                    'status' => 'approved',
                    'author_name' => null,
                    'author_email' => null,
                    'author_ip' => '127.0.0.1',
                    'post_id' => $post->id,
                    'user_id' => $registeredUsers->random()->id,
                    'parent_id' => null,
                ]);

                // Una respuesta a ese comentario en algunos posts.
                if ($index % 2 === 0) {
                    Comment::create([
                        'content' => 'Gracias por tu comentario, ¡nos alegra que te haya sido útil!',
                        'status' => 'approved',
                        'author_name' => null,
                        'author_email' => null,
                        'author_ip' => '127.0.0.1',
                        'post_id' => $post->id,
                        'user_id' => $registeredUsers->random()->id,
                        'parent_id' => $parent->id,
                    ]);
                }
            }

            // Un comentario pendiente de moderación en algunos posts.
            if ($index % 3 === 0) {
                Comment::create([
                    'content' => 'Comentario en espera de revisión por el moderador.',
                    'status' => 'pending',
                    'author_name' => 'Visitante Anónimo',
                    'author_email' => 'anonimo@example.com',
                    'author_ip' => '127.0.0.1',
                    'post_id' => $post->id,
                    'user_id' => null,
                    'parent_id' => null,
                ]);
            }
        }

        $this->command->info('Comentarios de ejemplo creados exitosamente.');
    }
}
