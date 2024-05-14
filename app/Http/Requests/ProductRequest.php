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
        $data = [
            'code' => 'required|unique:products',
            'name' => 'required',
            'tax_rate_id' => 'required',
            //'barcode_symbology' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'wholesaler_price' => 'numeric',
            'shipping_id' =>  'required|numeric',
            'quantity' =>  'required|numeric',
        ];

        return $data;
    }
}
