<?php

namespace App\Http\Requests\Insight\Content;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('channel')->user_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:70',
            'preview' => 'required|file|mimes:jpg,png,jpeg,webp|max:5120',
            'url' => [
                'required',
                'url',
                'regex:/^https:\/\/(www\.)?(vkvideo\.ru|youtube\.com|rutube\.ru)/i'
            ],
            'series_id' => 'exclude_if:series_id,0|exists:series,id',
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
            'title.max' => __('validation.max.string', ['max' => 100]),
            'preview.required' => __('Preview is required'),
            'preview.mimes' => __('Valid types are png, jpg and jpeg'),
            'preview.max' => __('The maximum file size should not exceed 5 MB'),
            'url.required' => __('Url is required'),
            'url.regex' => __('Only links from VK Video, YouTube, or RuTube are allowed')
        ];
    }
}
