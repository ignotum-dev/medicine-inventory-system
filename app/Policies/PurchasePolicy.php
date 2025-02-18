<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
{
    public function purchase(User $user, Purchase $purchase)
    {
        return $user->can('purchase medicine') 
            ? Response::allow() 
            : Response::deny('You do not have permission to purchase medicines.');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Purchase $purchase)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Purchase $purchase)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Purchase $purchase)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Purchase $purchase)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Purchase $purchase)
    {
        //
    }
}
