<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'registered_at'
    ];

    public $dates = [ 'registered_at' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeLastWeek($query)
    {
        return $query->whereBetween('registered_at', [Carbon::now()->subWeek(), Carbon::now()])
                     ->orderBy('registered_at', 'desc');
    }

    /**
    * Check if the user has a role
    *
    * @param string $role
    * @return boolean
    */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
    * Check if the user has role admin
    *
    * @return boolean
    */
    public function isAdmin()
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'author_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'author_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }
}
