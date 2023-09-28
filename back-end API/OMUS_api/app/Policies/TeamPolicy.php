<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        $user = auth("sanctum")->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','team.viewAny'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    public function viewAny_Deleted()
    {
        $user = auth("sanctum")->user();
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=',"team.deleted.viewAny"))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','team.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=','team.create'))
            ? Response::allow()
            : Response::deny('You are not the chosen one',403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        $authUser = auth("sanctum")->user();
        return ($authUser['id'] === $user->id ||
            $authUser->role->permissions->contains(Permission::withTrashed()
                ->firstWhere('name', '=',"team.update")))
            ? Response::allow()
            : response()->json(["You are not the chosen one"],403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=',"team.delete"))
            ? Response::allow()
            : Response::deny("You are not the chosen one",403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->role->permissions->contains(Permission::withTrashed()
            ->firstWhere('name','=',"team.restore"))
            ? Response::allow()
            : response()->json(['You are not the chosen one'],403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->role->permissions->contains(Permission::withTrashed()->firstWhere('name','=',"team.force.delete"))
            ? Response::allow()
            : response()->json(['You are not the chosen one'],403);
    }
}
