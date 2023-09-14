<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ instruments per page is to much"],400);
        }
        $instruments = Instrument::with('users')->paginate($paginationPerPage);

        return response()->json(['object' => $instruments]);
    }

    public function deleted(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ instruments per page is to much"],400);
        }
        $instruments = Instrument::onlyTrashed()->with('users')->paginate($paginationPerPage);

        return response()->json(['object' => $instruments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstrumentRequest $request)
    {
        $request->validated();

        $instrument = new Instrument();
        $instrument['name'] = $request['name'];
        $instrument->save();

        return response()->json(['message' => "Created the instrument",'object' => $instrument],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $instrument)
    {
        $object = Instrument::withTrashed()->firstWhere('id','=', $instrument);
        $object->users;
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstrumentRequest $request, string $instrument)
    {
        $request->validated();

        $object = Instrument::withTrashed()->firstWhere('id','=',$instrument);
        if ($object['name'] != $request['name']){
            $object['name'] = $request['name'];
        }
        $object->save();

        return response()->json(['message' => "updated the instrument successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $instrument)
    {
        $object = Instrument::withTrashed()->firstWhere('id','=', $instrument);
        $object->delete();
        return response()->json(['message' => "deleted the instrument successfully"]);
    }

    public function restore(string $instrument)
    {
        $object = Instrument::onlyTrashed()->firstWhere('id','=', $instrument);
        $object->restore();

        $object->users;
        response()->json(['message' => "Restored the Instrument success",'object'  => $object]);
    }

    public function forceDelete(string $instrument)
    {
        $object = Instrument::onlyTrashed()->firstWhere('id','=', $instrument);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the Instrument completely"]);
    }
}
