<?php

namespace App\Http\Controllers;

use App\Models\CakeArrangement;
use App\Http\Requests\StoreCakeArrangementRequest;
use App\Http\Requests\UpdateCakeArrangementRequest;
use App\Models\User;
use http\QueryString;

class CakeArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',[CakeArrangement::class]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCakeArrangementRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create',[CakeArrangement::class, $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $CakeArrangement)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view',[CakeArrangement::class, $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCakeArrangementRequest $request, string $CakeArrangement)
    {
        $object = CakeArrangement::withTrashed()->firstWhere('id','=', $CakeArrangement);
        $this->authorize('update',[$object, User::class]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $CakeArrangement)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete',[CakeArrangement::class, $user]);
    }
}
