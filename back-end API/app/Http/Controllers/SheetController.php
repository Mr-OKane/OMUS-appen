<?php

namespace App\Http\Controllers;

use App\Http\Resources\SheetResource;
use App\Models\Permission;
use App\Models\Sheet;
use App\Http\Requests\StoreSheetRequest;
use App\Http\Requests\UpdateSheetRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        return SheetResource::collection(Sheet::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSheetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSheetRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Sheet $sheet)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return SheetResource::collection(Sheet::findOrFail($sheet));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Sheet $sheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSheetRequest  $request
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSheetRequest $request, Sheet $sheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Sheet $sheet)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Sheet::withTrashed()->where('id','=',$sheet);
        $object->delete();
        return response()->json('deleted '.$sheet,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Sheet $sheet)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Sheet::withTrashed()->where('id','=',$sheet);
        $object->forceDelete();
        return response()->json('completly deleted '.$sheet,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Sheet $sheet)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Sheet::withTrashed()->where('id','=',$sheet);
        $object->restore();
        return response()->json(['message'=>'restored','object'=> $sheet],200);
    }
}
