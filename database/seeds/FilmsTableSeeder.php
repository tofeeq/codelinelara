<?php

use Illuminate\Database\Seeder;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Film::class, 3)
        	->create()
        	->each(function ($film) {
	        	$film->comments()
	        		->save(factory(App\FilmComment::class)->make());
	        	$film->genres()
	        		->save(factory(App\FilmGenre::class)->make());
	    	});
    }
}
