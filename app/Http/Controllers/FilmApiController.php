<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;

use DB;
use App\FilmGenre;

use GuzzleHttp\Client;

class FilmApiController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //You may also convert a paginator instance to JSON by simply returning it from a route or controller action:
        $film = new Film();
        return $film->listing();
    }

     

    /**
     * Validator rules for validating form data
     *
     * @return Response
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'ticket_price' => 'required|numeric',
            'country' => 'required|string',
            'photo' => 'required|string',
            'rating' => 'required|numeric|max:5',
            'genre' => 'required|json',
        ]);
    }

    /**
     * Get form data into an array
     *
     * @return Response
     */

    protected function getRequestData(Request $request) {
        return [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'release_date' => date("Y-m-d", strtotime($request->get('release_date'))),
            'ticket_price' => $request->get('ticket_price'),
            'country' => $request->get('country'),
            'photo' => $request->get('photo'),
            'rating' => $request->get('rating'),
            'genre' => $request->get('genre'),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $film = new Film();
        $data = $this->getRequestData($request);
        $validator = $this->validator($data);

        if (! $validator->fails()) {
         
            //creating slug
            $data['slug'] = str_slug($data['name'], "-"); 
            $film->create($data);

            $filmId = DB::getPdo()->lastInsertId();

            $genreModel = new FilmGenre();
            $genres = json_decode($request->get('genre'));
            foreach ($genres as $genre) {
                $genreModel->create([
                    "film_id" => $filmId,
                    "genre" => $genre
                ]);
            }
            return response()->json(["id" => $filmId]);
        }

        return $validator->errors()->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        return $film;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Film $film)
    {
        
        $data = $this->getRequestData($request);

        $validator = $this->validator($data);

        if (!$validator->fails()) {

            unset($data['genre']);
            $data['slug'] = str_slug($data['name'], "-"); 
            $film->update($data);
             

            $genreModel = new FilmGenre();
            $genres = json_decode($request->get('genre'));

            $genreModel->where("film_id", $film->id)->delete();

            foreach ($genres as $genre) {
                $genreModel->create([
                    "film_id" => $film->id,
                    "genre" => $genre
                ]);
            }
            return response()->json(["id" => $film->id]);
        }

         return $validator->errors()->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return response()->json(["id" => $film->id]);
    }
}
