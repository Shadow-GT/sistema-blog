<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class CleanupComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:cleanup-comments {--days=30 : Number of days to keep rejected comments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old rejected comments and spam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = now()->subDays($days);

        $this->info("Limpiando comentarios rechazados anteriores a {$cutoffDate->format('Y-m-d')}...");

        $deletedCount = Comment::where('status', 'rejected')
            ->where('created_at', '<', $cutoffDate)
            ->delete();

        $this->info("Se eliminaron {$deletedCount} comentarios rechazados.");

        // También limpiar comentarios pendientes muy antiguos (más de 90 días)
        $oldPendingCount = Comment::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(90))
            ->delete();

        if ($oldPendingCount > 0) {
            $this->info("Se eliminaron {$oldPendingCount} comentarios pendientes muy antiguos.");
        }

        $this->info('Limpieza completada exitosamente.');
    }
}
