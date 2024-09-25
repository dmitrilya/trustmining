<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->user();

        $descriptionMax = $user->tariff ? $user->tariff->max_description : 500;

        return [
            'images' => 'max:8',
            'images.*' => 'file|mimes:jpg,png,jpeg|max:2048',
            'video' => 'nullable|active_url',
            'description' => 'nullable|max:' . $descriptionMax,
            'logo' => 'file|mimes:jpg,png,jpeg|max:1048',
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
            'logo.mimes' => __('Valid types are png, jpg and jpeg.'),
            'logo.max' => __('The maximum file size should not exceed 1 MB.'),
        ];
    }
}
