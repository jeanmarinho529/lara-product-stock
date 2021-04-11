<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

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
            'user_id' => 'nullable|int|min:1',
            'category_id' => 'required|int|min:1',
            'name' => 'required|string|min:5|max:150',
            'description' => 'nullable|string|min:10|max:255',
            'slug'  => 'nullable|min:5',
            'amount' => 'nullable|numeric|min:0',
            'current_quantity' => 'nullable|int|min:0',
            'minimum_quantity' => 'nullable|int|min:0'
        ];
    }
}
