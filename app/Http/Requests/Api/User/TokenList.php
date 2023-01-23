<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\FormRequest;

class TokenList extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'perPage' => ['integer', 'max:10000'],
            'page' => ['integer'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
