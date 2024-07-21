<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()
                ->hasAttached(Role::find(random_int(1,2)))
                ->create([
                    'user_type' => 'employee'
                ])->id,

            'employee_name' => fake()->name,
            'salary' => fake()->numberBetween(1000, 5000)
        ];
    }
}
