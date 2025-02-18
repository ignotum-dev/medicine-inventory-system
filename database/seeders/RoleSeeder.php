<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $encoderRole = Role::create(['name' => 'encoder']);
        $pharmacistRole = Role::create(['name' => 'pharmacist']);
        $viewerRole = Role::create(['name' => 'viewer']);

        $permissions = Permission::pluck('name')->toArray();

        // Admin gets all permissions
        $adminRole->givePermissionTo($permissions);

        // Encoder, Pharmacist, Viewer roles permissions
        $encoderRole->givePermissionTo([
            'create medicine', 'view medicine', 'update medicine', 'delete medicine',
            'create category', 'view category', 'update category', 'delete category',
            'create supplier', 'view supplier', 'update supplier', 'delete supplier',
            'purchase medicine'
        ]);

        $pharmacistRole->givePermissionTo([
            'view medicine', 'update medicine', 'purchase medicine'
        ]);

        $viewerRole->givePermissionTo([
            'view medicine'
        ]);
    }
}
