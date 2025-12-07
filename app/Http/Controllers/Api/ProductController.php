<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::latest()->paginate(10);
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validated();
        
        // Get each field from request
        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sku' => $request->sku,
            'user_id' => Auth::id()
        ];

        $product = Product::create($productData);
        
        return response()->json([
            'message' => 'Product created successfully',
            'product' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validated();
        
        // Update each field individually
        if ($request->has('name')) {
            $product->name = $request->name;
        }
        if ($request->has('description')) {
            $product->description = $request->description;
        }
        if ($request->has('price')) {
            $product->price = $request->price;
        }
        if ($request->has('quantity')) {
            $product->quantity = $request->quantity;
        }
        if ($request->has('sku')) {
            $product->sku = $request->sku;
        }
        
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => new ProductResource($product)
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}