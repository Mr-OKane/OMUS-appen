<?php

namespace App\Http\Controllers;

use App\Http\Resources\SheetResource;
use App\Models\Permission;
use App\Models\Sheet;
use App\Http\Requests\StoreSheetRequest;
use App\Http\Requests\UpdateSheetRequest;
use Faker\Core\File;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedSheets()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.deleted.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedSheets = Sheet::onlyTrashed();
        return response()->json($deletedSheets,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSheetRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSheetRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $sheet = new Sheet();
        $this->validate($request,[
            'notes' => 'required|file'
        ]);

        $fileName = Auth::user()->id . '_' . time() . '.'. $request->notes->extension();

        $request->notes->move(public_path('pdf/upload'), $fileName);
        $sheet->notes = $fileName;
        $sheet->save();

        return response()->json(['message' => 'uploaded the pdf to ','object' => '/pdf/upload/'.$fileName],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(Sheet $sheet)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'sheet.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return response()->file(public_path('pdf/upload') . "SheetController.php/" .$sheet->notes);
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
