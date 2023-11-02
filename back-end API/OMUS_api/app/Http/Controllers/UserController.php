<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserInstrumentRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Requests\UpdateUserTeamRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\User;
use App\Models\ZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',User::class);

        $paginationPerPage = $request->input('p') ?? 15;

        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ Users per page is to much"],400);
        }

        $users = User::with('address.zipcode.city')->with('role')->with('teams')
            ->with('instruments')->paginate($paginationPerPage);

        return  response()->json(['object' => $users]);

    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted',User::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ users per page is to much"],400);
        }
        $users = User::onlyTrashed()->with('address.zipCode.city')->with('role')
            ->with('teams')->with('instruments')
            ->paginate($paginationPerPage);

        return response()->json(['message' => "All deleted users",'object' => $users]);
    }

    public function userAddress(User $user, Request $request)
    {
        $address = Address::withoutTrashed()->firstWhere('address','=', $request['address']);
        $zipCode = ZipCode::withoutTrashed()->firstWhere('zip_code','=', $request['zipCode']);
        $city = City::withoutTrashed()->firstWhere('city','=', $request['city']);

        if (empty($address))
        {
            $newAddress = new Address();
            $newAddress['address'] = $request['address'];
            if (empty($zipCode))
            {
                $newZipCode = new ZipCode();
                $newZipCode['zip_code'] = $request['zipCode'];
                if (empty($city))
                {
                    $newCity = new City();
                    $newCity['city'] = $request['city'];
                    $newCity->save();

                    $newZipCode->city()->associate($newCity['id']);
                }
                else
                {
                    $newZipCode->city()->associate($city['id']);
                }

                $newZipCode->save();

                $newAddress->zipCode()->associate($newZipCode['id']);
            }else
            {
                $newAddress->zipCode()->associate($zipCode['id']);
            }
        }else
        {
            $user->address()->associate($address);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [User::class,$user]);

        $request->validated();
        $userExists = User::withTrashed()->firstWhere('email', '=', $request['email']);

        if (!empty($userExists))
        {
            if ($userExists->trashed())
            {
                $userExists->restore();
                return response()->json(['message' => "The User already exists but was deleted and have been restored"],201);
            }
            return response()->json(['message' => "The user already exist"],400);
        }

        $newUser = new User();
        $newUser['firstname'] = $request['firstname'];
        $newUser['lastname'] = $request['lastname'];
        $newUser['phone_nr'] = $request['phoneNumber'];
        $newUser['email'] = $request['email'];
        $newUser['password'] = $request['password'];
        $newUser['status'] = $request['status'];
        $this->userAddress($newUser, $request);
        $newUser->role()->associate($request['role']);
        $newUser->instruments()->sync($request['instrument']);
        $newUser->save();

        $object = User::withTrashed()->firstWhere('id','=', $newUser['id']);
        $object->address->zipCode->city;
        $object->role;
        $object->status;

        return response()->json(['message' => "created the user successfully", 'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user)
    {
        $authUser = auth('sanctum')->user();
        $this->authorize('view', [User::class, $authUser]);

       $object = User::withTrashed()->firstWhere('id','=', $user);
       $object->address->zipCode->city;
       $object->role;

       return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $user)
    {
        $request->validated();

        $userExists = User::withTrashed()->firstWhere('email', '=', $request['email']);
        $object = User::withTrashed()->firstWhere('id','=', $user);

        $this->authorize('update',[$object, User::class]);
        if (!empty($userExists))
        {
            return response()->json(['message' => "the user already exist"],400);
        }

        if ($object['firstname'] != $request['firstname'])
        {
            $object['firstname'] != $request['firstname'];
        }
        if ($object['lastname'] != $request['lastname'])
        {
            $object['lastname'] != $request['lastname'];
        }
        if ($object['phone_nr'] != $request['phoneNumber'])
        {
            $object['phone_nr'] = $request['phoneNumber'];
        }
        if ($object['email'] != $request['email'])
        {
            $object['email'] = $request['email'];
        }
        if ($object['status'] != $request['status'])
        {
            $object['status'] = $request['status'];
        }

        $this->userAddress($object, $request);
        $object->save();

        $object->address->zipCode->city;
        $object->role;
        $object->status;

        return response()->json(['message' => "Updated the user successfully.", 'object' => $object]);
    }

    public function userInstrumentUpdate(UpdateUserInstrumentRequest $request, string $user)
    {
        $object = User::withTrashed()->firstWhere('id','=', $user);

        $this->authorize('instrument_update',[$object,User::class]);
        $request->validated();

        $object->instruments()->sync($request['instrument']);

        $object->save();
        $object->instruments;
        return response()->json(['message' => "updated user instruments successfully",$object]);
    }

    public function userPasswordUpdate(UpdateUserPasswordRequest $request, string $user)
    {
        $object = User::withTrashed()->firstWhere('id','=',$user);
        $this->authorize('password_update',[$object,User::class]);

        $request->validated();

        if ($request['password'] == $object['password'])
        {
            return response()->json(['message' => "The new password can't be the same as the old"],400);
        }

        if ($request['password'] != $request['repeatPassword'])
        {
            return response()->json(['message' => "The password does not match"],400);
        }
        else
        {
            $object['password'] = $request['password'];
            $object->save();
        }

        return response()->json(['message' => "changed the password successfully" ,'object' => $object]);

    }

    public function userRoleUpdate(UpdateUserRoleRequest $request,string $user)
    {
        $object = User::withTrashed()->firstWhere('id', '=', $user);
        $this->authorize('role_update',[$object,User::class]);

        $request->validated();

        $object->role()->associate($request['role']);

        $object->save();

        return response()->json(['message' => "Updated the user role successfully", 'object' => $object]);
    }

    public function userTeamUpdate(UpdateUserTeamRequest $request, string $user)
    {

        $object = User::withTrashed()->firstWhere('id','=', $user);
        $this->authorize('team_update',[$object,User::class]);

        $request->validated();

        $object->teams()->sync($request['team']);
        $object->save();

        $object->teams;

        return response()->json(['message' => "Updated the user with teams successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $authUser = auth('sanctum')->user();
        $this->authorize('delete', [User::class,$authUser]);

        $object = User::withTrashed()->firstWhere('id','=', $user);
        $object->delete();
        return response()->json(['message' => "deleted the user successfully."]);
    }

    public function restore(string $user)
    {
        $authUser = auth('sanctum')->user();
        $this->authorize('restore', [User::class,$authUser]);

        $object = User::onlyTrashed()->firstWhere('id','=', $user);
        $object->restore();

        $object->address->zipCode->city;
        $object->role;
        $object->status;

        return response()->json(['message' => "restored the User successfully", 'object' => $object]);
    }

    public function forceDelete(string $user)
    {
        $authUser = auth('sanctum')->user();
        $this->authorize('forceDelete', [User::class,$authUser]);

        $object = User::onlyTrashed()->firstWhere('id','=', $user);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the user completely"]);
    }
}
