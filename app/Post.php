<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

  public function author()
  {
    return $this->belongsTo('App\User', 'author_id');
  }
}
