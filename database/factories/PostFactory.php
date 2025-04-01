<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['text', 'image', 'video']),
            'content' => $this->faker->paragraph(),
            'caption' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'hashtags' => json_encode([$this->faker->word(), $this->faker->word()]),
            'media' => null,
            'user_id' => User::factory()
        ];
    }
}
