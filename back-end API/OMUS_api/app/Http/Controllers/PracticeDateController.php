<?php

namespace App\Http\Controllers;

use App\Models\PracticeDate;
use App\Http\Requests\StorePracticeDateRequest;
use App\Http\Requests\UpdatePracticeDateRequest;
use Illuminate\Http\Request;

class PracticeDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagnationPerPage = $request->input('p') ?? 15;
        if ($pagnationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per page is to much"],400);
        }
        $practiceDates = PracticeDate::pagination($pagnationPerPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePracticeDateRequest $request)
    {
        $request->validated();

        $practiceDate = new PracticeDate();
        $practiceDate['practice_date'] = $request['practiceDate'];
        $practiceDate->save();

        return response()->json(['message' => "created the practice date successfully",'object' => $practiceDate],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $practiceDate)
    {
        $object = PracticeDate::withTrashed()->firstWhere('id','=', $practiceDate);
        $object->users;
        $object->cakeArrengements;
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePracticeDateRequest $request, string $practiceDate)
    {
        $request->validated();
        $object = PracticeDate::withTrashed()->firstWhere('id','=', $practiceDate);

        if ($object['practice_date'] != $request['practiceDate'])
        {
            $object['practice_date'] = $request['practiceDate'];
        }
        $object->save();

        return response()->json(['message' => "updated the practice date successfully.",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $practiceDate)
    {
        $object = PracticeDate::withTrashed()->firstWhere('id','=', $practiceDate);
        $object->delete();
        return response()->json(['message' => "deleted the practice date successfully"]);
    }
}
