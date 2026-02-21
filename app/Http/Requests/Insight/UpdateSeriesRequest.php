<?php

namespace App\Http\Requests\Insight;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeriesRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:300',
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
            'name.required' => __('Series name is required'),
            'name.max' => __('The maximum series name length is 30 characters'),
            'description.required' => __('Series description is required'),
            'description.max' => __('The maximum series description length is 300 characters'),
        ];
    }
}
