<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json(['permissions' => $permissions], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
    
        $permission = Permission::create([
            'name' => $validated['name'],
        ]);
    
        return response()->json(['message' => 'Permission created successfully', 'permission' => $permission], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $permissionId)
    {
        $permission = Permission::findOrFail($permissionId);

        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $validated['name'],
        ]);

        return response()->json(['message' => 'Permission updated successfully', 'permission' => $permission], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }
}
