<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * API pública (solo lectura) de posts publicados.
 * Seguridad: solo status=published, salida vía PostResource (whitelist),
 * per_page topado, rate-limit del grupo 'api' (60/min/IP) y CORS restringido.
 */
class PostController extends Controller
{
    /**
     * Listado paginado de posts publicados.
     */
    public function index(Request $request)
    {
        $perPage = min(50, max(1, (int) $request->query('per_page', 12)));

        $posts = Post::published()
            ->with(['category', 'postType', 'user'])
            ->latest('published_at') // por fecha de publicación, lo más reciente primero
            ->paginate($perPage)
            ->withQueryString();

        return PostResource::collection($posts);
    }

    /**
     * Los últimos N posts publicados (cacheado 5 min).
     */
    public function latest(Request $request)
    {
        $limit = min(20, max(1, (int) $request->query('limit', 6)));

        $posts = Cache::remember("api.posts.latest.{$limit}", now()->addMinutes(5), function () use ($limit) {
            return Post::published()
                ->with(['category', 'postType', 'user'])
                ->latest('published_at') // por fecha de publicación, lo más reciente primero
                ->take($limit)
                ->get();
        });

        return PostResource::collection($posts);
    }
}
