<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'contact_number' => $this->faker->numerify('+639#########'),
            'address' => $this->faker->address,
            'email' => $this->faker->safeEmail,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
