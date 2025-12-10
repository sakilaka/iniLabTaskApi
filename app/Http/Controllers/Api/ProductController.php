<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\Product;


class ProductController extends Controller
{
    protected $service;


    public function __construct(ProductService $service)
    {
        $this->service = $service;
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $products = $this->service->list($perPage);
        return ProductResource::collection($products);
    }


    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $product = $this->service->create($data);
        return new ProductResource($product);
    }


    public function show($id)
    {
        $product = $this->service->find($id);
        return new ProductResource($product);
    }


    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->service->update($product, $request->validated());
        return new ProductResource($product);
    }


    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return response()->json(['message' => 'Deleted'], 200);
    }
}
