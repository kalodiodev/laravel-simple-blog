<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role_id', 
        'about', 
        'country', 
        'profession', 
        'avatar'
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
     * A user has many articles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles() 
    {
        return $this->hasMany(Article::class);
    }

    /**
     * A user belongs to single role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Assign a role to user
     * 
     * @param $role
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function giveRole($role)
    {
        return Role::whereName($role)
            ->firstOrFail()
            ->assignRoleTo($this);
    }

    /**
     * Determine if user has the given role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if(is_string($role))
        {
            return $this->role->name == $role;
        }

        return $role->contains('name', $this->role->name);
    }

    /**
     * Determine if user has the given permission
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if(is_string($permission)) {
            return $this->hasRole(
                Permission::whereName($permission)->firstOrFail()->roles
            );
        }

        return $this->hasRole($permission->roles);
    }

    /**
     * Determine if user owns the given article
     * 
     * @param Article $article
     * @return bool
     */
    public function ownsArticle(Article $article)
    {
        return $this->id === $article->user_id;
    }

    /**
     * User has many comments
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Determine if user owns the given comment
     * 
     * @param Comment $comment
     * @return bool
     */
    public function ownsComment(Comment $comment)
    {
        return $this->id === $comment->user_id;
    }

    /**
     * Check if user has avatar
     *
     * @return bool
     */
    public function hasAvatar()
    {
        return isset($this->avatar);
    }
}