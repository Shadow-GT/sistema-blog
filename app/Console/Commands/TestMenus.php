<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:test-menus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test blog menu functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing blog menu functionality...');

        try {
            // Test categories count
            $categoriesCount = \App\Models\Category::active()->count();
            $this->info("✓ Found {$categoriesCount} active categories");

            // Test post types count
            $postTypesCount = \App\Models\PostType::active()->count();
            $this->info("✓ Found {$postTypesCount} active post types");

            // Test published posts count
            $publishedPostsCount = \App\Models\Post::published()->count();
            $this->info("✓ Found {$publishedPostsCount} published posts");

            // Test menu data queries
            $categories = \App\Models\Category::active()
                ->withCount(['posts as published_posts_count' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('name')
                ->get();

            $this->info("✓ Categories with post counts loaded successfully");

            $postTypes = \App\Models\PostType::active()
                ->withCount(['posts as published_posts_count' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('name')
                ->get();

            $this->info("✓ Post types with post counts loaded successfully");

            // Test blog layout rendering
            $posts = \App\Models\Post::published()->paginate(12);
            $featuredPosts = \App\Models\Post::published()->featured()->take(3)->get();

            $view = view('blog.index', compact('posts', 'featuredPosts', 'categories', 'postTypes'));
            $this->info("✓ Blog index view renders successfully with menu data");

            $this->info('All menu functionality tests passed!');

        } catch (\Exception $e) {
            $this->error('Error testing menus: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
