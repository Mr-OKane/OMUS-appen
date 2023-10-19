<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000 per page is to much"],400);
        }

        $products = Product::paginate($paginationPerPage);

        return response()->json(['object' => $products]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted', Product::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ products per page is to much"],400);
        }

        $products = Product::onlyTrashed()->paginate($paginationPerPage);

        return response()->json(['object' => $products]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [Product::class,$user]);

        $request->validated();

        $productExists = Product::withTrashed()->firstWhere('name','=', $request['name']);
        if (!empty($productExists))
        {
            if ($productExists->trashed())
            {
                $productExists->restore();
                return response()->json(['message' => "The product already exists but was deleted and now is restored"],201);
            }
            return response()->json(['message' => "The products name already exist."],400);
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
        $user = auth('sanctum')->user();
        $this->authorize('view', [Product::class,$user]);

        $object = Product::withTrashed()->firstWhere('id','=', $product);
        $object->orders;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $product)
    {
        $object = Product::withTrashed()->firstWhere('id','=', $product);

        $this->authorize('update', [$object,User::class]);

        $request->validated();
        $base64Image = base64_encode(file_get_contents($request->file('image')));

        if ($object['name'] != $request['name'])
        {
            $productExists = Product::withTrashed()->firstWhere('name','=', $request['name']);
            if (!empty($productExists))
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
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Product::class,$user]);

        $object = Product::withTrashed()->firstWhere('id', '=', $product);
        $object->delete();
        return response()->json(['message' => "deleted the product successfully"]);
    }

    public function restore(string $product)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [Product::class,$user]);

        $object = Product::onlyTrashed()->firstWhere('id','=', $product);
        $object->restore();
        $object->orders;

        return response()->json(['message' => "Restored the ",'object' => $object],201);
    }

    public function forceDelete(string $product)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [Product::class,$user]);

        $object = Product::onlyTrashed()->firstWhere('id','=', $product);
        $object->forceDelete();

        return response()->json(['message' => "deleted the product completely"]);
    }
}
