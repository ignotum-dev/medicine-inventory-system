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
    public function viewAny(User $user)
    {
        return $user->can('view category') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view categories.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category)
    {
        return $user->can('view category') 
            ? Response::allow() 
            : Response::deny('You do not have permission to view a category.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can('create category') 
            ? Response::allow() 
            : Response::deny('You do not have permission to create a category.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category)
    {
        return $user->can('update category') 
            ? Response::allow() 
            : Response::deny('You do not have permission to update a category.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category)
    {
        return $user->can('delete category') 
            ? Response::allow() 
            : Response::deny('You do not have permission to delete a category.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }
}
