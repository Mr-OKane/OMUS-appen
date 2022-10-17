<?php

namespace App\Http\Controllers;

use App\Models\PostalCode;
use App\Http\Requests\StorepostalCodeRequest;
use App\Http\Requests\UpdatepostalCodeRequest;

class PostalCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function show(PostalCode $postalCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostalCode  $postalCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PostalCode $postalCode)
    {
        //
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
