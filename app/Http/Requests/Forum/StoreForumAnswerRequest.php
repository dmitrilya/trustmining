<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumAnswerRequest extends FormRequest
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
            'text' => 'required|string|max:1500',
            'images' => 'max:5',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'forum_question_id' => 'exists:forum_questions,id',
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
            'images.max' => __('Image limit exceeded.'),
            'images.*.mimes' => __('Valid types are jpg,png,jpeg,webp.'),
            'images.*.max' => __('The maximum file size should not exceed 1 MB.'),
        ];
    }
}
