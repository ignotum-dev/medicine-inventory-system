<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Role::class, 'role');
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
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

}
