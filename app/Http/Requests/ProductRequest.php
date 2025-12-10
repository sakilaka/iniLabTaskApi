<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }


    public function rules()
    {
        $id = $this->route('product');


        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string',
        ];
    }
}