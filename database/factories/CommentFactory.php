<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isGuest = fake()->boolean(60);

        return [
            'content' => fake()->paragraph(fake()->numberBetween(1, 3)),
            'status' => fake()->randomElement(['approved', 'approved', 'approved', 'pending']),
            'author_name' => $isGuest ? fake()->name() : null,
            'author_email' => $isGuest ? fake()->safeEmail() : null,
            'author_ip' => fake()->ipv4(),
            'user_id' => $isGuest ? null : (fn () => User::inRandomOrder()->value('id')),
            'post_id' => fn () => Post::inRandomOrder()->value('id') ?? Post::factory(),
            'parent_id' => null,
        ];
    }
}
