<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'slug',
        'amount',
        'current_quantity',
        'minimum_quantity'
    ];

    public function setNameAttribute($value) //Data Uppercase
    {
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function user() //Relationship User
    {
        return $this->belongsTo(User::class);
    }

    public function category() //Relationship Category
    {
        return $this->belongsTo(Category::class);
    }
}
