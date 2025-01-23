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
        
        $data = [
            [
                'role_id' => 1,
                'first_name' => fake()->firstName,
                'middle_name' => fake()->optional()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'username' => 'admin',
                'password' => '',
                'dob' => $dob,
                'age' => $this->calculateAge($dob),
                'sex' => fake()->randomElement(['Male', 'Female']),
                'address' => fake()->address,
            ],

            [
                'role_id' => 2,
                'first_name' => fake()->firstName,
                'middle_name' => fake()->optional()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'username' => 'encoder',
                'password' => '',
                'dob' => $dob,
                'age' => $this->calculateAge($dob),
                'sex' => fake()->randomElement(['Male', 'Female']),
                'address' => fake()->address,
            ],

            [
                'role_id' => 3,
                'first_name' => fake()->firstName,
                'middle_name' => fake()->optional()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'username' => 'pharmacist',
                'password' => '',
                'dob' => $dob,
                'age' => $this->calculateAge($dob),
                'sex' => fake()->randomElement(['Male', 'Female']),
                'address' => fake()->address,
            ],

            [
                'role_id' => 4,
                'first_name' => fake()->firstName,
                'middle_name' => fake()->optional()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'username' => 'viewer',
                'password' => '',
                'dob' => $dob,
                'age' => $this->calculateAge($dob),
                'sex' => fake()->randomElement(['Male', 'Female']),
                'address' => fake()->address,
            ],

            // [
            //     'role_id' => 4,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'viewer',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 3,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'pharmacist',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 2,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'encoder',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 2,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'encoder',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 4,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'viewer',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 3,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'pharmacist',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 4,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'viewer',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 3,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'pharmacist',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 3,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'pharmacist',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],

            // [
            //     'role_id' => 4,
            //     'first_name' => fake()->firstName,
            //     'middle_name' => fake()->optional()->firstName,
            //     'last_name' => fake()->lastName,
            //     'email' => fake()->unique()->safeEmail(),
            //     'email_verified_at' => now(),
            //     'username' => 'viewer',
            //     'password' => '',
            //     'dob' => $dob,
            //     'age' => $this->calculateAge($dob),
            //     'sex' => fake()->randomElement(['Male', 'Female']),
            //     'address' => fake()->address,
            // ],
        ];

        $data = array_map(function ($user) {
            if (app()->environment('production')) {
                $user['password'] = bcrypt('P455w0rd');
            } else {
                $user['password'] = bcrypt($user['username']);
            }
            return $user;
        }, $data);

        DB::table('users')->insert($data);
    }

    private function calculateAge($dob)
    {
        return Carbon::parse($dob)->age;
    }
}
