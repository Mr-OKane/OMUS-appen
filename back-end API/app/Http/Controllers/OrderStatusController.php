<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderStatusResource;
use App\Models\OrderStatus;
use App\Http\Requests\StoreorderStatusRequest;
use App\Http\Requests\UpdateorderStatusRequest;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'orderstatus.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return OrderStatusResource::collection(OrderStatus::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreorderStatusRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreorderStatusRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'orderstaus.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $orderstatus = new OrderStatus();
        $this->validate($request,[
            'type' => 'required|string|max:100',
        ]);
        $orderstatus->type = $request['type'];
        $orderstatus->save();

        return response()->json(['message' => 'created the order status','object' => $orderstatus],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(OrderStatus $orderStatus)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'orderstatus.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return OrderStatusResource::collection(OrderStatus::findOrFail($orderStatus));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateorderStatusRequest  $request
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateorderStatusRequest $request, OrderStatus $orderStatus)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'orderstatus.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = OrderStatus::withTrashed()->where('id','=', $orderStatus)->first();

        $this->validate($request,[
            'type' => 'required|string|max:100',
        ]);

        if ($object->type != $request->type){
            $object->type = $request->type;
        }
        $object->save();

        return response()->json(['message' => 'updated the order status','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(OrderStatus $orderStatus)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'orderstatus.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = OrderStatus::withTrashed()->where('id','=',$orderStatus)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the order status', 'object' => $object]);
    }
}
