<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IdeaPolicy
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','idea.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Idea $idea)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','idea.view'))
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','idea.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Idea $idea)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','idea.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Idea $idea)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','idea.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Idea $idea)
    {
        //
    }
}
