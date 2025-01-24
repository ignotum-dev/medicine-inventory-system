<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dob = fake()->dateTimeBetween('-60 years', '-18 years');
        
        $adminUser = User::firstOrCreate([
            'role_id' => 1,
            'first_name' => fake()->firstName,
            'middle_name' => fake()->lastName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'username' => 'admin',
            'password' => '',
            'dob' => $dob,
            'age' => $this->calculateAge($dob),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address,
        ]);
        $adminUser->assignRole('admin');

        $encoderUser = User::firstOrCreate([
            'role_id' => 2,
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'username' => 'encoder',
            'password' => '',
            'dob' => $dob,
            'age' => $this->calculateAge($dob),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address,
        ]);
        $encoderUser->assignRole('encoder');

        $pharmacistUser = User::firstOrCreate([
            'role_id' => 3,
            'first_name' => fake()->firstName,
            'middle_name' => fake()->lastName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'username' => 'pharmacist',
            'password' => '',
            'dob' => $dob,
            'age' => $this->calculateAge($dob),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address,
        ]);
        $pharmacistUser->assignRole('pharmacist');

        $viewerUser = User::firstOrCreate([
            'role_id' => 4,
            'first_name' => fake()->firstName,
            'middle_name' => fake()->lastName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'username' => 'viewer',
            'password' => '',
            'dob' => $dob,
            'age' => $this->calculateAge($dob),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address,
        ]);
        $viewerUser->assignRole('viewer');

        // Update passwords based on environment
        $users = User::all();
        $users->each(function($user) {
            if (app()->environment('production')) {
                $user->update(['password' => bcrypt('P455w0rd')]);
            } else {
                $user->update(['password' => bcrypt($user->username)]);
            }
        });
    }

    private function calculateAge($dob)
    {
        return Carbon::parse($dob)->age;
    }
}
