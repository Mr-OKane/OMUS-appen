<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\User;
use App\Models\ZipCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Order::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per Page is to much"],400);
        }

        $orders = Order::with('user')->with('address.zipCode.city')
            ->paginate($paginationPerPage);

        return response()->json(['object' => $orders]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted',Order::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ orders per page is to much"],400);
        }

        $orders = Order::onlyTrashed()->with('user')
            ->with('address.zipCode.city')->paginate($paginationPerPage);

        return response()->json(['object' => $orders]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [Order::class,$user]);

        $request->validated();
        $address = Address::withoutTrashed()->firstWhere('address','=' ,$request["address"]);
        $zipCode = ZipCode::withoutTrashed()->firstWhere('zipCode','=', $request['zipCode']);
        $city = City::withoutTrashed()->firstWhere('city','=', $request['city']);

        $order = new Order();
        if (empty($address))
        {
            $newAddress = new Address();
            $newAddress['address'] = $request['address'];
            if (empty($zipCode))
            {
                $newZipCode = new ZipCode();
                $newZipCode['zip_code'] = $request['zipCode'];
                if (empty($city))
                {
                    $newCity = new City();
                    $newCity['city'] = $request['city'];
                    $newCity->save();

                    $newZipCode->city()->associate($newCity['id']);
                }
                else
                {
                    $newZipCode->city()->associate($city['id']);
                }

                $newZipCode->save();

                $newAddress->zipCode()->associate($newZipCode['id']);
            }else
            {
                $newAddress->zipCode()->associate($zipCode['id']);
            }
        }else
        {
            $order->address()->associate($address);
        }
        $order['status'] = $request['status'];
        $order->user()->associate($request['user']);
        $order['order_date'] = Carbon::now();
        $order->save();

        $order->products()->sync($request['products']);

        $object = Order::withTrashed()->firstWhere('id','=', $order['id']);
        $object->address->zipCode->city;
        $object->products;
        $object->user->role;

        return response()->json(['message' => "created the order successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view', [Order::class,$user]);

        $object = Order::withTrashed()->firstWhere('id','=', $order);
        $object->address->zipCode->city;
        $object->products;
        $object->user->role;
        $object->user->address->zipCode->city;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $order)
    {
        $object = Order::withTrashed()->firstWhere('id','=', $order);

        $this->authorize('update', [$object, User::class]);

        $request->validated();

        if ($object['status'] != $request['status'])
        {
            $object['status'] = $request['status'];
        }

        $object->save();

        return response()->json(['updated the order successfully','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $order)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Order::class,$user]);

        $object = Order::withTrashed()->firstWhere('id','=', $order);
        $object->delete();

        return response()->json(['message' => "order deleted successfully"]);
    }

    public function restore(string $order)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [Order::class,$user]);

        $object = Order::onlyTrashed()->firstWhere('id','=', $order);
        $object->restore();
        $object->zipCodes->addresses;

        return response()->json(['message' => "restored the order", 'object' => $object],201);
    }

    public function forceDelete(string $order)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [Order::class,$user]);

        $object = Order::onlyTrashed()->firstWhere('id','=', $order);
        $object->forceDelete();

        return response()->json(['message' => "deleted the order completely"]);
    }
}
