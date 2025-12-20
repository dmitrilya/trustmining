<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'message' => 'nullable|string:max:1000|required_without_all:images,files',
            'images' => 'nullable|max:10|required_without_all:message,files',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'files' => 'nullable|max:3|required_without_all:images,message',
            'files.*' => 'file|mimes:doc,docx,pdf|max:512',
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
            'message.max' => __('validation.max.string', ['max' => 1000]),
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('validaion.size.file', ['size' => 1024]),
            'files.max' => __('File limit exceeded.'),
            'files.*.mimes' => __('Valid types are pdf, doc (word).'),
            'files.*.max' => __('validaion.max.file', ['size' => 512]),
        ];
    }
}
