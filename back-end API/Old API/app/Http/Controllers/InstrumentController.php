<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrumentResource;
use App\Models\Instrument;
use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use App\Models\Permission;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return InstrumentResource::collection(Instrument::all());
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedInstruments()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedInstruments = Instrument::onlyTrashed();
        return response()->json($deletedInstruments,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstrumentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreInstrumentRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $instrument = new Instrument();
        $this->validate($request,[
            'name' => 'required|string|max:255',
        ]);

        $instrument->name = $request->name;
        $instrument->save();

        return response()->json(['message' => 'created the instrument', 'object' => $instrument],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Instrument $instrument)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return InstrumentResource::collection(Instrument::findOrFail($instrument));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstrumentRequest  $request
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateInstrumentRequest $request, Instrument $instrument)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = Instrument::withTrashed()->where('id','=',$instrument)->first();
        $this->validate($request,[
            'name' => 'required|string|max:255',
        ]);

        if ($object->name != $request->name){
            $object->name = $request->name;
        }
        $object->save();
        return response()->json(['message' => 'Instrument updated','object' => $object],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Instrument $instrument)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Instrument::withTrashed()->where('id', '=', $instrument)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the instrument', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Instrument $instrument)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Instrument::withTrashed()->where('id','=',$instrument)->first();
        $object->forceDelete();
        return response()->json(['message' => 'deleted the instrument completely','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Instrument $instrument)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'instrument.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = Instrument::withTrashed()->where('id','=',$instrument)->first();
        $object->restore();
        return response()->json(['message' => 'restored the instrument', 'object' => $object]);

    }
}
