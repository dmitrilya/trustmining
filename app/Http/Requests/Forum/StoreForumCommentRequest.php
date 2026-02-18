<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumCommentRequest extends FormRequest
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
            'text' => 'required_without_all:images,files|max:1500',
            'images' => 'nullable|max:5|required_without_all:files,text',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'files' => 'nullable|max:3|required_without_all:images,text',
            'files.*' => 'file|mimes:doc,docx,pdf,txt|max:512',
            'forum_answer_id' => 'exists:forum_answers,id',
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
            'images.*.max' => __('The maximum file size should not exceed 1 MB'),
        ];
    }
}
