<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_name' => fake()->company,
            'description' => fake()->realTextBetween('30', '70'),
            'location' => fake()->address,
            'photo' => 'storage/warehouses-photos/1715093954_663a41c2a8154.jpg'
        ];
    }
}
