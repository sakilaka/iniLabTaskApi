<?php

namespace App\Services;


use App\Models\Product;


class ProductService
{
    public function list($perPage = 15)
    {
        return Product::latest()->paginate($perPage);
    }


    public function find($id)
    {
        return Product::findOrFail($id);
    }


    public function create(array $data)
    {
        return Product::create($data);
    }


    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }


    public function delete(Product $product)
    {
        return $product->delete();
    }
}
