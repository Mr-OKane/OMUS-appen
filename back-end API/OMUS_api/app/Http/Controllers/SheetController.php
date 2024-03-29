<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Http\Requests\StoreSheetRequest;
use App\Http\Requests\UpdateSheetRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Sheet::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ sheets per page at a time is to much"],400);
        }

        $sheets = Sheet::with('user')->paginate($paginationPerPage);

        return response()->json(['object' => $sheets]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted',Sheet::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ sheets per page at a time  is to much"],400);
        }

        $sheets = Sheet::onlyTrashed()->with('user')->paginate($paginationPerPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSheetRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [Sheet::class,$user]);

        $request->validated();

        $sheet = new Sheet();

        $pdf = $request->file('pdf');
        $sheet['pdf'] = base64_encode(file_get_contents($pdf));
        $sheet->user()->associate($request['user']);
        $sheet->save();

        $object = Sheet::withTrashed()->firstWhere('id','=', $sheet['id']);
        $object->user;

        return response()->json(['message' => "Created the Sheet successfully", 'object' => $object]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $sheet)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view', [Sheet::class,$user]);

        $object = Sheet::withTrashed()->firstWhere('id','=', $sheet);
        $object->user;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSheetRequest $request, string $sheet)
    {
        $object = Sheet::withTrashed()->firstWhere('id','=', $sheet);

        $this->authorize('update', [$object, User::class]);

        $request->validated();

        $pdf = base64_encode(file_get_contents($request['pdf']));
        if ($object['pdf'] != $pdf)
        {
            $object['pdf'] = $pdf;
        }
        $object->user()->associate($request['user']);
        $object->user;

        return response()->json(['message' =>'Updated the sheet successfully','object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $sheet)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Sheet::class,$user]);

        $object = Sheet::withTrashed()->firstWhere('id', '=', $sheet);
        $object->delete();

        return response()->json(['message' => "deleted the sheet."]);
    }

    public function restore(string $sheet)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [Sheet::class,$user]);

        $object = Sheet::onlyTrashed()->firstWhere('id','=', $sheet);
        $object->restore();
        $object->user;

        return response()->json(['message' => "Restored the sheet",'object' => $object]);
    }

    public function forceDelete(string $sheet)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [Sheet::class,$user]);

        $object = Sheet::onlyTrashed()->firstWhere('id','=', $sheet);
        $object->forceDelete();

        return response()->json(['message' => "deleted the sheet completely"]);
    }
}
