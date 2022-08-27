<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductValidator extends FormRequest
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
        if (request('price_based_on') == 'single') {
            $rules['variations'] = 'required|array|max:1';
        } else {
            $rules['variations'] = 'required|array|min:1';
        }
        $rules += [
            'product_name' => 'required',
            'product_barcode' =>  [
                'required',
                Rule::unique('products')->ignore(request('product')->id)
            ],
            'price_based_on' => 'required|in:single,variation',
            'variations.*.unit' => 'required|int',
            'variations.*.price' => 'required|int',
            'variations.*.images' => 'required|array',
            'variations.*.images.*' => 'required|url',
        ];
        return $rules;
    }
    
    /**
     * failedValidation
     *
     * @param  mixed $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }
}
