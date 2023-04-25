<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VacationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'depart' => $this->faker->date(),
            'return' => $this->faker->date(),
            'admin_read' => $this->faker->boolean(),
            'manager_read' => $this->faker->boolean(),
            'employee_read' => $this->faker->boolean(),
        ];
    }
}
