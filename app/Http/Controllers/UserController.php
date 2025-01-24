<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user');
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['store']]);
        $this->middleware('permission:update user', ['only' => ['update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {   
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('index');
        return new UserCollection(User::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreUserRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            $role = Role::where('name', $validatedData['role'])->first();
            
            User::create([
                'role_id' => $role->id,
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'dob' => $validatedData['date_of_birth'],
                'age' => $validatedData['age'],
                'sex' => $validatedData['sex'],
                'address' => $validatedData['address'],
            ]);
        });

        return response()->json(['message' => 'User created successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(new UserResource($user))
            ->log('show');

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        User::findOrFail($user->id);

        $validatedData = app(UpdateUserRequest::class)->validated();

        DB::transaction(function () use ($validatedData, $user) {
            $role = Role::where('name', $validatedData['role'])->first();
            
            $user->update([
                'role_id' => $role->id,
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'dob' => $validatedData['date_of_birth'],
                'age' => $validatedData['age'],
                'sex' => $validatedData['sex'],
                'address' => $validatedData['address'],
            ]);
        });

        return response()->json(['message' => 'User updated successfully!'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
