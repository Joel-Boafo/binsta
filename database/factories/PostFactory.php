<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'caption' => $this->faker->sentence,
            'code' => $this->faker->text,
            'programming_language' => $this->faker->word,
            'user_id' => 1,
        ];
    }
}
