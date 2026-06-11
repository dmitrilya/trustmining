<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\OfficeBelongsToUser;
use App\Rules\PaymentableCoin;

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
            'asic_version_id' => 'exists:asic_versions,id',
            'gpu_model_id' => 'exists:gpu_models,id',
            'office_id' => ['required', new OfficeBelongsToUser],
            'preview' => 'required|file|mimes:jpg,png,jpeg,webp|max:2048',
            'images' => 'nullable|array|max:3',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'props' => 'nullable',
            'description' => 'sometimes|string',
            'price' => 'required|numeric',
            'coin_id' => ['required', new PaymentableCoin],
            'with_vat' => 'sometimes',
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
            'asic_version_id.required' => __('Miner version is required'),
            'asic_version_id.exists' => __('Non-existent miner version'),
            'preview.required' => __('Preview is required'),
            'preview.mimes' => __('Valid types are png, jpg and jpeg'),
            'preview.max' => __('The maximum file size should not exceed 2 MB'),
            'images.max' => __('File limit exceeded'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg'),
            'images.*.max' => __('The maximum file size should not exceed 1 MB'),
            'price.required' => __('Price is required'),
            'price.numeric' => __('The price must be in numerical format'),
            'coin_id.required' => __('Currency is required.'),
        ];
    }
}
