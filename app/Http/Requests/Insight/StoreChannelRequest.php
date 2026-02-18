<?php

namespace App\Http\Requests\Insight;

use Illuminate\Foundation\Http\FormRequest;

class StoreChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->user()->channel;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:30',
            'slug' => 'required|string|max:20|regex:/^[a-z0-9_]+$/u|unique:channels,slug',
            'brief_description' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'logo' => 'required|image|mimes:jpg,png,jpeg,webp|max:1024',
            'banner' => 'image|mimes:jpg,png,jpeg,webp|max:2048|dimensions:width=960,height=360',
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
            'name.required' => __('Channel name is required'),
            'name.max' => __('The maximum channel name length is 30 characters'),
            'slug.required' => __('Channel address is required'),
            'slug.max' => __('The maximum channel address length is 20 characters'),
            'slug.regex' => __('The channel address can only contain Latin letters, numbers and underscores'),
            'slug.unique' => __('The channel address is already taken'),
            'brief_description.required' => __('Brief description is required'),
            'brief_description.max' => __('The maximum brief description length is 100 characters'),
            'description.required' => __('Channel description is required'),
            'description.max' => __('The maximum channel description length is 500 characters'),
            'logo.required' => __('Logo is required'),
            'logo.mimes' => __('Valid types are png, jpg and jpeg'),
            'logo.max' => __('The maximum file size should not exceed 1 MB'),
            'banner.mimes' => __('Valid types are png, jpg and jpeg'),
            'banner.max' => __('The maximum file size should not exceed 2 MB'),
            'banner.dimensions' => __('Banner dimensions should be 960px by 360px'),
        ];
    }
}
