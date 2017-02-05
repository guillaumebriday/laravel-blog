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

    public $dates = [ 'posted_at' ];

    public function scopeLastWeek($query)
    {
        return $query->whereBetween('posted_at', [Carbon::now()->subWeek(), Carbon::now()])
                     ->orderBy('posted_at', 'desc');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
