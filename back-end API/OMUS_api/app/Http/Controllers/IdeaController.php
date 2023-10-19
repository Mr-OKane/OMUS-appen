<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\User;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Idea::class);

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
        $user = auth('sanctum')->user();
        $this->authorize('create', [Idea::class,$user]);

        $request->validated();

        $ideaExists = Idea::withTrashed()->firstWhere('idea','=', $request['idea']);
        if (!empty($ideaExists))
        {
            if ($ideaExists->trashed())
            {
                $ideaExists->restore();
                return response()->json(['message' => "The Idea existed already but was deleted and now it is restored."]);
            }
            return response()->json(['message' => "The idea already exists"],400);
        }

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
        $user = auth('sanctum')->user();
        $this->authorize('view', [Idea::class,$user]);

        $object = Idea::withTrashed()->firstWhere('id','=', $idea);
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, string $idea)
    {
        $object = Idea::withTrashed()->firstWhere('id','=',$idea);

        $this->authorize('update', [$object,User::class]);

        $request->validated();

        $ideaExists = Idea::withTrashed()->firstWhere('idea','=', $request['idea']);
        if (!empty($ideaExists) && $ideaExists['id'] != $object['id'])
        {
            return response()->json(['message' => "can't change the idea to one that exists"],400);
        }else
        {
            if ($object['idea'] != $request['idea']){
                $object['idea'] = $request['idea'];
            }
            $object->save();
        }

        return response()->json(['message' => "updated the idea successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idea)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete',[Idea::class, $user]);

        $object = Idea::withTrashed()->firstWhere('id','=', $idea);
        $object->delete();
        return response()->json(['message' => "deleted the idea successfully"]);
    }
}
