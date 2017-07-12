<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

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
        $author = User::find($this->author_id);
        $canBeAuthor = $author ? $author->canBeAuthor() : false;

        $this->merge([
            'can_be_author' => $canBeAuthor
        ]);

        $this->merge([
            'slug' => str_slug($this->input('title'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required|max:255',
            'posted_at' => 'required|date_format:d/m/Y H:i:s',
            'author_id' => 'required|exists:users,id',
            'can_be_author' => 'required|accepted',
            'slug' => 'unique:posts,slug,' . ($this->post ? $this->post->id : null),
        ];
    }
}
