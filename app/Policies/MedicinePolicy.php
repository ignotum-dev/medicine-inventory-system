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
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medicine $medicine): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $auth_user): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $auth_user, Medicine $medicine): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder() || $auth_user->isPharmacist())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth_user, Medicine $medicine): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Medicine $medicine): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Medicine $medicine): bool
    {
        //
    }
}
