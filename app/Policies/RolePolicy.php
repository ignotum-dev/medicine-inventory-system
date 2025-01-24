<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $auth_user)
    {
        return $auth_user->hasPermissionTo('view role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth_user, Role $role): bool
    {
        return $auth_user->hasPermissionTo('view role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $auth_user)
    {
        return $auth_user->hasPermissionTo('create role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create roles.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $auth_user, Role $role)
    {   
        return $auth_user->hasPermissionTo('update role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update roles.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth_user, Role $role)
    {
        return $auth_user->hasPermissionTo('delete role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete roles.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        //
    }
}
