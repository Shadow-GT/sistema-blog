<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(8, true),
            'status' => fake()->randomElement(['draft', 'pending', 'published']),
            'is_featured' => fake()->boolean(20), // 20% probabilidad de ser destacado
            'views_count' => fake()->numberBetween(0, 1000),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'post_type_id' => PostType::factory(),
        ];
    }
}
