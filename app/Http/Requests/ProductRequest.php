<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'en_name' => 'required|unique:products,en_name',
                'ar_name' => 'required|unique:products,ar_name',
                'image' => 'required|image',
                'en_desc' => 'required',
                'ar_desc' => 'required',
                'category_id' => 'required|numeric|exists:categories,id',
                'brand_id' => 'required|numeric|exists:brands,id',
                'price' => 'required|numeric|min:0'
            ];
        }
        return [
            'en_name' => 'required|unique:categories,en_name,' . $this->id,
            'ar_name' => 'required|unique:categories,ar_name,' . $this->id,
            'en_desc' => 'required',
            'ar_desc' => 'required',
            'category_id' => 'required|numeric|exists:categories,id',
            'brand_id' => 'required|numeric|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image'
        ];

    }
}
