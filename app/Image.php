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

    /**
     * Filter images by given term
     * 
     * <p>Filter by filename or by owner</p>
     * 
     * @param $query
     * @param $term
     * @return mixed
     */
    public function scopeFilter($query, $term)
    {
        return $query
            ->where('filename','like','%' . $term . '%')
            ->orWhereHas('user', function ($query) use($term) {
                $query->filter($term);
            });
    }
}
