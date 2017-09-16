<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename',
        'path',
        'thumbnail',
        'user_id'
    ];

    /**
     * An image belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
