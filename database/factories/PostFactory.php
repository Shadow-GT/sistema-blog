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
        $title = rtrim(fake()->unique()->sentence(fake()->numberBetween(4, 8)), '.');
        $isPublished = fake()->boolean(75);

        $content = collect(fake()->paragraphs(fake()->numberBetween(4, 9)))
            ->map(fn ($p) => '<p>' . $p . '</p>')
            ->implode("\n");

        return [
            'title' => Str::ucfirst($title),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 1_000_000),
            'excerpt' => fake()->sentence(fake()->numberBetween(12, 22)),
            'content' => $content,
            'featured_image' => null,
            'status' => $isPublished ? 'published' : fake()->randomElement(['pending', 'pending', 'draft']),
            'is_featured' => fake()->boolean(15),
            'views_count' => fake()->numberBetween(0, 4000),
            'published_at' => $isPublished ? fake()->dateTimeBetween('-8 months', 'now') : null,
            // Usa registros existentes; cae a factory solo si la tabla está vacía.
            'user_id' => fn () => User::where('role', '!=', 'guest')->inRandomOrder()->value('id') ?? User::factory(),
            'category_id' => fn () => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'post_type_id' => fn () => PostType::inRandomOrder()->value('id') ?? PostType::factory(),
        ];
    }

    /**
     * Estado: post publicado.
     */
    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-8 months', 'now'),
        ]);
    }
}
