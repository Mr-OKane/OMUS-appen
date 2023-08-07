<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Permission;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth('sacturm')->user->role->permissions->contains(Permission::firstWhere('name', '=', 'product.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return ProductResource::collection(Product::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedProducts()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.deleted.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedProducts = Product::onlyTrashed();
        return response()->json($deletedProducts,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if (!empty($request)){
            $this->validate($request,[
                'name' => 'required|string|max:150',
                'description' => 'string|max:255',
                'image' => 'required|string|max:150',
                'price' => 'required|double|max:11'
            ]);

            $product = new Product();

            $product->name = $request['name'];
            $product->description =  $request['descripiton'];
            $product->image = $request['image'];
            $product->price = $request['price'];
        }
        $product->save();
        return response()->json(['message' => 'created the product successfully','object' => $product],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Product $product)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return ProductResource::collection(Product::findOrFail($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Product::withTrashed()->where('id','=',$product->id)->first();

        if (!empty($request)){
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'description' => 'string|max:255',
                'image' => 'required|string|max:150',
                'price' => 'required|double|max:11',
            ]);
        }

        if ($object->name != $request->name){
            $object->name = $request->name;
        }
        if ($object->description != $request->description){
            $object->description = $request->description;
        }
        if ($object->image != $request->image){
            $object->image = $request->image;
        }
        if ($object->price != $request->price){
            $object->price = $request->price;
        }
        $object->save();
        return response()->json(['message' => 'updated the product','object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Product::withTrashed()->where('id','=',$product);
        $object->delete();
        return response()->json(['message' => 'deleted the product', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Product $product)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Product::withTrashed()->where('id','=',$product);
        $object->forceDelete();
        return response()->json(['message' => 'deleted the product completely'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Product $product)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'product.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Product::withTrashed()->where('id','=',$product);
        $object->restore();
        return response()->json(['message' => 'restored the product', 'object' => $object],200);

    }
}
