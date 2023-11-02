<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTeamUserRequest;
use App\Models\Permission;
use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\User;
use App\Policies\TeamPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\text;


class TeamController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Team::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ is to much pagination"],400);
        }

        $teams = Team::with('users')->paginate($paginationPerPage);

        return response()->json(['object' => $teams]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted', Team::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ teams per page is to much"],400);
        }

        $teams = Team::onlyTrashed()->with('users')->paginate($paginationPerPage);

        return response()->json(['object' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $user = auth("sanctum")->user();
        $this->authorize('create',[Team::class,$user]);

        $request->validated();

        $teamExists = Team::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($teamExists))
        {
            if ($teamExists->trashed())
            {
                $teamExists->restore();
                return response()->json(['message' => "The team exists and have been restored"],201);
            }
            return response()->json(['message' => "the team name already exists"],400);
        }

        $team = new Team();
        $team['name'] = $request['name'];
        $team->save();

        return response()->json(['message' => "Created the team successfully", 'object' => $team],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $team)
    {
        $user = auth("sanctum")->user();
        $this->authorize('view',[Team::class,$user]);

        $object = Team::withTrashed()->firstWhere('id','=', $team);
        $object->users;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, string $team)
    {
        $object = Team::withTrashed()->firstWhere('id','=', $team);

        $this->authorize('update', [$object,User::class]);

        $request->validated();

        if ($object['name'] != $request['name'])
        {
            $teamExists = Team::withTrashed()->firstWhere('name','=', $request['name']);
            if (!empty($teamExists))
            {
                return response()->json(["Can't change the team name to one that already exists"],400);
            }
            $object['name'] =  $request['name'];
        }
        $object->save();

        return response()->json(['message' => "Updated the team successfully", 'object' => $object]);
    }

    public function teamUserUpdate(UpdateTeamUserRequest $request, string $team)
    {
        $request->validated();
        $object = Team::withTrashed()->firstWhere('id','=', $team);

        $this->authorize('team_update', [$object,User::class]);

        $object->users()->sync($request['user']);
        $object->save();

        return response()->json(['message' => "Updated the team with users successfully successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $team)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete',[Team::class, $user]);

        $object = Team::withTrashed()->firstWhere('id','=', $team);
        $object->delete();

        return response()->json(['message' => "deleted the Team successfully"]);
    }

    public function restore(string $team)
    {
        $user = auth("sanctum")->user();
        $this->authorize('restore',[Team::class,$user]);

        $object = Team::onlyTrashed()->firstWhere('id','=', $team);
        $object->restore();
        $object->users;

        return response()->json(['message' => "restored the team successfully", 'object' => $object]);
    }

    public function forceDelete(string $team)
    {
        $user = auth("sanctum")->user();
        $this->authorize('forceDelete',[Team::class,$user]);

        $object = Team::onlyTrashed()->firstWhere('id','=', $team);
        $object->forceDelete();

        return response()->json(['message' => "deleted the team completely successfully"]);
    }
}
