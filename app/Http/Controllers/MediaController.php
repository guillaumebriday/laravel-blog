<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;

class MediaController extends Controller
{
    /**
     * @param  String $filename
     * @return Response
     */
    public function getFile(String $filename)
    {
        $media = Media::where('filename', '=', $filename)->firstOrFail();

        $headers = [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => "filename='{$media->original_filename}'"
        ];

        return response()->file($media->getPath(), $headers);
    }
}
