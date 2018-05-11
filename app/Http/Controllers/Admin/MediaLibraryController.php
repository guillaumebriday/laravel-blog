<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaLibraryRequest;
use App\Models\Media;
use App\Models\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaLibraryController extends Controller
{
    /**
     * Return the media library.
     */
    public function index(Request $request): View
    {
        return view('admin.media.index', [
            'media' => MediaLibrary::first()->media()->get()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $medium): Media
    {
        return $medium;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediaLibraryRequest $request): RedirectResponse
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
     */
    public function destroy(Media $medium): RedirectResponse
    {
        $medium->delete();

        return redirect()->route('admin.media.index')->withSuccess(__('media.deleted'));
    }
}
