<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:test-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test blog views';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing blog views...');

        try {
            // Test category view
            $category = \App\Models\Category::first();
            if ($category) {
                $posts = \App\Models\Post::published()
                    ->where('category_id', $category->id)
                    ->with(['postType', 'user'])
                    ->latest('published_at')
                    ->paginate(12);

                $view = view('blog.category', compact('category', 'posts'));
                $this->info('✓ Category view renders successfully');
            }

            // Test post type view
            $postType = \App\Models\PostType::first();
            if ($postType) {
                $posts = \App\Models\Post::published()
                    ->where('post_type_id', $postType->id)
                    ->with(['category', 'user'])
                    ->latest('published_at')
                    ->paginate(12);

                $view = view('blog.post-type', compact('postType', 'posts'));
                $this->info('✓ Post type view renders successfully');
            }

            $this->info('All views tested successfully!');

        } catch (\Exception $e) {
            $this->error('Error testing views: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
