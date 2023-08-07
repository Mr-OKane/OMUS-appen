<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Http\Requests\StoreaddressRequest;
use App\Http\Requests\UpdateaddressRequest;
use App\Models\Permission;
use App\Models\PostalCode;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'address.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return AddressResource::collection(Address::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreaddressRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreaddressRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'address.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $address = new Address();
        $this->validate($request,[
            'line1' => 'required|string|max:255',
            'line2' => 'required|string|max:255',
            'postalcode' => 'required|integer|digits_between:1,20',
        ]);
        $address->line1 = $request->line1;
        $address->line2 = $request->line2;
        $address->postalCode()->associate(PostalCode::firstWhere('id', '=', $request['postalcode'])->id);
        $address->save();

        return response()->json(['message' => 'created the address', 'object' => $address],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Address $address)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'address.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return AddressResource::collection(Address::findOrFail($address));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateaddressRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateaddressRequest $request, Address $address)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'address.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Address::withTrashed()->where('id', '=', $address)->first();
        $this->validate($request,[
            'line1' => 'required|string|max:255',
            'line2' => 'required|string|max:255',
            'postalcodeID' => 'required|integer|digits_between:1,20',
        ]);

        if ($object->line1 != $request->line1){
            $object->line1 = $request->line2;
        }
        if ($object->line2 != $request->line2){
            $object->line2 = $request->line2;
        }
        if ($object->postalcodeID = $request->postalcodeID){
            $object->postalcodeID = $request->postalcodeID;
        }
        $object->save();
        return response()->json(['message' => 'updated the address', 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'address.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Address::withTrashed()->where('id', '=',$address)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the address', 'object' => $object]);
    }
}
