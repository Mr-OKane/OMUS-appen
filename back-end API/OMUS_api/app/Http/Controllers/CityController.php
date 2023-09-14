<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagnationPerPage = $request->input('p') ?? 15;

        if ($pagnationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagnation per page"],400);
        }
        $city = City::with('zipCodes.addresses')->paginate($pagnationPerPage);

        return response()->json(['object' => $city]);
    }

    public function deleted(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ cities per page is to much"],400);
        }

        $cities = City::onlyTrashed()->with('zipCodes.addresses');

        return response()->json(['object' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $request->validated();

        $city = new City();
        $city['city'] = $request['city'];
        $city->save();

        return response()->json(['message' => "created ethe city successfully",'object' => $city],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $city)
    {
        $object = City::withTrashed()->firstWhere('id','=',$city);
        $object->zipCodes;
        $object->zipCodes->addresses;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, string $city)
    {
        $request->validated();

        $object = City::withTrashed()->firstWhere('id','=',$city);
        if ($object['city'] != $request['city'])
        {
            $object['city'] = $request['city'];
        }
        $object->save();

        return response()->json(['message' => "updated the cities name successfully", 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $city)
    {
        $object = City::withTrashed()->firstWhere('id','=', $city);
        $object->delete();
        return response()->json(['message' => "deleted the city successfully"]);
    }

    public function restore(string $city)
    {
        $object = City::onlyTrashed()->firstWhere('id','=', $city);
        $object->restore();
        $object->zipCodes->addresses;
        return response(['message' => "Restored the city successfully", 'object' => $object]);
    }

    public function forceDelete(string $city)
    {
        $object = City::onlyTrashed()->firstWhere('id','=', $city);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the city completely"]);
    }
}
