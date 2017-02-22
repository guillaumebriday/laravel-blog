<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CommentsRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        $post = $this->comment->post;

        return [
            'content' => 'required|max:255',
            'posted_at' => 'required|date_format:d/m/Y H:i:s|after_or_equal:' . $post->posted_at,
            'author_id' => 'required|exists:users,id'
        ];
    }
}
