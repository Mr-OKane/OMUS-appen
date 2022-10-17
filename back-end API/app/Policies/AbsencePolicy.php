<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','absence.index'))
        ? Response::allow()
        : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Absence $absence)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','absence.show'))
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','absence.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Absence $absence)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','absence.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Absence $absence)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','absence.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Absence $absence)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Absence $absence)
    {
        //
    }
}
