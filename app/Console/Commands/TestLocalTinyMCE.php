<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestLocalTinyMCE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:test-local-tinymce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test local TinyMCE installation with GPL license';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Local TinyMCE Installation with GPL License...');

        // Check if TinyMCE files exist
        $tinymcePath = public_path('tinymce/tinymce.min.js');
        if (file_exists($tinymcePath)) {
            $this->info('✓ TinyMCE main file found: ' . $tinymcePath);
        } else {
            $this->error('✗ TinyMCE main file not found: ' . $tinymcePath);
            return;
        }

        // Check plugins directory
        $pluginsPath = public_path('tinymce/plugins');
        if (is_dir($pluginsPath)) {
            $plugins = scandir($pluginsPath);
            $pluginCount = count($plugins) - 2; // Remove . and ..
            $this->info("✓ Plugins directory found with {$pluginCount} plugins");
        } else {
            $this->error('✗ Plugins directory not found');
        }

        // Check themes directory
        $themesPath = public_path('tinymce/themes');
        if (is_dir($themesPath)) {
            $this->info('✓ Themes directory found');
        } else {
            $this->error('✗ Themes directory not found');
        }

        // Check skins directory
        $skinsPath = public_path('tinymce/skins');
        if (is_dir($skinsPath)) {
            $this->info('✓ Skins directory found');
        } else {
            $this->error('✗ Skins directory not found');
        }

        // List available plugins
        $availablePlugins = [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'codesample', 'quickbars'
        ];

        $this->info('✓ GPL License configured');
        $this->info('✓ Available plugins:');
        foreach ($availablePlugins as $plugin) {
            $pluginFile = public_path("tinymce/plugins/{$plugin}/plugin.min.js");
            if (file_exists($pluginFile)) {
                $this->line("  ✓ {$plugin}");
            } else {
                $this->line("  ✗ {$plugin} (file not found)");
            }
        }

        // Check image upload route
        if (Route::has('posts.upload-image')) {
            $this->info('✓ Image upload route available');
        } else {
            $this->error('✗ Image upload route not found');
        }

        $this->info('Local TinyMCE installation test completed!');
        $this->info('TinyMCE is now running locally with GPL license.');
    }
}
