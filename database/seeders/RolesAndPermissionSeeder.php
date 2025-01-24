<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
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

        // Update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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
