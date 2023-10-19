<?php

namespace App\Http\Controllers;

use App\Models\CakeArrangement;
use App\Http\Requests\StoreCakeArrangementRequest;
use App\Http\Requests\UpdateCakeArrangementRequest;
use App\Models\PracticeDate;
use App\Models\User;
use http\QueryString;
use Illuminate\Http\Request;

class CakeArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',[CakeArrangement::class]);
        $paginationPerPage = $request->input('p') ?? 15;

        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per page is to much"],400);
        }

        $cakeArrangements = CakeArrangement::with('user')
                ->with('practiceDate')->paginate($paginationPerPage);

        return  response()->json(['object' => $cakeArrangements]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCakeArrangementRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create',[CakeArrangement::class, $user]);

        $request->validated();

        $practiceDate = PracticeDate::withoutTrashed()->firstWhere('practice_date','=', $request['practiceDate']);
        $practiceDates = CakeArrangement::withoutTrashed()->where('practice_date_id', '=', $practiceDate['id']);

        if ($practiceDates->count() == 2)
        {
            return response()->json(['message' => "there is already 2 users for that practice dates"],400);
        }

        $cakeArrangement = new CakeArrangement();
        if (empty($practiceDate))
        {
            $newPracticeDate = new PracticeDate();
            $newPracticeDate['practiceDate'] = $request['practiceDate'];
            $newPracticeDate->save();

            $cakeArrangement->user()->associate($request['user']);
            $cakeArrangement->practiceDate()->associate($newPracticeDate['id']);
        }
        else {
            $cakeArrangement->practiceDate()->associate($practiceDate);
            $cakeArrangement->user()->associate($request['user']);
        }
        $cakeArrangement->save();

        $object = CakeArrangement::withTrashed()->firstWhere('id','=', $cakeArrangement['id']);
        $object->practiceDate;
        $object->user;

        return response()->json(['message' => "created a row in the cake arrangement successfully"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $cakeArrangement)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view',[CakeArrangement::class, $user]);

        $object = CakeArrangement::withoutTrashed()->firstWhere('id','=', $cakeArrangement);
        $object->user;
        $object->practiceDate;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCakeArrangementRequest $request, string $cakeArrangement)
    {
        $object = CakeArrangement::withTrashed()->firstWhere('id','=', $cakeArrangement);
        $this->authorize('update',[$object, User::class]);

        $request->validated();

        if ($object['practice_date_id'] != $request['practiceDate'])
        {
            $object->practiceDate()->associate($request['practiceDate']);
        }
        if ($object['user_id'] != $request['user'])
        {
            $object->user()->associate($request['user']);
        }
        $object->save();

        $object->practiceDate;
        $object->user;
        return response()->json(['message' => "user and practice date successfully modified",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cakeArrangement)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete',[CakeArrangement::class, $user]);

        $object = CakeArrangement::withTrashed()->firstWhere('id','=', $cakeArrangement);
        $object->delete();
        return response()->json(['message' => "Deleted the Cake arrangement successfully"]);
    }
}
