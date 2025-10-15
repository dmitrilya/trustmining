<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
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
            'inn' => 'required|string',
            'documents' => 'max:4',
            'documents.*' => 'file|mimes:doc,docx|max:1024',
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
            'documents.size' => __('File limit exceeded.'),
            'documents.*.mimes' => __('Valid types are doc (word).'),
            'documents.*.max' => __('The maximum file size should not exceed 1 MB.'),
        ];
    }
}
