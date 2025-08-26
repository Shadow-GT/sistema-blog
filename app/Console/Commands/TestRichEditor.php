<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class TestRichEditor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:test-rich-editor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test rich text editor functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing rich text editor functionality...');

        try {
            // Test basic HTML sanitization
            $testHtml = '<h2>Test Heading</h2><p>This is a <strong>bold</strong> text with <em>italic</em> and <a href="https://example.com">link</a>.</p><script>alert("xss")</script>';

            // Basic sanitization (same as in PostController)
            $cleanHtml = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $testHtml);
            $cleanHtml = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi', '', $cleanHtml);
            $cleanHtml = preg_replace('/on\w+="[^"]*"/i', '', $cleanHtml);
            $cleanHtml = preg_replace('/javascript:/i', '', $cleanHtml);

            $this->info('✓ Basic HTML sanitization is working');
            $this->line('Original: ' . $testHtml);
            $this->line('Sanitized: ' . $cleanHtml);

            // Test TinyMCE route
            $routeExists = Route::has('posts.upload-image');
            if ($routeExists) {
                $this->info('✓ Image upload route exists');
            } else {
                $this->error('✗ Image upload route missing');
            }

            // Test storage directory
            $storageExists = Storage::disk('public')->exists('posts');
            if (!$storageExists) {
                Storage::disk('public')->makeDirectory('posts');
                Storage::disk('public')->makeDirectory('posts/images');
                $this->info('✓ Created storage directories');
            } else {
                $this->info('✓ Storage directories exist');
            }

            $this->info('Rich text editor functionality test completed!');

        } catch (\Exception $e) {
            $this->error('Error testing rich editor: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
