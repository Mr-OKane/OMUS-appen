<?php

namespace App\Http\Controllers;

use App\Models\PracticeDate;
use App\Http\Requests\StorePractisceDateRequest;
use App\Http\Requests\UpdatePractisceDateRequest;

class PracticeDateController extends Controller
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
     * @param  \App\Http\Requests\StorePractisceDateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePractisceDateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Response
     */
    public function show(PracticeDate $practisceDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Response
     */
    public function edit(PracticeDate $practisceDate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePractisceDateRequest  $request
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePractisceDateRequest $request, PracticeDate $practisceDate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PracticeDate  $practisceDate
     * @return \Illuminate\Http\Response
     */
    public function destroy(PracticeDate $practisceDate)
    {
        //
    }
}
