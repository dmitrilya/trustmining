<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHostingRequest extends FormRequest
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

        $descriptionMax = $user->tariff ? $user->tariff->max_description : 500;

        return [
            'description' => 'required|max:' . $descriptionMax,
            'video' => 'nullable|active_url',
            'images' => 'max:10',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:2048',
            'contract' => 'required|file|mimes:doc,docx|max:1024',
            'territory' => 'file|mimes:doc,docx|max:1024',
            'energy_supply' => 'file|mimes:doc,docx|max:1024',
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
            //'description.max' => __('validation.max.string', ['max' => 1500]),
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('The maximum file size should not exceed 2 MB.'),
            'contract.mimes' => __('Valid types are doc (word).'),
            'contract.max' => __('The maximum file size should not exceed 1 MB.'),
            'territory.mimes' => __('Valid types are doc (word).'),
            'territory.max' => __('The maximum file size should not exceed 1 MB.'),
            'energy_supply.mimes' => __('Valid types are doc (word).'),
            'energy_supply.max' => __('The maximum file size should not exceed 1 MB.'),
            'price.required' => __('Price is required.'),
        ];
    }
}
