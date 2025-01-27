<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create role', 'view role', 'update role', 'delete role',
            'create permission', 'view permission', 'update permission', 'delete permission',
            'create user', 'view user', 'update user', 'delete user',
            'create medicine', 'view medicine', 'update medicine', 'delete medicine',
            'create category', 'view category', 'update category', 'delete category',
            'create supplier', 'view supplier', 'update supplier', 'delete supplier',
            'purchase medicine'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
