<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\OfficeBelongsToUser;
use App\Rules\PaymentableCoin;

use App\Models\Ad\AdCategory;

class UpdateAdRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        if (is_string($this->props)) {
            $this->merge([
                'props' => json_decode($this->props, true),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $ad = $this->route('ad');

        return [
            'office_id' => ['required', new OfficeBelongsToUser],
            'preview' => 'file|mimes:jpg,png,jpeg,webp|max:2048',
            'images' => 'nullable|array|max:3',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'props' => [
                'nullable',
                function ($attribute, $value, $fail) use ($ad) {
                    if ($ad->adCategory->name === 'firmwares') {
                        if (!is_array($value)) return $fail('The props must be an array.');

                        if (!isset($value['Modes']) || !is_array($value['Modes']) || empty($value['Modes']))
                            $fail('For a firmware category, you must specify a list of operating modes.');

                        if (!array_key_exists('Fee (%)', $value) || blank($value['Fee (%)']))
                            $fail('For a firmware category, the "Fee (%)" field is required.');
                    }
                },
            ],
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
            'preview.required' => __('Preview is required'),
            'preview.mimes' => __('Valid types are png, jpg and jpeg'),
            'preview.max' => __('The maximum file size should not exceed 2 MB'),
            'images.max' => __('File limit exceeded'),
            'images.*.mimes' => __('Valid types are png, jpg and jpeg'),
            'images.*.max' => __('The maximum file size should not exceed 1 MB'),
            'price.required' => __('Price is required'),
            'price.numeric' => __('The price must be in numerical format'),
            'coin_id.required' => __('Currency is required.'),
            'coin_id.exists' => __('Invalid currency'),
        ];
    }
}
