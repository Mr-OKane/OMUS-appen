<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Instrument;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        //adds policy's to Controller
        $this->authorizeResource(User::class, 'user' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\http\Env\Request $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $userPerPagnation = 10;
        $users = User::paginate($userPerPagnation);
        return UserResource::collection(User::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function deletedUsers(\http\Env\Request $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $userPerPagnation = 10;
        $users = User::paginate($userPerPagnation);
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $this->validate($request, [
            'firstname' => "required|string|max:255",
            'lastname' => "required|string|max:255",
            'email' => "required|string|max:255",
            'password' => "required|String|min:8|max:32|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%&@$?*]).*$/|confirmed",
            'role' => "required|Integer|digits_between:1,20",
            'instrument' => "required|Integer|digits_between:1,20",
            ]);
        $user = new User();

        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->role()->associate(Role::firstwhere('name','=',$request['role'])->id);
        $user->instruments()->associate(Instrument::firstwhere('name','=',$request['instrument']));
        $user->save();

        return response()->json(['message'=>'created user successfully', 'object' =>$user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.show'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return UserResource::collection(User::findOrFail($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if (!empty($request['firstname']) && !empty($request['lastname'] || !empty($request['email']))){
            $this->validate($request, [
                'firstname' => 'Required|string|max:255',
                'lastname' => 'Required|string|max:255',
                'email' => 'Required|string|max:255',]);

            $user->firstname = $request['firstname'];
            $user->lastname = $request['lastname'];
            $user->email = $request['email'];
        }

        $user->save();
        return response()->json('updated user successfully'.$user,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdateUserRequest $request, User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if ($request['oldPassword'] != $user->password){
            return response()->json([
                'error' => 'the entered password does not macth your old'], 400);
        }
        if(!empty($request['password']) && !empty($request['repeatPassword']))
        {
            $this->validate($request, [
                'password' => 'Required|string|max:255',
                'repeatPassword' => 'Required|string|max:255'
            ]);
            $user->password = $request['password'];
        }
        $user->save();
        return response()->json(['message'=>'updated users password successfully','object'=>$user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(UpdateUserRequest $request, User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.role.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if (empty($request['role'])){
            return response()->json('need to choose a role',400);
        }
        if ($request['role'] == $user->role){
            return response()->json('User is all ready that role', 400);
        }
        $this->validate($request, [
            'role' => 'Required|Integer|digits_between:1,20'
        ]);
        $user->role = $request['role'];
        $user->save();
        return response()->json(['message'=>'role updated successfully ','object'=>$user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInstrument(UpdateUserRequest $request, User $user)
    {
        $statusCode = 200;
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if (empty($request['instruments'])){
            return response()->json('you must have at least one instrument', $statusCode = 400);
        }
        $this->validate($request,[
            'instruments' => 'required|array|max:3',
            'instrument.*' => 'required|integer|digits_between:1,20',
        ]);
        foreach ($request['instruments'] as $instrument){
            if (!(Instrument::findfirst('id','=',$instrument))){
                return response()->json(['message'=>'instrument does not exist ','object'=>$instrument],$statusCode = 404);
            }
        }
        $user->instruments() == $request['instruments'];
        $user->save();
        return response()->json(['message'=>'updated instrument(s) successfully','object'=>$user],$statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = User::withTrashed()->where('id', '=', $user)->first();
        $object->delete();
        return response()->json(['message'=>'deleted user','object' => $user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = User::withTrashed()->where('id','=',$user)->first();

        $note_files = Storage::files('notes');
        foreach($note_files as $file){
            $no_dir = str_replace("notes/", "",$file);
            $parts = explode('_',$no_dir);
            $file_name = 'app\\'.$file;
            $file_full = storage_path($file_name);
            if($parts[0] == $object->username){
                unlink($file_full);
            }
        }
        $object->forceDelete();
        return response()->json(["message"=>"completely deleted ","object" =>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'user.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $objekt = User::withTrashed()->where('id','=',$user)->first();
        $objekt->restore();
        return response()->json(["message"=>'restored the user',"object" => $user],200);
    }
}
