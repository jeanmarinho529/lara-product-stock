<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'initials'];

    public function setNameAttribute($value) //Data Uppercase
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setInitialsAttribute($value) //Data Uppercase
    {
        $this->attributes['initials'] = strtoupper($value);
    }
}
