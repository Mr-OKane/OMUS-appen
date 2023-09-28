<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\User;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',User::class);

        $paginationPerPage = $request->input() ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ Users per page is to much"],400);
        }
        $users = User::with('address.zipcode.city')->with('role')
            ->with('status')->with('teams')->with('instruments')
            ->paginate($paginationPerPage);

        return  response()->json(['obejct' => $users]);

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
            ->with('status')->with('teams')->with('instruments')
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
                }else
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
            $user->address()->associate($request['address']);
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
        $search = User::withTrashed()->firstWhere('email', '=', $request['email']);

        if (!empty($search))
        {
            return response()->json(['message' => "the user already exist"],400);
        }

        $user = new User();
        $user['first_name'] = $request['firstname'];
        $user['last_name'] = $request['lastname'];
        $user['phone_nr'] = $request['phoneNumber'];
        $user['email'] = $request['email'];
        $user['password'] = $request['password'];
        $this->userAddress($user, $request);
        $user->role()->associate($request['role']);
        $user->status()->associate($request['status']);
        $user->save();

        $object = User::withTrashed()->firstWhere('id','=', $user['id']);
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
        $user = auth('sanctum')->user();
        $this->authorize('view', [User::class,$user]);

       $object = User::withTrashed()->firstWhere('id','=', $user);
       $object->address->zipCode->city;
       $object->role;
       $object->status;

       return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $user)
    {
        $request->validated();

        $search = User::withTrashed()->firstWhere('email', '=', $request['email']);
        $object = User::withTrashed()->firstWhere('id','=', $user);

        if (!empty($search))
        {
            return response()->json(['message' => "the user already exist"],400);
        }

        if ($object['first_name'] != $request['firstname'])
        {
            $object['first_name'] != $request['firstname'];
        }
        if ($object['last_name'] != $request['lastname'])
        {
            $object['last_name'] != $request['lastname'];
        }
        if ($object['phone_nr'] != $request['phoneNumber'])
        {
            $object['phone_nr'] = $request['phoneNumber'];
        }
        if ($object['email'] != $request['email'])
        {
            $object['email'] = $request['email'];
        }
        $object->role()->associate($request['role']);
        $object->status()->associate($request['status']);
        $this->userAddress($object, $request);
        $object->save();

        $object->address->zipCode->city;
        $object->role;
        $object->status;

        return response()->json(['message' => "Updated the user successfully.", 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [User::class,$user]);

        $object = User::withTrashed()->firstWhere('id','=', $user);
        $object->delete();
        return response()->json(['message' => "deleted the user successfully."]);
    }

    public function restore(string $user)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [User::class,$user]);

        $object = User::onlyTrashed()->firstWhere('id','=', $user);
        $object->restore();

        $object->address->zipCode->city;
        $object->role;
        $object->status;

        return response()->json(['message' => "restored the User successfully", 'object' => $object]);
    }

    public function forceDelete(string $user)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [User::class,$user]);

        $object = User::onlyTrashed()->firstWhere('id','=', $user);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the user completely"]);
    }
}
