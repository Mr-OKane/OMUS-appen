<?php

namespace App\Policies;

use App\Models\Instrument;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class InstrumentPolicy
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleted(User $user)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.deleted.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Instrument $instrument)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.view'))
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Instrument $instrument)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Instrument $instrument)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','instrument.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Instrument $instrument)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Instrument $instrument)
    {
        //
    }
}
