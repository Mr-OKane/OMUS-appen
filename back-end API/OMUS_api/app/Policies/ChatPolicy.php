<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view any deleted models.
     */
    public function viewAny_deleted(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.viewAny.deleted'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.create'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        $authUser = auth('sanctum')->user();
        return ($authUser['id'] === $user['id'] || $authUser->role->permissions->contains(Permission::withTrashed()
                ->firstWhere('name','=','chat.update')))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.restore'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','chat.force.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }
}
