<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Role;
use App\Comment;
use App\Post;
use App\Like;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'registered_at', 'api_token'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'registered_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's fullname titleized.
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        return title_case($this->name);
    }

    /**
     * Encrypt the user's password.
     *
     * @param string $passwword
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Scope a query to only include users registered last week.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('registered_at', [Carbon::now()->subWeek(), Carbon::now()])
                     ->latest();
    }

    /**
     * Scope a query to order users by latest registered.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('registered_at', 'desc');
    }

    /**
     * Scope a query to filter available author users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthors($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('roles.name', Role::ROLE_ADMIN)
                  ->orWhere('roles.name', Role::ROLE_EDITOR);
        });
    }

    /**
    * Check if the user can be an author
    *
    * @return boolean
    */
    public function canBeAuthor(): bool
    {
        return $this->isAdmin() || $this->isEditor();
    }

    /**
    * Check if the user has a role
    *
    * @param string $role
    * @return boolean
    */
    public function hasRole($role): bool
    {
        return $this->roles->where('name', $role)->isNotEmpty();
    }

    /**
    * Check if the user has role admin
    *
    * @return boolean
    */
    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }

    /**
    * Check if the user has role editor
    *
    * @return boolean
    */
    public function isEditor(): bool
    {
        return $this->hasRole(Role::ROLE_EDITOR);
    }

    /**
    * Return the user's posts
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
    * Return the user's comments
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    /**
    * Return the user's likes
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function likes()
    {
        return $this->hasMany(Like::class, 'author_id');
    }

    /**
    * Return the user's roles
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
