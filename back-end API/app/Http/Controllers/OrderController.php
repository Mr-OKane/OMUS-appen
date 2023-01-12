<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Order;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Models\OrderStatus;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return OrderResource::collection(Order::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedOrders()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedorders = Order::onlyTrashed();
        return response()->json($deletedorders,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreorderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreorderRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $order = new Order();
        $this->validate($request,[
            'date' => 'required|date',
            'userID' => 'required|integer|digits_between:1,20',
            'addressID' => 'required|integer|digits_between:1,20',
            'statusID' => 'required|integer|digits_between:1,20',
        ]);
        $order->date = $request->date;
        $order->user()->associate(User::firstWhere('id', '=', $request->userID));
        $order->address()->associate(Address::firstWhere('id', '=', $request->addresID));
        $order->orderStatus()->associate(OrderStatus::firstWhere('id', '=', $request->statusID));
        $order->save();

        return  response()->json(['message' => 'created the order', 'object' => $order],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Order $order)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return OrderResource::collection(Order::findOrFail($order));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateorderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateorderRequest $request, Order $order)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Order::withTrashed()->where('id','=',$order)->first();

        $this->validate($request,[
            'date' => 'required|date',
            'user' => 'required|integer|digits_between:1,20',
            'address' => 'required|integer|digits_between:1,20',
            'orderstatus' => 'required|integer|digits_between:1,20',
        ]);

        if ($object->date != $request->date){
            $object->date = $request->date;
        }
        if ($object->user != $request->user){
            $object->user()->associate($request['userID']);
        }
        if ($object->address != $request->address){
            $object->address()->associate($request['addressID']);
        }
        if ($object->orderstatus != $request->orderstatus){
            $object->orderstatus()->associate($request['orderstatusID']);
        }
        $object->save();

        return response()->json(['message' => 'updated the order','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Order::withTrashed()->where('id','=',$order)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the order','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Order $order)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Order::withTrashed()->where('id','=',$order)->first();
        $object->forceDelete();
        return response()->json(['message' => 'deleted the order completly', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Order $order)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'order.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Order::withTrashed()->where('id','=',$order)->first();
        $object->restore();
        return response()->json(['message' => 'restored the order','object' => $object],200);
    }
}
