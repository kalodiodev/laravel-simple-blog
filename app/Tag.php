<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Tag belongs to many articles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles() 
    {
        return $this->belongsToMany(Article::class);
    }
}
