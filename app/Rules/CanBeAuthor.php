<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CanBeAuthor implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value)
    {
        $author = User::find($value);

        return $author->canBeAuthor();
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return trans('validation.can_be_author');
    }
}
