<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmGenre extends Model
{
    protected $fillable = ['film_id', 'genre'];

    public $timestamps = false;

}
