<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_deleted(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.viewAny.deleted'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.create'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        $authUser = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.update'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.restore'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','order.force.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }
}
