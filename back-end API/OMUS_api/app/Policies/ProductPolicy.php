<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_deleted(): Response
    {
        $user = auth('sanctum')->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.viewAny.deleted'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.create'))
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
                ->firstWhere('name','=','product.update')))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.restore'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','product.force.delete'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }
}
