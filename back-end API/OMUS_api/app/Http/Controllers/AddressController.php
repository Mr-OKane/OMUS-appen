<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000){
            return response()->json(['message' => "to high of pagination"],400);
        }
        $address = Address::with('zipCode.city')->paginate($paginationPerPage);

        return response()->json(['object' => $address]);
    }

    public function deleted(Request $request)
    {
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
        $request->validated();

        $address = new Address();
        $address['address'] = $request["address"];
        $address->zipCode()->associate($request['zipCode']);
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

        if ($object['address'] != $request['address'])
        {
            $object['address'] = $request['address'];
        }
        $object->zipCode()->associate($request['zipCode']);
        $object->save();

        return response()->json(['message' => "Updated the address",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $address)
    {
        $object = Address::withTrashed()->firstWhere('id','=', $address);
        $object->delete();
        return response()->json(['message' => "Deleted the address"]);
    }

    public function restore(string $address)
    {
        $object = Address::onlyTrashed()->firstWhere('id','=', $address);
        $object->restore();
        $object->zipCode;
        $object->zipCode->city;

        return response()->json(['message' => "Address restored successfully", 'object' => $object]);
    }

    public function forceDelete(string $address)
    {
        $object = Address::onlyTrashed()->firstWhere('id','=', $address);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the address completely"]);
    }
}
