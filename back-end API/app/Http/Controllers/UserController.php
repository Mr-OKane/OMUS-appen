<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        //adds policy's to Controller
        $this->authorizeResource(User::class, 'user' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function index(\http\Env\Request $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $userPerPagnation = 10;
        $users = User::paginate($userPerPagnation);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function create()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return  'user.create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAbsenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbsenceRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.show'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsenceRequest  $request
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbsenceRequest $request, Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.force.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function restore(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
    }

}
