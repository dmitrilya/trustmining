<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHostingRequest extends FormRequest
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
            'description' => 'required|max:1500',
            'video' => 'nullable|active_url',
            'images' => 'max:10',
            'images.*' => 'file|mimes:jpg,png,jpeg|max:2048',
            'documents' => 'max:3',
            'documents.*' => 'file|mimes:pdf|max:1024',
            'price' => 'required|min:0|max:10',
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
            'description.required' => __('Description is required.'),
            'description.max' => __('validation.max.string', ['max' => 1500]),
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('The maximum file size should not exceed 2 MB.'),
            'documents.max' => __('File limit exceeded.'),
            'documents.*.mimes' => __('Valid types are pdf.'),
            'documents.*.max' => __('The maximum file size should not exceed 1 MB.'),
            'price.required' => __('Price is required.'),
            'price.min' => __('Price is required.'),
            'price.max' => __('Price is required.'),
        ];
    }
}
