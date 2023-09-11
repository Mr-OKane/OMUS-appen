<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000 per page is to much"],400);
        }

        $products = Product::paginate($paginationPerPage);

        return response()->json(['object' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request->validated();
        $search = Product::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($search))
        {
            return response()->json(['message' => "The products name allready exsist."],400);
        }

        $product = new Product();

        $product['name'] = $request['name'];
        $product['description'] = $request['description'];
        $product['image'] = base64_encode(file_get_contents($request->file('image')));
        $product['price'] = $request['price'];
        $product['ammount'] = $request['ammount'];

        return response()->json(['message' => "Created the product", 'object' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product)
    {
        $object = Product::withTrashed()->firstWhere('id','=', $product);
        $object->orders;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $product)
    {
        $request->validated();
        $base64Image = base64_encode(file_get_contents($request->file('image')));

        $object = Product::withTrashed()->firstWhere('id','=', $product);

        if ($object['name'] != $request['name'])
        {
            $search = Product::withTrashed()->firstWhere('name','=', $request['name']);
            if (!empty($search))
            {
                return response()->json(['message' => "The product name already exist"],400);
            }
            $object['name'] = $request['name'];
        }
        if ($object['description'] != $request['description'])
        {
            $object['description'] = $request['description'];
        }
        if ($object['image'] != $base64Image)
        {
            $search = Product::withTrashed()->firstWhere('image','=', $base64Image);
            if (!empty($search))
            {
                $object['image'] = $search;
            }else
            {
                $object['image'] = $base64Image;
            }
        }
        if ($object['price'] != $request['price'])
        {
            $object['price'] = $request['price'];
        }
        if ($object['amount'] != $request['amount'])
        {
            $object['amount'] = $request['amount'];
        }
        $object->save();

        return response()->json(['message' => "updated the product successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product)
    {
        $object = Product::withTrashed()->firstWhere('id', '=', $product);
        $object->delete();
        return response()->json(['message' => "deleted the product successfully"]);
    }
}
