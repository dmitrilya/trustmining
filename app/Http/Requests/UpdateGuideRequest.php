<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideRequest extends FormRequest
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
        $user = $this->user();

        return [
            'title' => 'required|max:40',
            'preview' => 'file|mimes:jpg,png,jpeg,webp|max:2048',
            'subtitle' => 'required|max:100',
            'guide' => 'required',
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
            'title.required' => __('Title is required.'),
            'title.max' => __('validation.max.string', ['max' => 40]),
            'preview.mimes' => __('Valid types are png, jpg and jpeg.'),
            'preview.max' => __('The maximum file size should not exceed 2 MB.'),
            'subtitle.required' => __('Subtitle is required.'),
            'subtitle.max' => __('validation.max.string', ['max' => 100]),
            'guide.*.max' => __('Guide is required.'),
        ];
    }
}
