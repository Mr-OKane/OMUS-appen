<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Models\Permission;
use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        return TeamResource::collection(Team::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function teamUserIndex(Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.user.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $users = $team->users();
        return TeamResource::collection(Team::findOrFail($team)->with('users',$users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTeamRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

            $this->validate($request,[
               'name' => 'required|string|max:255',
            ]);

            $search = Team::where('name','=',$request['name']);
            if (!empty($search)){
                return response()->json(['message' => 'the team already exists','object' => $request],400);
            }

            $team = new Team();
            $team->name = $request['name'];
            $team->save();
            return response()->json(['Team created successfully','object' => $team],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.show'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return TeamResource::collection(Team::findOrFail($team));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $statusCode = 200;
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if ($team->name === $request['name']){
            $statusCode = 304;
        }
        else{
            $team->name = $request['name'];
        }
        if (!empty($request)){
            $this->validate($request,[
               'name' => 'required|string|max:255',
            ]);
            $team->name = $request['name'];
        }
        $team->save();
        return response()->json(["message" => 'Updated team successfully', "object" => $team],$statusCode);

    }

    /**
     * @param \App\Http\Requests\UpdateTeamRequest $request
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamUsersUpdate(UpdateTeamRequest $request, Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.user.create')) && Auth::user()->role->permissions->contains(Permission::firstWhere('name','=','team.user.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $users = $request['users'];
        $oldUsers = $team->users()->get()->toArray();

        if (!empty($request['users'])){
            foreach ($users as $user){
                $key = array_search($user->id, array_column($oldUsers, 'id'));
                if($key){
                    //Slet fra oldusers
                    unset($oldUsers[$key]);
                }
                else{
                    $team->users()->create($user);
                }
            }

            foreach ($oldUsers as $user) {
                $userModel = User::where('id',$user->id)->get();
                $team->users()->delete($userModel);
            }
            // loop oldusers og slet dem der er tilbage
        }
        $team->save();
        return response()->json(['message' => 'Added and removed users to the team','object'=> $team->users()],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Team::withTrashed()->where('id', '=', $team);
        $object->delete();
        return response()->json(['message' => 'Team successfully deleted','object'=> $team],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.forceDelete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = Team::withTrashed()->where('id','=',$team)->first();
        $object->forceDelete();
        return response()->json(['message'=> 'deleted completely','object' => $team],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Team $team)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'team.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Team::withTrashed()->where('id','=',$team)->first();
        $object->restore();
        return response()->json(['message'=>'restored','object' => $team],200);
    }
}
