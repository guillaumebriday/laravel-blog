<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Concern\Mediable;
use App\Concern\Likeable;
use App\Scopes\PostedScope;
use Carbon\Carbon;
use App\Comment;
use App\User;

class Post extends Model
{
    use Mediable, Likeable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'posted_at',
        'thumbnail_id',
        'slug',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'posted_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PostedScope);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        if (request()->expectsJson()) {
            return 'id';
        }

        return 'slug';
    }

    /**
     * Scope a query to search posts
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%");
    }

    /**
     * Scope a query to order posts by latest posted
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('posted_at', 'desc');
    }

    /**
     * Scope a query to only include posts posted last month.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastMonth($query, $limit = 5)
    {
        return $query->whereBetween('posted_at', [Carbon::now()->subMonth(), Carbon::now()])
                     ->latest()
                     ->limit($limit);
    }

    /**
     * Scope a query to only include posts posted last week.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('posted_at', [Carbon::now()->subWeek(), Carbon::now()])
                     ->latest();
    }

    /**
     * Check if the post has a valid thumbnail
     *
     * @return boolean
     */
    public function hasThumbnail(): bool
    {
        return $this->hasMedia($this->thumbnail_id);
    }

    /**
     * Retrieve the post's thumbnail
     *
     * @return mixed
     */
    public function thumbnail()
    {
        return $this->media->where('id', $this->thumbnail_id)->first();
    }

    /**
     * Store and set the post's thumbnail
     *
     * @return void
     */
    public function storeAndSetThumbnail(UploadedFile $thumbnail)
    {
        $thumbnail_name = $thumbnail->store('/');

        $media = $this->media()->create([
            'filename' => $thumbnail_name,
            'original_filename' => $thumbnail->getClientOriginalName(),
            'mime_type' => $thumbnail->getMimeType()
        ]);

        $this->update(['thumbnail_id' => $media->id]);
    }

    /**
    * Return the post's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
    * Return the post's comments
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * return the excerpt of the post content
     *
     * @param  $length
     * @return string
     */
    public function excerpt($length = 50): string
    {
        return str_limit($this->content, $length);
    }
}
