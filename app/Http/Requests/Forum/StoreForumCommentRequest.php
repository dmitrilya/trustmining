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
            'text' => 'required|string|max:1500',
            'images' => 'max:5',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'forum_answer_id' => 'exists:forum_answers,id',
        ];
    }
}
