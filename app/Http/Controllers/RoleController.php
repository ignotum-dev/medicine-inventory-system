<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Spatie\Permission\Models\Role;
=======
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Role::class, 'role');
<<<<<<< HEAD
=======
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
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
<<<<<<< HEAD
    {   
=======
    {
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
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

<<<<<<< HEAD
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
=======
    public function addPermissionToRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->toArray();

        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ], 200);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return response()->json(['message' => 'Permissions added to role'], 200);
    }

>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
}
