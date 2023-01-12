<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use App\Http\Requests\StoreAbsenceRequest;
use App\Http\Requests\UpdateAbsenceRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return AbsenceResource::collection(Absence::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAbsenceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAbsenceRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $absence = new Absence();
        $this->validate($request,[
            'absence' => 'required|boolean',
            'date' => 'required|date',
            'user' => 'required|integer|digits_between:1,20'
        ]);
        $absence->absence = $request->absence;
        $absence->date = $request->date;
        $absence->user()->associate(User::firstWhere('id','=',$request['user'])->id);
        $absence->save();

        return response()->json(['message' => 'created the absence', 'object' => $absence],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Absence $absence)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'absence.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Absence::withTrashed()->where('id', '=', $absence)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the absence', 'object' => $object]);
    }

}
