<?php

namespace App\Policies;

<<<<<<< HEAD
use App\Models\User;
use Spatie\Permission\Models\Role;
=======
use App\Models\Role;
use App\Models\User;
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
<<<<<<< HEAD
    public function viewAny(User $user)
    {
        return $user->can('view role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view roles.');
=======
    public function viewAny(User $auth_user)
    {
        return $auth_user->hasPermissionTo('view role');
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    }

    /**
     * Determine whether the user can view the model.
     */
<<<<<<< HEAD
    public function view(User $user, Role $role)
    {
        return $user->can('view role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view a role.');
=======
    public function view(User $auth_user, Role $role): bool
    {
        return $auth_user->hasPermissionTo('view role');
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    }

    /**
     * Determine whether the user can create models.
     */
<<<<<<< HEAD
    public function create(User $user)
    {
        return $user->can('create role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create a role.');
=======
    public function create(User $auth_user)
    {
        return $auth_user->hasPermissionTo('create role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create roles.');
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    }

    /**
     * Determine whether the user can update the model.
     */
<<<<<<< HEAD
    public function update(User $user, Role $role)
    {   
        return $user->can('update role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update a role.');
=======
    public function update(User $auth_user, Role $role)
    {   
        return $auth_user->hasPermissionTo('update role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update roles.');
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    }

    /**
     * Determine whether the user can delete the model.
     */
<<<<<<< HEAD
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
=======
    public function delete(User $auth_user, Role $role)
    {
        return $auth_user->hasPermissionTo('delete role') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete roles.');
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    }

    /**
     * Determine whether the user can restore the model.
     */
<<<<<<< HEAD
    public function restore(User $user, Role $role)
=======
    public function restore(User $user, Role $role): bool
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
<<<<<<< HEAD
    public function forceDelete(User $user, Role $role)
=======
    public function forceDelete(User $user, Role $role): bool
>>>>>>> 8f82500482b1c3d9edd0639f68b19ff560969967
    {
        //
    }
}
