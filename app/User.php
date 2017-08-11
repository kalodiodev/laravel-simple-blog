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
        'name', 'email', 'password',
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
}