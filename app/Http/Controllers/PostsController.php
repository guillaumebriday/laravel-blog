<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PostsRequest;
use App\Post;

class PostsController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = Post::latest()->paginate(20);
        return view('posts.index')->withPosts($posts);
    }

    /**
    * Show the rss feed of posts.
    *
    * @return Response
    */
    public function feed()
    {
        $posts = Cache::remember('feed-posts', 60, function () {
            return Post::latest()->limit(20)->get();
        });

        return response()->view('posts.feed', ['posts' => $posts], 200)->header('Content-Type', 'text/xml');
    }

    /**
    * Display the specified resource.
    */
    public function show(Request $request, Post $post)
    {
        $comments = $post->comments()->latest()->paginate(50);
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        return view('posts.create');
    }

    /**
    * Display the specified resource edit form.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit')->withPost($post);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store(PostsRequest $request)
    {
        $user = Auth::user();

        $post = $user->posts()->create([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        return redirect()->route('posts.show', $post)->with('success', __('posts.created'));
    }
}
