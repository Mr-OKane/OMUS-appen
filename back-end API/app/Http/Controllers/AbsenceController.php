<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\Models\Permission;
use App\Models\Role;
use http\Env\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function __construct()
    {
        //adds policy's to Controller
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $absencePerPagnation = 10;
        $absences = Absence::paginate($absencePerPagnation);
        return view('absence.index')->with('absences', $absences);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return view('absence.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAbsenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbsenceRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.create'))
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(Absence $absence)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        //
    }
}
