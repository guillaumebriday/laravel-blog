<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class CanBeAuthor implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $author = User::find($value);
        return $author->canBeAuthor();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.can_be_author');
    }
}
