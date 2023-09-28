<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_deleted(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.viewAny.deleted'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.create'))
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
                ->firstWhere('name','=','user.update')))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function instrument_update(User $user): Response
    {
        $authUser = auth('sanctum')->user();
        return ($authUser['id'] === $user['id'] || $authUser->role->permissions->contains(Permission::withTrashed()
                ->firstWhere('name','=','user.instrument.update')))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function password_update(User $user): Response
    {
        $authUser = auth('sanctum')->user();
        return ($authUser['id'] === $user['id'] || $authUser->role->permissions->contains(Permission::withTrashed()
                ->firstWhere('name','=','user.password.update')))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function role_update(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()
                ->firstWhere('name','=','user.role.update'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.restore'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','user.force.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }
}
