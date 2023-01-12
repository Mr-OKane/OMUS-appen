<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostalCodeResource;
use App\Models\Permission;
use App\Models\PostalCode;
use App\Http\Requests\StorepostalCodeRequest;
use App\Http\Requests\UpdatepostalCodeRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class PostalCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Postalcode.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return PostalCodeResource::collection(PostalCode::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepostalCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepostalCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(PostalCode $postalCode)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'Postalcode.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return PostalCodeResource::collection(PostalCode::findOrFail($postalCode));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepostalCodeRequest  $request
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepostalCodeRequest $request, PostalCode $postalCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostalCode $postalCode)
    {
        //
    }
}
