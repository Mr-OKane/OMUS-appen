<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use App\Models\PostalCode;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostalCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','postalcode.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PostalCode $postalCode)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','postalcode.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PostalCode $postalCode)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PostalCode $postalCode)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PostalCode $postalCode)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PostalCode $postalCode)
    {
        //
    }
}
