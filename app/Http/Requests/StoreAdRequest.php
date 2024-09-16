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
        return [
            'ad_category_id' => 'required|exists:ad_categories,id',
            'asic_version_id' => [
                'required', 'exists:asic_versions,id', Rule::unique('ads')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id)->where('new', $this->filled('new'));
                })
            ],
            'waiting' => 'required_without:in_stock|max:120',
            'warranty' => 'required_without:new|max:12',
            'preview' => 'required|file|mimes:jpg,png,jpeg|max:2048|dimensions:ratio=4/3',
            'images' => 'max:3',
            'images.*' => 'file|mimes:jpg,png,jpeg|max:1024',
            'price' => 'required|numeric',
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
            'asic_version_id.unique' => __('You already sell such miner.'),
            'waiting.required_without' => __('Waiting is required.'),
            'waiting.max' => __('Waiting too long.'),
            'warranty.required_without' => __('Warranty is required.'),
            'warranty.max' => __('The remainder of the warranty must be less than 12 months.'),
            'preview.required' => __('Preview is required.'),
            'preview.mimes' => __('Valid types are png, jpg and jpeg.'),
            'preview.max' => __('The maximum file size should not exceed 2 MB.'),
            'preview.dimensions' => __('The preview aspect ratio should be 4:3.'),
            'images.max' => __('File limit exceeded.'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg.'),
            'images.*.max' => __('The maximum file size should not exceed 1 MB.'),
            'price.required' => __('Price is required.'),
            'price.numeric' => __('The price must be in numerical format.'),
        ];
    }
}
