<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can('view brand') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view brands.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand)
    {
        return $user->can('view brand') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view a brands.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can('create brand') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create a brand.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand)
    {
        return $user->can('update brand') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update a brand.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand)
    {
        return $user->can('delete brand') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete a brand.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Brand $brand)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Brand $brand)
    {
        //
    }
}
