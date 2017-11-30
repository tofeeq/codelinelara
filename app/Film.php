<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\UrlGenerator;
use DB;

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


    public function listing() {

        //no of records per page 
        $films = $this->paginate(1);

        foreach ($films as &$film) {
            $film['photo'] = env('APP_URL') . Storage::url($film['photo']);
            $genres = DB::table("film_genres")
                ->where("film_id", $film->id)
                ->get(["id", "genre"])
                 ;
            if (!empty($genres)) {
                $film->genres = $genres;
            }   
        }

        return $films;
    }

}