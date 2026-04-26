<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $comments = [
            'This looks serious',
            'I think this is not a big issue',
            'Authorities should investigate',
            'This might be fake information',
            'Very concerning situation',
            'Thanks for sharing this update'
        ];

        return [
            'post_id' => Post::inRandomOrder()->first()?->id ?? Post::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'content' => fake()->randomElement($comments),
            'is_flagged' => fake()->boolean(30),
        ];
    }
}