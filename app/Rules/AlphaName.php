<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaName implements Rule
{
    /**
     * Validates for one or more groups of one or more letters or numbers (or
     * letter component marks), each separated by a single separator (space
     * equivalent in any script, apostrophe, underscore or dash).
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        return preg_match('/^(?:[\pL\pN\pM]+[\pZ\'_-])*[\pL\pN\pM]+$/u', $value) > 0;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return trans('validation.alpha_name');
    }
}
