<?php

namespace App;

use App\Services\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

    protected $hidden = ['pivot'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
