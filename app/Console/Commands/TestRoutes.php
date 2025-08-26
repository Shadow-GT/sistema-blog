<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:test-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test blog routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing blog routes...');

        // Test category routes
        $categories = \App\Models\Category::all();
        $this->info('Testing category routes:');
        foreach ($categories as $category) {
            $url = route('blog.category', $category->slug);
            $this->line("Category: {$category->name} -> {$url}");
        }

        // Test post type routes
        $postTypes = \App\Models\PostType::all();
        $this->info('Testing post type routes:');
        foreach ($postTypes as $postType) {
            $url = route('blog.post-type', $postType->slug);
            $this->line("Post Type: {$postType->name} -> {$url}");
        }

        // Test post routes
        $posts = \App\Models\Post::published()->take(3)->get();
        $this->info('Testing post routes:');
        foreach ($posts as $post) {
            $url = route('blog.show', $post->slug);
            $this->line("Post: {$post->title} -> {$url}");
        }

        $this->info('Done!');
    }
}
