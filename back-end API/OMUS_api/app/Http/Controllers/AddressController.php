<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\City;
use App\Models\User;
use App\Models\ZipCode;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Address::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000){
            return response()->json(['message' => "to high of pagination"],400);
        }
        $address = Address::with('zipCode.city')->paginate($paginationPerPage);

        return response()->json(['object' => $address]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted',Address::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ addresses per page is to much"],400);
        }

        $addresses = Address::onlyTrashed()->with('zipCode.city')
            ->paginate($paginationPerPage);

        return response()->json(['object' => $addresses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create',[Address::class, $user]);

        $request->validated();

        $zipcode = ZipCode::withTrashed()->firstWhere('zip_code','=', $request['zipCode']);
        $addressExists = Address::withTrashed()->Where('address','=', $request['address'])->where('zip_code_id','=',$zipcode['id'])->first();

        if (!empty($addressExists))
        {
            if ($addressExists->trashed())
            {
                $addressExists->restore();
                return response()->json(['message' => "The address already exists but was deleted and has been restored"],201);
            }
            return response()->json(['message' => "The address already exists"],400);
        }

        if (empty($zipcode))
        {
            return response()->json(['message' => "The zip code entered does not exist"], 404);
        }

        $address = new Address();
        $address['address'] = $request["address"];
        $address->zipCode()->associate($zipcode['id']);
        $address->save();

        $object = Address::withTrashed()->where('id', '=', $address['id'])->first();
        $object->zipCode;
        $object->zipCode->city;

        return response()->json(['message' => "Created the address successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $address)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view',[Address::class, $user]);

        $object = Address::withTrashed()->where('id', '=', $address)->first();
        $object->zipCode;
        $object->zipCode->city;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $address)
    {
        $request->validated();

        $object = Address::withTrashed()->where('id', '=', $address)->first();
        $zipCode = ZipCode::withTrashed()->firstWhere('zip_code', '=', $request['zipCode']);
        $this->authorize('update',[$object, User::class]);

        $addressExists = Address::withTrashed()->firstWhere('address','=', $request['address']);

        if (empty($zipCode))
        {
            return response()->json(['message' => "The zip Code does not exist"],404);
        }

        if (!empty($addressExists) && $object['id'] != $addressExists['id'])
        {
           return response()->json(['message' => "Can't change the address to one that already exists"],400);
        }
        else
        {
            if ($object['address'] != $request['address'])
            {
                $object['address'] = $request['address'];
            }
            $object->zipCode()->associate($request['zipCode']);
            $object->save();
        }

        return response()->json(['message' => "Updated the address",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $address)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete',[Address::class, $user]);

        $object = Address::withTrashed()->firstWhere('id','=', $address);
        $object->delete();
        return response()->json(['message' => "Deleted the address"]);
    }

    public function restore(string $address)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore',[Address::class, $user]);

        $object = Address::onlyTrashed()->firstWhere('id','=', $address);
        $object->restore();
        $object->zipCode;
        $object->zipCode->city;

        return response()->json(['message' => "Address restored successfully", 'object' => $object]);
    }

    public function forceDelete(string $address)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete',[Address::class, $user]);

        $object = Address::onlyTrashed()->firstWhere('id','=', $address);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the address completely"]);
    }
}
