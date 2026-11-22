<?php

namespace App\Http\Requests\Admin;

use App\Rules\CanBeAuthor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class PostsRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('title'))
        ]);

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
            'title' => ['required'],
            'content' => ['required'],
            'posted_at' => ['required', 'date'],
            'thumbnail_id' => ['nullable', 'exists:media,id'],
            'author_id' => ['required', 'exists:users,id', new CanBeAuthor],
            'slug' => 'unique:posts,slug,' . ($this->post?->id ?: 'NULL'),
        ];
    }
}
