<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Console\Command;

class SeedDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:seed-dummy
                            {--posts=50 : Cantidad de posts a generar}
                            {--no-comments : No generar comentarios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera data dummy adicional (posts + comentarios) sobre las categorías, tipos y usuarios existentes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = max(1, (int) $this->option('posts'));

        if (Category::count() === 0 || PostType::count() === 0 || User::where('role', '!=', 'guest')->count() === 0) {
            $this->error('Faltan categorías, tipos o usuarios. Corre primero: php artisan db:seed');
            return self::FAILURE;
        }

        $this->info("Generando {$count} posts...");
        $posts = Post::factory($count)->create();

        if (! $this->option('no-comments')) {
            $published = $posts->where('status', 'published');
            $this->info("Generando comentarios para {$published->count()} posts publicados...");

            $bar = $this->output->createProgressBar($published->count());
            foreach ($published as $post) {
                $n = rand(0, 8);
                if ($n > 0) {
                    $parents = Comment::factory($n)->create([
                        'post_id' => $post->id,
                        'parent_id' => null,
                    ]);

                    // Algunas respuestas a comentarios al azar.
                    foreach ($parents->random(min(2, $parents->count())) as $parent) {
                        if (rand(0, 1) === 1) {
                            Comment::factory(rand(1, 2))->create([
                                'post_id' => $post->id,
                                'parent_id' => $parent->id,
                                'status' => 'approved',
                            ]);
                        }
                    }
                }
                $bar->advance();
            }
            $bar->finish();
            $this->newLine();
        }

        $this->newLine();
        $this->info('Listo. Totales en BD → posts: ' . Post::count()
            . ' | publicados: ' . Post::where('status', 'published')->count()
            . ' | comentarios: ' . Comment::count());

        return self::SUCCESS;
    }
}
