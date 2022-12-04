<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_type_id' => ['required', 'integer', 'exists:order_types,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'status' => ['boolean'],
            "order_details" => ['required', 'array'],
            "order_details.*.product_id" => ['required', 'integer', 'exists:products,id'],
            "order_details.*.quantity" => ['required', 'integer']
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors()->all(), 422));
    }

}
