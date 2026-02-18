<?php

namespace App\Http\Requests\Insight\Content;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'title' => 'required|max:40',
            'subtitle' => 'required|max:70',
            'preview' => 'file|mimes:jpg,png,jpeg,webp|max:2048',
            'content' => 'required',
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
            'title.max' => __('validation.max.string', ['max' => 40]),
            'subtitle.required' => __('Subtitle is required.'),
            'subtitle.max' => __('validation.max.string', ['max' => 70]),
            'preview.mimes' => __('Valid types are png, jpg and jpeg'),
            'preview.max' => __('The maximum file size should not exceed 2 MB'),
            'content.required' => __('Content is required'),
        ];
    }
}
