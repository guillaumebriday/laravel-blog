<?php

namespace App\Http\Requests;

use App\Rules\AlphaName;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new AlphaName],
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ];
    }
}
