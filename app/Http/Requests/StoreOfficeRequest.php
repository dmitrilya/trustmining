<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfficeRequest extends FormRequest
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
            'images' => 'required|max:5',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:2048',
            'video' => 'nullable|active_url',
            'address' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('The maximum file size should not exceed 2 MB.'),
        ];
    }
}
