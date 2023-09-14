<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per page is to much"],400);
        }
        $statuses = Status::with('orders')->with('users')->paginate($paginationPerPage);

        return response()->json(['object' => $statuses]);
    }

    public function deleted(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ Statuses per page is to much"],400);
        }
        $statuses = Status::onlyTrashed()->with('orders')->with('users')->paginate($paginationPerPage);

        return response()->json(['message' => "deleted statuses", 'object' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        $request->validated();

        $search = Status::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($search)){
            return response()->json(['message' => "A Status with that name already exists."],400);
        }

        $status = new Status();
        $status['name'] = $request['name'];
        $status->save();

        return response()->json(['message' => "Created the status successfully",'object' => $status],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $status)
    {
        $object = Status::withTrashed()->firstWhere('id','=', $status);
        $object->users;
        $object->orders;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, string $status)
    {
        $request->validated();

        $object = Status::withTrashed()->firstWhere('id','=', $status);

        if ($object['name'] != $request['name'])
        {
            $search = Status::withTrashed()->firstWhere('id','=',$request['name']);
            if (!empty($search))
            {
                return response()->json(['message' => ""]);
            }
            $object['name'] = $request['name'];
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $status)
    {
        $object = Status::withTrashed()->firstWhere('id','=', $status);
        $object->delete();
        return response()->json(['message' => "deleted the status successfully"]);
    }

    public function restore(string $string)
    {
        $object = Product::onlyTrashed()->firstWhere('id','=', $string);
        $object->restore();
        $object->orders;
        $object->users;

        return response()->json(['message' => "restored the Status successfully", 'object' => $object],201);
    }

    public function forceDelete(string $product)
    {
        $object = Product::onlyTrashed()->firstWhere('id','=', $product);
        $object->forceDelete();
        return response()->json(['message' => "deleted the status completely"]);
    }
}
