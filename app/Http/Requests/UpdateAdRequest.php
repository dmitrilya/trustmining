<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'waiting' => 'max:120',
            'warranty' => 'max:12',
            'preview' => 'file|mimes:jpg,png,jpeg|max:2048',
            'images.*' => 'file|mimes:jpg,png,jpeg|max:1048',
            'price' => 'required|numeric',
        ];
    }
}
