<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commercial_name' => fake()->word,
            'scientific_name' => fake()->word,
            'factory_name' => fake()->word,
            'price' => fake()->numberBetween(10,100)
        ];
    }
}
