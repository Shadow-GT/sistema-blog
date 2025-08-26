<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:check-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check categories and their slugs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking categories...');

        $categories = \App\Models\Category::all();

        if ($categories->isEmpty()) {
            $this->error('No categories found!');
            return;
        }

        $this->info('Found ' . $categories->count() . ' categories:');

        foreach ($categories as $category) {
            $this->line("ID: {$category->id} | Name: {$category->name} | Slug: {$category->slug}");
        }

        $this->info('Done!');
    }
}
