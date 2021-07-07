<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        $rules = [];

        $rules["product"] = ["required", "numeric", "exists:products,id"];
        $rules["quantity"] = ["required", "numeric", "min:1"];
        $rules["order"] = ["nullable", "exists:orders,id"];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return void
     */
    public function attributes()
    {
        $attributes = [];

        $attributes["product"] = "Product";
        $attributes["quantity"] = "Quantity";

        return $attributes;
    }
}
