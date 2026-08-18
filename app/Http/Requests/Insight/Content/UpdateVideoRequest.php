<?php

namespace App\Http\Requests\Insight\Content;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
        $publishedAtRules = ['nullable', 'date'];
        $publishedAt = $this->input('published_at') ? date('Y-m-d H:i', strtotime($this->input('published_at'))) : null;
        if ($publishedAt !== $this->route('video')->published_at->format('Y-m-d H:i')) $publishedAtRules[] = 'after:now';

        return [
            'title' => 'required|max:100',
            'preview' => 'file|mimes:jpg,png,jpeg,webp|max:5120',
            'series_id' => 'exclude_if:series_id,0|exists:series,id',
            'published_at' => $publishedAtRules,
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
            'preview.mimes' => __('Valid types are png, jpg and jpeg'),
            'preview.max' => __('The maximum file size should not exceed 5 MB'),
        ];
    }
}
