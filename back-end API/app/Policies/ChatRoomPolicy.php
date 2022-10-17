<?php

namespace App\Policies;

use App\Models\ChatRoom;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ChatRoomPolicy
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ChatRoom $chatRoom)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.view'))
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
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ChatRoom $chatRoom)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ChatRoom $chatRoom)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ChatRoom $chatRoom)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ChatRoom $chatRoom)
    {
        return $user->role->permissions->contains(Permission::firstWhere('name','=','chatroom.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }
}
