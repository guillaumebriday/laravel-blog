<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use App\Rules\CanBeAuthor;
use Carbon\Carbon;

class PostsRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => str_slug($this->input('title'))
        ]);

        $this->merge([
            'posted_at' => Carbon::parse($this->input('posted_at'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post_id = optional($this->post)->id;

        if ($this->expectsJson()) {
            $post_id = $this->post;
        }

        return [
            'title' => 'required',
            'content' => 'required|max:255',
            'posted_at' => 'required|date',
            'author_id' => ['required', 'exists:users,id', new CanBeAuthor],
            'slug' => 'unique:posts,slug,' . $post_id,
            'thumbnail' => 'image',
        ];
    }
}
