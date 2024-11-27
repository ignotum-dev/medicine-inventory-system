<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $auth_user): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth_user, Supplier $supplier)
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
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
    public function update(User $auth_user, Supplier $supplier)
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth_user, Supplier $supplier): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        //
    }
}
