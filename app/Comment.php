<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'author_id',
      'post_id',
      'content',
      'posted_at'
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
     * Scope a query to only include comments posted last week.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('posted_at', [Carbon::now()->subWeek(), Carbon::now()])
                     ->orderBy('posted_at', 'desc');
    }

    /**
    * Return the comment's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
    * Return the comment's post
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
