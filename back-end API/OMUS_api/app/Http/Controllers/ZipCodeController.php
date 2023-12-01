<?php

namespace App\Http\Controllers;

use App\Models\ZipCode;
use App\Http\Requests\StoreZipCodeRequest;
use App\Http\Requests\UpdateZipCodeRequest;
use Illuminate\Http\Request;

class ZipCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',ZipCode::class);

        $paginationPerPage = $request->input('p') ?? 50;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ per page is to much"],400);
        }
        $zipCodes = ZipCode::with('city')->paginate($paginationPerPage);

        return response()->json(['object' => $zipCodes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZipCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $zipCode)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view', [ZipCode::class,$user]);

        $object = ZipCode::withTrashed()->firstWhere('id','=', $zipCode);
        $object->addresses;
        $object->city;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZipCodeRequest $request, ZipCode $zipCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZipCode $zipCode)
    {
        //
    }
}
