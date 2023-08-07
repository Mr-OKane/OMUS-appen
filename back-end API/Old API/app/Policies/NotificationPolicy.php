<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','notification.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Notification $notification)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','notification.view'))
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','notification.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Notification $notification)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','notification.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Notification $notification)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','notification.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Notification $notification)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Notification $notification)
    {
        //
    }
}
