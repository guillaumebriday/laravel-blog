<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'likeable_id',
    'likeable_type',
    'author_id',
])]
class Like extends Model
{
    use HasFactory;

    /**
     * Get all of the owning likeable models.
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Return the like's author
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
