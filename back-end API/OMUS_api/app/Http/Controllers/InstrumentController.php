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
        $this->authorize('viewAny',Instrument::class);

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
        $this->authorize('viewAny_deleted',Instrument::class);

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
        $user = auth('sanctum')->user();
        $this->authorize('create', [Instrument::class,$user]);

        $request->validated();

        $instrumentExists = Instrument::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($instrumentExists))
        {
            if ($instrumentExists->trashed())
            {
                $instrumentExists->restore();
                return response()->json(['message' => "The instrument exists but was deleted and now it has been restored"],201);
            }
            return response()->json(['message' => "The instrument already exists"],400);
        }

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
        $user = auth('sanctum')->user();
        $this->authorize('view', [Instrument::class,$user]);

        $object = Instrument::withTrashed()->firstWhere('id','=', $instrument);
        $object->users;
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstrumentRequest $request, string $instrument)
    {
        $object = Instrument::withTrashed()->firstWhere('id','=',$instrument);

        $this->authorize('update',[$object,Instrument::class]);

        $request->validated();

        $instrumentExists = Instrument::withTrashed()->firstWhere('name','=',$request['name']);
        if (!empty($instrumentExists) && $instrumentExists['id'] != $object['id']){
            return response()->json(['message' => "The instrument already exists"],400);
        }
        else{
            if ($object['name'] != $request['name']){
                $object['name'] = $request['name'];
            }

            $object->save();
        }

        return response()->json(['message' => "updated the instrument successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $instrument)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Instrument::class,$user]);

        $object = Instrument::withTrashed()->firstWhere('id','=', $instrument);
        $object->delete();
        return response()->json(['message' => "deleted the instrument successfully"]);
    }

    public function restore(string $instrument)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [Instrument::class,$user]);

        $object = Instrument::onlyTrashed()->firstWhere('id','=', $instrument);
        $object->restore();

        $object->users;
        response()->json(['message' => "Restored the Instrument success",'object'  => $object]);
    }

    public function forceDelete(string $instrument)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [Instrument::class,$user]);

        $object = Instrument::onlyTrashed()->firstWhere('id','=', $instrument);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the Instrument completely"]);
    }
}
