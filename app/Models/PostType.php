<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the posts for the post type.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get published posts for the post type.
     */
    public function publishedPosts()
    {
        return $this->hasMany(Post::class)->where('status', 'published');
    }

    /**
     * Scope a query to only include active post types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
