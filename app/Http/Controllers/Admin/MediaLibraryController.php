<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaLibraryRequest;
use App\Media;
use App\MediaLibrary;
use Illuminate\Http\Request;

class MediaLibraryController extends Controller
{
    /**
     * Return the media library.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.media.index', [
            'media' => MediaLibrary::first()->media()->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Media $medium
     * @return \Illuminate\Http\Response
     */
    public function show(Media $medium)
    {
        return $medium;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MediaLibraryRequest $request
     * @return Response
     */
    public function store(MediaLibraryRequest $request)
    {
        $image = $request->file('image');
        $name = $image->getClientOriginalName();

        if ($request->filled('name')) {
            $name = $request->input('name');
        }

        MediaLibrary::first()
            ->addMedia($image)
            ->usingName($name)
            ->toMediaCollection();

        return redirect()->route('admin.media.index')->withSuccess(__('media.created'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media $medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $medium)
    {
        $medium->delete();

        return redirect()->route('admin.media.index')->withSuccess(__('media.deleted'));
    }
}
