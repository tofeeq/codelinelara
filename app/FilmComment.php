<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmComment extends Model
{
    protected $fillable = ['film_id', 'name', 'comments'];
}
