<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'keywords',
        'body',
        'user_id'
    ];

    use SlugTrait;

    /**
     * Article belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Article belongs to many tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Archives dates
     *
     * @return array
     */
    public static function archives()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, month(created_at) month_index, count(*) enabled')
            ->groupBy('year', 'month', 'month_index')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();
    }

    /**
     * Scope query to only include articles of year, month
     *
     * @param $query
     * @param $year
     * @param $month
     * @return mixed
     */
    public function scopeOfDate($query, $year, $month)
    {
        $query->latest()->whereYear('created_at', $year);

        if(isset($month))
        {
            $query->whereMonth('created_at', $month);
        }
        
        return $query;
    }
}