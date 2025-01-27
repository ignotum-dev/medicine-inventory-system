<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {   
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
        ]);

        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function update(Request $request, Role $role)
    {      
        $roleData = Role::findOrFail($role->id);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $roleData->id,
        ]);

        $roleData->update([
            'name' => $validated['name'],
        ]);

        return response()->json(['message' => 'Role updated successfully', 'role' => $roleData], 200);
    }

    public function destroy(Role $role)
    {   
        try {
            $role->delete();

            return response()->json([
                'message' => 'Supplier removed successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to remove the supplier',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addPermissionsToRole(Request $request, Role $role)
    {
        $this->authorize('addPermissionsToRole', $role);

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'permissions.required' => 'Please select at least one permission.',
            'permissions.array' => 'The permissions must be an array.',
            'permissions.*.exists' => 'One of the permission is invalid.', // Or a more specific message
        ]);;

        // Sync the permissions to the role (this will replace the old permissions)
        $role->syncPermissions($request->input('permissions'));

        return response()->json([
            'message' => 'Permissions successfully updated for the role.'
        ], 200);
    }

    public function showPermissionsToRole(Request $request, Role $role)
    {
        $this->authorize('showPermissionsToRole', $role);

        // Get the permissions associated with the role
        $permissions = $role->permissions;

        // Return the permissions in a response
        return response()->json([
            'role' => $role->name,
            'permissions' => $permissions->pluck('name') // Return only the permission names
        ]);
    }
}
