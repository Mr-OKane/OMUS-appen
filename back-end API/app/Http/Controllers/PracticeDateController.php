<?php

namespace App\Http\Controllers;

use App\Http\Resources\PracticeDateResource;
use App\Models\ChatRoom;
use App\Models\Permission;
use App\Models\PracticeDate;
use App\Http\Requests\StorePractisceDateRequest;
use App\Http\Requests\UpdatePractisceDateRequest;
use App\Models\Team;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PracticeDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return PracticeDateResource::collection(PracticeDate::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePractisceDateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePractisceDateRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $this->validate($request,[
            'practice' => 'required|date',
            'room' => 'required|Integer|digits_between:1,20',
        ]);

        $practiceDate = new PracticeDate();
        if (!empty($request)){
            $practiceDate->practice = $request->practice;
            $practiceDate->room()->associate(PracticeDate::firstWhere('id','=',$request['room']->id));
        }
        $practiceDate->save();
        return response()->json(['message' => 'create the practice date','object' => $practiceDate],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(PracticeDate $practisceDate)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return PracticeDateResource::collection(PracticeDate::findOrFail($practisceDate));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePractisceDateRequest  $request
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePractisceDateRequest $request, PracticeDate $practisceDate)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = PracticeDate::withTrashed()->where('id','=',$practisceDate)->first();
        if (!empty($request)) {
            $this->validate($request, [
                'practice' => 'required|date',
                'team' => 'required|integer|digits_between:1,20',
            ]);
        }

        if ($object->practice != $request->practice){
            $object->practice = $request->practice;
        }
        if ($object->roomID != $object->roomID){
            $object->roomID = $request->roomID;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PracticeDate $practisceDate)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $practisceDate->delete();
        return response()->json(['message' => 'deleted the practicedate','object' => $practisceDate],200);
    }

}
