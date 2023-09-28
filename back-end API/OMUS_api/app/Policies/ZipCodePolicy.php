<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use App\Models\ZipCode;
use Illuminate\Auth\Access\Response;

class ZipCodePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','zipcode.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','zipcode.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
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
    public function update(User $user, ZipCode $zipCode)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ZipCode $zipCode)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ZipCode $zipCode)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ZipCode $zipCode)
    {
        //
    }
}
