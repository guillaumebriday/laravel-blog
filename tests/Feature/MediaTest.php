<?php

namespace Tests\Feature;

use App\Media;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFile()
    {
        $filename = UploadedFile::fake()->image('file.png')->store('/');
        $media = factory(Media::class)->create([
            'filename' => $filename,
            'original_filename' => 'file.png'
        ]);

        $this->get("/media/{$filename}")
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('Content-Disposition', "filename='file.png'");

        Storage::delete($filename);
    }
}
