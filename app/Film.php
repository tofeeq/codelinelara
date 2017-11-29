<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'films';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'release_date', 'ticket_price', 'country', 'photo', 'rating', 'slug'
    ];

}