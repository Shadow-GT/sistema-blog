<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Forma pública de un post para la API. Actúa como whitelist:
 * solo expone estos campos (nunca user_id, email del autor, status, etc.).
 */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'url' => route('blog.show', $this->slug),
            'image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'author' => $this->whenLoaded('user', fn () => $this->user->name),
            'category' => $this->whenLoaded('category', fn () => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
                'color' => $this->category->color,
            ]),
            'type' => $this->whenLoaded('postType', fn () => [
                'name' => $this->postType->name,
                'icon' => $this->postType->icon,
            ]),
            'published_at' => optional($this->published_at)->toIso8601String(),
            'reading_minutes' => max(1, (int) ceil(str_word_count(strip_tags((string) $this->content)) / 200)),
        ];
    }
}
