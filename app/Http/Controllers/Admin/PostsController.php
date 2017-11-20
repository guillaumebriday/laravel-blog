<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use Illuminate\Http\Request;
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
        return view('admin.posts.index', [
            'posts' => Post::withCount('comments', 'likes')->with('author')->latest()->paginate(50)
        ]);
    }

    /**
    * Display the specified resource edit form.
    */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'users' => User::authors()->pluck('name', 'id')
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        return view('admin.posts.create', [
            'users' => User::authors()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PostsRequest $request)
    {
        $post = Post::create($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.created'));
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(PostsRequest $request, Post $post)
    {
        $post->update($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

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

        return redirect()->route('admin.posts.index')->withSuccess(__('posts.deleted'));
    }
}
