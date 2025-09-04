<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class FixPublishedAtDates extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'blog:fix-published-dates';

    /**
     * The console command description.
     */
    protected $description = 'Fix published_at dates for posts that have status published but null published_at';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando posts publicados sin fecha de publicación...');

        // Encontrar posts con status 'published' pero published_at null
        $postsToFix = Post::where('status', 'published')
            ->whereNull('published_at')
            ->get();

        if ($postsToFix->isEmpty()) {
            $this->info('✓ No se encontraron posts que necesiten corrección.');
            return 0;
        }

        $this->info("Encontrados {$postsToFix->count()} posts que necesitan corrección:");

        foreach ($postsToFix as $post) {
            // Usar created_at como published_at
            $post->update([
                'published_at' => $post->created_at
            ]);

            $this->info("✓ Post '{$post->title}' - published_at establecido a {$post->created_at}");
        }

        $this->info("✅ {$postsToFix->count()} posts corregidos exitosamente.");
        
        return 0;
    }
}
