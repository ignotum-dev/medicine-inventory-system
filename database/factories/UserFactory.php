<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dob = fake()->dateTimeBetween('-60 years', '-18 years');

        return [
            'role_id' => Role::pluck('id')->random(),

            'first_name' => fake()->firstName,
            'middle_name' => fake()->optional()->firstName,
            'last_name' => fake()->lastName,

            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'dob' => $dob,
            'age' => $this->calculateAge($dob),
            'sex' => fake()->randomElement(['Male', 'Female']),

            'address' => fake()->address,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function calculateAge($dob)
    {
        return Carbon::parse($dob)->age;
    }
}
