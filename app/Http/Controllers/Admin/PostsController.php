<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use Carbon\Carbon;
use App\Post;
use App\User;

class PostsController extends Controller
{
    /**
    * Show the application posts index.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = Post::withCount('comments')->latest()->paginate(50);

        return view('admin.posts.index')->withPosts($posts);
    }

    /**
    * Display the specified resource edit form.
    */
    public function edit(Post $post)
    {
        $users = User::pluck('name', 'id');
        return view('admin.posts.edit')->withPost($post)->withUsers($users);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(PostsRequest $request, Post $post)
    {
        $request['posted_at'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->input('posted_at'));
        $post->update($request->only(['title', 'content', 'posted_at', 'author_id']));

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Post  $post
    * @return \Illuminate\Http\Response
    */
    public function destroy(Post  $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', __('posts.deleted'));
    }
}
