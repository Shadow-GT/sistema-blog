<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;

class SitemapController extends Controller
{
    /**
     * Sitemap XML: solo contenido público y publicado (nunca borradores ni admin).
     * Se construye en el controlador (no en Blade) para evitar el conflicto de
     * <?xml con short_open_tag. Cada <loc> se escapa como XML.
     */
    public function index()
    {
        $urls = [];
        $urls[] = ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'];

        foreach (Post::published()->select('slug', 'updated_at')->latest('published_at')->get() as $post) {
            $urls[] = [
                'loc' => route('blog.show', $post->slug),
                'lastmod' => $post->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }
        foreach (Category::active()->select('slug', 'updated_at')->get() as $category) {
            $urls[] = [
                'loc' => route('blog.category', $category->slug),
                'lastmod' => $category->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }
        foreach (PostType::active()->select('slug', 'updated_at')->get() as $postType) {
            $urls[] = [
                'loc' => route('blog.post-type', $postType->slug),
                'lastmod' => $postType->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . "\n";
            if (isset($u['lastmod'])) {
                $xml .= '    <lastmod>' . $u['lastmod'] . '</lastmod>' . "\n";
            }
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }
        $xml .= '</urlset>' . "\n";

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * robots.txt dinámico: permite el contenido público, bloquea áreas privadas
     * y apunta al sitemap usando la URL real de la app.
     */
    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /dashboard',
            'Disallow: /posts',
            'Disallow: /moderation',
            'Disallow: /comments',
            'Disallow: /profile',
            'Disallow: /login',
            'Disallow: /register',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
            '',
        ];

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain');
    }
}
