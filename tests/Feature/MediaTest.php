<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Media;

class MediaTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it retrieves the requested media
     * @return void
     */
    public function testGetFile()
    {
        $filename = UploadedFile::fake()->image('file.png')->store('/');
        $media = factory(Media::class)->create([
            'filename' => $filename,
            'original_filename' => 'file.png'
        ]);
        $response = $this->actingAs($this->user())->get("/files/{$filename}");

        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'image/png')
                 ->assertHeader('Content-Disposition', "filename='file.png'");

        Storage::delete($filename);
    }
}
