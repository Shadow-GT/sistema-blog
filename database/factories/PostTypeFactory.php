<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostType>
 */
class PostTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->word());

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100_000),
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement(['📚', '📄', '📰', '⭐', '🔍', '💡', '🎯', '🚀']),
            'is_active' => true,
        ];
    }
}
