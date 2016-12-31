<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'author_id',
      'title',
      'content',
      'posted_at'
  ];

  public $dates = [ 'posted_at' ];

  public function scopeLastMonth($query, $limit = 5)
  {
    return $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])
                 ->orderBy('posted_at', 'desc')
                 ->limit($limit);
  }

  public function author()
  {
    return $this->belongsTo('App\User', 'author_id');
  }

  public function comments()
  {
    return $this->hasMany('App\Comment');
  }
}
