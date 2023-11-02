<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',City::class);

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
        $this->authorize('viewAny_deleted',City::class);

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
        $user = auth('sanctum')->user();
        $this->authorize('create', [City::class,$user]);

        $request->validated();

        $cityExists = City::withTrashed()->firstWhere('city', '=', $request['city']);
        if (!empty($cityExists))
        {
            if($cityExists->trashed())
            {
                $cityExists->restore();
               return response()->json(['message' => "The city already exists but was deleted and has now been restored"],201);
            }
            return response()->json(['message' => "The city already exists"],400);
        }

        $city = new City();
        $city['city'] = $request['city'];
        $city->save();

        return response()->json(['message' => "created the city successfully",'object' => $city],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $city)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view', [City::class,$user]);

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

        $object = City::withTrashed()->firstWhere('id','=',$city);

        $this->authorize('update', [$object,User::class]);

        $request->validated();

        $cityExists = City::withTrashed()->firstWhere('city', '=', $request['city']);

        if (!empty($cityExists) && $object['id'] != $cityExists['id'])
        {
            return response()->json(['message' => "Can't change a city name to one that exists"],400);
        }
        else
        {
            if ($object['city'] != $request['city'])
            {
                $object['city'] = $request['city'];
            }
            $object->save();
        }

        return response()->json(['message' => "updated the cities name successfully", 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $city)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [City::class, $user]);

        $object = City::withTrashed()->firstWhere('id','=', $city);
        $object->delete();
        return response()->json(['message' => "deleted the city successfully"]);
    }

    public function restore(string $city)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [City::class,$user]);

        $object = City::onlyTrashed()->firstWhere('id','=', $city);
        $object->restore();

        return response(['message' => "Restored the city successfully", 'object' => $object]);
    }

    public function forceDelete(string $city)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete',[City::class,$user]);

        $object = City::onlyTrashed()->firstWhere('id','=', $city);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the city completely"]);
    }
}
