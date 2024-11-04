<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'company' => fake()->word,
            'description' => fake()->text,
            'location' => fake()->word,
            'type' => fake()->word,
            'salary' => fake()->numberBetween(10000, 1000000),
            'application_deadline' => fake()->dateTime(),
        ];
    }
}
