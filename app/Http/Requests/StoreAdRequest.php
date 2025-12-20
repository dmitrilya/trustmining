<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdRequest extends FormRequest
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
            'ad_category_id' => 'required|exists:ad_categories,id',
            'asic_version_id' => 'exists:asic_versions,id',
            'office_id' => 'required|exists:offices,id',
            'preview' => 'required|file|mimes:jpg,png,jpeg,webp|max:2048',
            'images' => 'max:3',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'description' => 'max:' . $descriptionMax,
            'price' => 'required|numeric',
            'coin_id' => ['required', Rule::exists('coins', 'id')->where(fn($q) => $q->where('paymentable', true))],
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
            'asic_version_id.required' => __('Miner version is required.'),
            'asic_version_id.exists' => __('Non-existent miner version.'),
            'preview.required' => __('Preview is required.'),
            'preview.mimes' => __('Valid types are png, jpg and jpeg.'),
            'preview.max' => __('The maximum file size should not exceed 2 MB.'),
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('The maximum file size should not exceed 1 MB.'),
            'price.required' => __('Price is required.'),
            'price.numeric' => __('The price must be in numerical format.'),
            'coin_id.required' => __('Currency is required.'),
            'coin_id.exists' => __('Invalid currency.'),
        ];
    }
}
