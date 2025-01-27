<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can('view role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view roles.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role)
    {
        return $user->can('view role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view a role.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can('create role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create a role.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role)
    {   
        return $user->can('update role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update a role.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role)
    {
        return $user->can('delete role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete a role.');
    }

    public function addPermissionsToRole(User $user)
    {
        return $user->can('update role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to add permissions to a role.');
    }

    public function showPermissionsToRole(User $user, Role $role)
    {
        return $user->can('view role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view permissions to a role.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
