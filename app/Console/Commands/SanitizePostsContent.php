<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\HtmlSanitizer;
use Illuminate\Console\Command;

class SanitizePostsContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:sanitize-posts {--dry-run : Solo mostrar cuántos posts cambiarían, sin guardar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-sanea el contenido HTML de todos los posts con HTMLPurifier (limpia contenido guardado antes del fix de XSS)';

    /**
     * Execute the console command.
     */
    public function handle(HtmlSanitizer $sanitizer): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $changed = 0;
        $total = 0;

        Post::query()->chunkById(100, function ($posts) use ($sanitizer, $dryRun, &$changed, &$total) {
            foreach ($posts as $post) {
                $total++;
                $clean = $sanitizer->clean($post->content);

                if ($clean !== $post->content) {
                    $changed++;
                    $this->line("  #{$post->id}  {$post->title}");

                    if (! $dryRun) {
                        // Evitar tocar updated_at por una limpieza de seguridad.
                        Post::withoutTimestamps(fn () => $post->forceFill(['content' => $clean])->save());
                    }
                }
            }
        });

        $verb = $dryRun ? 'cambiarían' : 'saneados';
        $this->info("Revisados {$total} posts; {$changed} {$verb}.");

        return self::SUCCESS;
    }
}
