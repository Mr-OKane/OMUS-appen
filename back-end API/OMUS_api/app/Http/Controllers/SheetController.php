<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Http\Requests\StoreSheetRequest;
use App\Http\Requests\UpdateSheetRequest;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination is to much"],400);
        }

        $sheets = Sheet::with('user')->paginate($paginationPerPage);

        return response()->json(['object' => $sheets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSheetRequest $request)
    {
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
        $object = Sheet::withTrashed()->firstWhere('id','=', $sheet);
        $object->user;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSheetRequest $request, string $sheet)
    {
        $request->validated();

        $object = Sheet::withTrashed()->firstWhere('id','=', $sheet);

        if ($object['pdf'] != base64_encode(file_get_contents($request['pdf'])))
        {
            $object['pdf'] = base64_encode(file_get_contents($request['pdf']));
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
        $object = Sheet::withTrashed()->firstWhere('id', '=', $sheet);
        $object->delete();

        return response()->json(['message' => "deleted the sheet."]);
    }
}
