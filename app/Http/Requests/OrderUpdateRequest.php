<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'order_type_id' => ['required', 'integer', 'exists:order_types,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'latitude' => ['required', 'integer'],
            'longitude' => ['required', 'integer'],
            'status' => ['required'],
            'softdeletes' => ['required'],
        ];
    }
}
