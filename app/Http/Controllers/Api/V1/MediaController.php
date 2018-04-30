<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaLibraryRequest;
use App\Http\Resources\Media as MediaResource;
use App\Models\Media;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Return the comments.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return MediaResource::collection(
            MediaLibrary::first()->media()->paginate($request->input('limit', 20))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MediaLibraryRequest $request
     * @return Response
     */
    public function store(MediaLibraryRequest $request)
    {
        $this->authorize('store', Media::class);

        $image = $request->file('image');
        $name = $image->getClientOriginalName();

        if ($request->filled('name')) {
            $name = $request->input('name');
        }

        return new MediaResource(
            MediaLibrary::first()
                        ->addMedia($image)
                        ->usingName($name)
                        ->toMediaCollection()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media $medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $medium)
    {
        $this->authorize('delete', $medium);

        $medium->delete();

        return response()->noContent();
    }
}
