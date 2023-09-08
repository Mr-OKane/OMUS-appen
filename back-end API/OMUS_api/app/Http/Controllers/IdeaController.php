<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagnationPerPage = $request->input('p') ?? 15;
        if ($pagnationPerPage >= 1000){
            return response()->json(['message' => ""],400);
        }
        $ideas = Idea::paginate($pagnationPerPage);

        return response()->json(['object' => $ideas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        $request->validated();

        $idea = new Idea();
        $idea['idea'] = $request['idea'];
        $idea->save();

        return response()->json(['message' => "created the Idea successfully", 'object' => $idea],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idea)
    {
        $object = Idea::withTrashed()->firstWhere('id','=', $idea);
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, string $idea)
    {
        $request->validated();

        $object = Idea::withTrashed()->firstWhere('id','=',$idea);
        if ($object['idea'] != $request['idea']){
            $object['idea'] = $request['idea'];
        }
        $object->save();

        return response()->json(['message' => "updated the idea successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idea)
    {
        $object = Idea::withTrashed()->firstWhere('id','=', $idea);
        return response()->json(['message' => "deleted the idea"]);
    }
}
