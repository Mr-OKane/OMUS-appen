<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per Page is to much"],400);
        }

        $orders = Order::with('status')->with('user')
            ->with('address.zipCode.city')->with('products')
            ->paginate($paginationPerPage);

        return response()->json(['object' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $request->validated();

        $order = new Order();
        $order->address()->associate($request['address']);
        $order->status()->associate($request['status']);
        $order->user()->associate($request['user']);
        $order->products()->sync($request['products']);
        $order['order_date'] = Carbon::now();
        $order->save();

        $object = Order::withTrashed()->firstWhere('id','=', $order['id']);
        $object->address->zipCode->city;
        $object->products;
        $object->status;
        $object->user;

        return response()->json(['message' => "created the order successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order)
    {
        $object = Order::withTrashed()->firstWhere('id','=', $order);
        $object->address->zipCode->city;
        $object->products;
        $object->status;
        $object->user;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $order)
    {
        $request->validated();
        $object = Order::withTrashed()->firstWhere('id','=', $order);

        if ($object['order_date'] != $request['orderDate'])
        {
            $object['order_date'] = $request['orderDate'];
        }
        $object->address()->associate($request['address']);
        $object->status()->associate($request['status']);

        $object->save();

        return response()->json(['updated the order successfully','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $order)
    {
        $object = Order::withTrashed()->firstWhere('id','=', $order);
        $object->delete();

        return response()->json(['message' => "order deleted successfully"]);
    }
}
