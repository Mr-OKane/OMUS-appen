<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\Request;


class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        $request->validated();

        $search = Team::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($search))
        {
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
        $object = Team::withTrashed()->firstWhere('id','=', $team);
        $object->users;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, string $team)
    {
        $request->validated();
        $object = Team::withTrashed()->firstWhere('id','=', $team);

        if ($object['name'] != $request['name'])
        {
            $search = Team::withTrashed()->firstWhere('name','=', $request['name']);
            if (!empty($search))
            {
                return response()->json(['there is a team with that name'],400);
            }
            $object['name'] =  $request['name'];
        }
        $object->save();

        return response()->json(['message' => "Updated the team successfully", 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $team)
    {
        $object = Team::withTrashed()->firstWhere('id','=', $team);
        $object->delete();

        return response()->json(['message' => "deleted the Team successfully"]);
    }

    public function restore(string $team)
    {
        $object = Team::onlyTrashed()->firstWhere('id','=', $team);
        $object->restore();
        $object->users;

        return response()->json(['message' => "restored the team successfully", 'object' => $object]);
    }

    public function forceDelete(string $team)
    {
        $object = Team::onlyTrashed()->firstWhere('id','=', $team);
        $object->forceDelete();

        return response()->json(['message' => "deleted the team completely successfully"]);
    }
}
