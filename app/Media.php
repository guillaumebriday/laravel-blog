<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename',
        'original_filename',
        'mime_type',
        'mediable_id',
        'mediable_type'
    ];

    /**
     * Get the media's url.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return route('files', ['filename' => $this->filename]);
    }

    /**
     * Get the media's storage path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return storage_path('app/') . $this->filename;
    }
}
