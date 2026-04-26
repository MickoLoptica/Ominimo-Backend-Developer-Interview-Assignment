<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $scenarios = [
            ['title' => 'Fire broke out in city center', 'content' => 'A major fire caused damage to several buildings'],
            ['title' => 'Minor accident on highway', 'content' => 'A small accident happened with no injuries'],
            ['title' => 'Theft reported in local store', 'content' => 'A theft occurred during the night shift'],
            ['title' => 'System damage detected', 'content' => 'Critical damage detected in infrastructure'],
            ['title' => 'Community event success', 'content' => 'A local event was successful and peaceful'],
        ];

        $selected = fake()->randomElement($scenarios);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $selected['title'],
            'content' => $selected['content'],
            'risk_score' => fake()->numberBetween(10, 90),
            'risk_level' => fake()->randomElement(['low', 'medium', 'high']),
        ];
    }
}