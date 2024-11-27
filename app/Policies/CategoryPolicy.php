<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $auth_user)
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth_user, Category $category)
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
    public function update(User $auth_user, Category $category): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth_user, Category $category): bool
    {
        if ($auth_user->isAdmin() || $auth_user->isEncoder())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        //
    }
}
