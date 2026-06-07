<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\PostType;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Proporciona las categorías y tipos de post del navbar/footer del blog público.
 * Cacheado 1h para no ejecutar 4 consultas withCount en cada request del layout.
 */
class NavigationComposer
{
    public function compose(View $view): void
    {
        $navCategories = Cache::remember('nav.categories', now()->addHour(), function () {
            return Category::active()
                ->withCount(['posts as published_posts_count' => function ($q) {
                    $q->where('status', 'published');
                }])
                ->orderBy('name')
                ->get();
        });

        $navPostTypes = Cache::remember('nav.post_types', now()->addHour(), function () {
            return PostType::active()
                ->withCount(['posts as published_posts_count' => function ($q) {
                    $q->where('status', 'published');
                }])
                ->orderBy('name')
                ->get();
        });

        $view->with(compact('navCategories', 'navPostTypes'));
    }
}
