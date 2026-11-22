<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class CommentsRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'posted_at' => Date::parse($this->input('posted_at'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'content' => ['required'],
            'posted_at' => 'required|after_or_equal:' . $this->comment->post->posted_at,
            'author_id' => ['required', 'exists:users,id']
        ];
    }
}
