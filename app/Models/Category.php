<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function setNameAttribute($value) //Data Uppercase
    {
        $this->attributes['name'] = ucwords($value);
    }


    public function products() //Relationship Product
    {
        return $this->hasMany(Product::class);
    }
}
