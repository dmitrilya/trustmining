<?php

namespace App\Http\Requests\Roulette;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoulettePrizeRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'caption' => 'required:string',
            'partner_link' => 'required|active_url',
            'href' => 'required|active_url',
            'chance' => 'required|numeric',
        ];
    }
}
