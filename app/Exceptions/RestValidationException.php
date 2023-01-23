<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;

/**
 * Class RestValidationException
 * @package App\Exceptions
 */
class RestValidationException extends ValidationException
{
    /**
     * @return array
     */
    public function errors()
    {
        $errors = [];
        foreach ($this->validator->errors()->messages() as $attribute => $messages) {
            foreach ($messages as $message) {
                $errors[] = [
                    'field' => $attribute,
                    'message' => ucfirst($message),
                ];
            }
        }

        return $errors;
    }
}
