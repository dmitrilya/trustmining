<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreReviewRequest extends FormRequest
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
        $reviewableType = $this->input('reviewable_type');
        $reviewableIdRules = ['required'];

        if (in_array($reviewableType, ['user', 'asic-model', 'gpu-model'])) {
            $tableName = str_replace('-', '_', $reviewableType) . 's';
            $reviewableIdRules[] = "exists:{$tableName},id";
        }

        if ($reviewableType === 'user') $reviewableIdRules[] = Rule::notIn([$this->user()->id]);

        $reviewableIdRules[] = Rule::unique('reviews')->where(function ($query) use ($reviewableType) {
            return $query->where('reviewable_type', $reviewableType)
                ->where('user_id', $this->user()->id);
        });

        return [
            'reviewable_type' => ['required', Rule::in(['user', 'asic-model', 'gpu-model'])],
            'reviewable_id' => $reviewableIdRules,
            'review' => 'required|string|max:500',
            'rating' => 'required|numeric|min:1|max:5',
            'image' => 'file|mimes:jpg,png,jpeg,webp|max:1024',
            'document' => 'file|mimes:pdf,doc,docx|max:1024',
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
            'review.required' => __('Review is required'),
            'review.max' => __('validation.max.string', ['max' => 500]),
            'image.mimes' => __('Valid types are png, jpg and jpeg'),
            'image.max' => __('The maximum file size should not exceed 1 MB'),
            'document.mimes' => __('Valid types are pdf, doc (word).'),
            'document.max' => __('The maximum file size should not exceed 1 MB'),
        ];
    }
}
