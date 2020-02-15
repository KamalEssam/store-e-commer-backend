<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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
                'en_name' => 'required|unique:sizes,en_name',
                'ar_name' => 'required|unique:sizes,ar_name',
            ];
        }
        return [
            'en_name' => 'required|unique:sizes,en_name,' . $this->id,
            'ar_name' => 'required|unique:sizes,ar_name,' . $this->id,
        ];

    }
}
