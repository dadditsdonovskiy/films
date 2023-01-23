<?php

namespace App\Validators;

trait PhoneNumberValidator
{
    /**
     * Validate that an attribute passes a regular expression check.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function validatePhoneNumberMask($attribute, $value, $parameters) //NOSONAR
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        // Check format (XXX) XXX-XXXX
        return preg_match('/^[(](\d{3})[)] (\d{3})[-](\d{4})/', $value) > 0;
    }
}
