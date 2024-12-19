<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->realText(),
            'release_date' => $this->faker->dateTime(),
            'rating' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'ticket_price' => $this->faker->randomFloat(2, 5, 20),
            'country' => $this->faker->country(),
            'genre' => $this->faker->word,
            'photo' => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
            ],
        ];
    }
}
