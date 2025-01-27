<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dob = fake()->dateTimeBetween('-60 years', '-18 years');

        // Create Permissions
        $rolePermissions = [
            'create role',
            'view role',
            'update role',
            'delete role',
        ];

        foreach ($rolePermissions as $rolePermission) {
            Permission::create(['name' => $rolePermission]);
        }

        $permissions = [
            'create permission',
            'view permission',
            'update permission',
            'delete permission',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $userPermissions = [
            'create user',
            'view user',
            'update user',
            'delete user',
        ];

        foreach ($userPermissions as $userPermission) {
            Permission::create(['name' => $userPermission]);
        }

        $medicinePermissions = [
            'create medicine',
            'view medicine',
            'update medicine',
            'delete medicine',
        ];

        foreach ($medicinePermissions as $medicinePermission) {
            Permission::create(['name' => $medicinePermission]);
        }

        $categoryPermissions = [
            'create category',
            'view category',
            'update category',
            'delete category',
        ];

        foreach ($categoryPermissions as $categoryPermission) {
            Permission::create(['name' => $categoryPermission]);
        }

        $supplierPermissions = [
            'create medicine',
            'view medicine',
            'update medicine',
            'delete medicine',
        ];

        foreach ($supplierPermissions as $supplierPermission) {
            Permission::create(['name' => $supplierPermission]);
        }

        $purchasePermissions = Permission::create(['name' => 'purchase medicine']);


        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $encoderRole = Role::create(['name' => 'encode']);
        $pharmacistRole = Role::create(['name' => 'pharmacist']);
        $viewerRole = Role::create(['name' => 'viewer']);

        // Lets give all permission to admin role
        $allPermissionNames = Permission::pluck('name')->toArray();
        $adminRole->givePermissionTo($allPermissionNames);

        $encoderRole->givePermissionTo($medicinePermissions, $categoryPermissions, $supplierPermissions, $purchasePermissions);

        $pharmacistRole->givePermissionTo(
            'view medicine',
            'update medicine',
            $purchasePermissions
        );

        $viewerRole->givePermissionTo('view medicine');

        // Let's Create User and assign Role to it.
        $adminUser = User::firstOrCreate([
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
        ]);
        $adminUser->assignRole($adminRole);

        $encoderUser = User::firstOrCreate([
            'role_id' => 2,
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
        ]);
        $encoderUser->assignRole($encoderRole);

        $pharmacistUser = User::firstOrCreate([
            'role_id' => 3,
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
        ]);
        $pharmacistUser->assignRole($pharmacistRole);

        $viewerUser = User::firstOrCreate([
            'role_id' => 4,
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
        ]);
        $viewerUser->assignRole($viewerRole);
    }
    
    private function calculateAge($dob)
    {
        return Carbon::parse($dob)->age;
    }
}
