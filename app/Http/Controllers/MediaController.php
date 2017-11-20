<?php

namespace App\Http\Controllers;

use App\Media;

class MediaController extends Controller
{
    /**
     * @param  String $medium
     * @return Response
     */
    public function show(String $medium)
    {
        $media = Media::where('filename', $medium)->firstOrFail();

        $headers = [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => "filename='{$media->original_filename}'"
        ];

        return response()->file($media->getPath(), $headers);
    }
}
