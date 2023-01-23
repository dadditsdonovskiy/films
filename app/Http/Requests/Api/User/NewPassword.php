<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\FormRequest;

class NewPassword extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:password_resets,email'],
            'password' => ['required', 'string', 'min:8', 'same:confirmPassword'],
            'resetToken' => ['required', 'string', 'min:2'],
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
