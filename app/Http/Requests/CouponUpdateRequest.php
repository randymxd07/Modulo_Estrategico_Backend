<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:100', 'unique:coupons,description'],
            'porcent' => ['required', 'numeric'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'status' => ['required'],
            'softdeletes' => ['required'],
        ];
    }
}
