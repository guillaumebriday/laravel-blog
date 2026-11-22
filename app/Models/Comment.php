<?php

namespace App\Models;

use App\Concern\Likeable;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(CommentObserver::class)]
#[Fillable([
    'author_id',
    'post_id',
    'content',
    'posted_at'
])]
class Comment extends Model
{
    use HasFactory, Likeable;

    /**
     * Scope a query to only include comments posted last week.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Scope]
    protected function lastWeek(Builder $query): Builder
    {
        return $query->whereBetween('posted_at', [carbon('1 week ago'), now()])
            ->latest('posted_at');
    }

    /**
     * Return the comment's author
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Return the comment's post
     *
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * The attributes that should be mutated to dates.
     */
    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime'
        ];
    }
}
