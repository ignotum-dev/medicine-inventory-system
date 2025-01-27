<?php

namespace App\Policies;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can('view medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view medicines.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medicine $medicine)
    {
        return $user->can('view medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view a medicine.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can('create medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create a medicine.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Medicine $medicine)
    {
        return $user->can('update medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to udpate a medicine.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Medicine $medicine)
    {
        return $user->can('delete medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete a medicine.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Medicine $medicine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Medicine $medicine)
    {
        //
    }
}
