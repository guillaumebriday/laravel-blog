<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|alpha_dash',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|confirmed',
            'roles.*' => 'exists:roles,id'
        ];
    }
}
