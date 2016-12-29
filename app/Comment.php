<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

  public function author()
  {
    return $this->belongsTo('App\User', 'author_id');
  }

  public function post()
  {
    return $this->belongsTo('App\Post');
  }
}
