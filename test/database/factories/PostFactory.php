<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
        $rawTitle = fake()->words(rand(3, 6), true);
        $title = Str::limit(ucfirst($rawTitle), 45, '');
        $slug = Str::limit(Str::slug($title), 50, '');

        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
