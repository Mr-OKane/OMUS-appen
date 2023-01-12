<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdeaResource;
use App\Http\Resources\InstrumentResource;
use App\Models\Idea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Instrument;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Idea.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return InstrumentResource::collection(Instrument::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIdeaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreIdeaRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Idea.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $idea = new Idea();
        $this->validate($request,[
            'idea' => 'required|string|max:255',
        ]);
        $idea->idea = $request->idea;
        $idea->save();
        return response()->json(['message' => 'Created the idea', 'object' => $idea],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Idea $idea)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Idea.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return IdeaResource::collection(Idea::findOrFail($idea));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIdeaRequest  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Idea.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Idea::withTrashed()->where('id', '=', $idea)->first();
        $this->validate($request,[
            'idea' => 'required|string|max:255',
        ]);

        if ($object->idea != $request->idea){
            $object->idea = $request->idea;
        }
        $object->save();
        return response()->json(['message' => 'Updated the idea', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Idea $idea)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Idea.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Idea::withTrashed()->where('id','=', $idea)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the idea', 'object' => $object]);
    }
}
