<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;

use DB;
use App\FilmGenre;

use GuzzleHttp\Client;

class FilmController extends Controller
{
    /**
     * Display a listing of the films at home
     *
     * @return \Illuminate\Http\Response
     */
    
    public function home( Request $request )
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('APP_URL') . '/api/',
            // You can set any number of default request options.
            'timeout'  => 5.0,
        ]);

        try {
            $response = $client->request('GET', 'film', [
                "json" => ["page" => $request->get("page")]
            ]);

        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }

        
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $json = $body->getContents();
        
        } else {
            throw new Exception($response->getReasonPhrase());               
        }
        
        return view('films', ['paginator' => json_decode($json)]);
    }

    //web route sinfle film detail page
    public function single(Request $request, $slug)
    {
        $modelFilm = new Film();
        $film = $modelFilm->find("slug", $slug);

        return view('film', ['film' => $film]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelFilm = new Film();
        return view('filmform', ["modelFilm" => $modelFilm]);
    }


    /**
     * Store a film coming from front end form, it is different as involves file upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeform(Request $request)
    {
         
        $film = new Film();
        $data = $this->getRequestData($request);


        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'ticket_price' => 'required|numeric',
            'country' => 'required|string',
            'photo' => 'required|file',
            'rating' => 'required|numeric|max:5',
            'genre' => 'required',
        ]);

         
        //creating slug
        $data['slug'] = str_slug($data['name'], "-"); 


        if ($request->file('photo')->isValid()) {
            $path = $request->photo->store('images');
            $data['photo'] = $path;
        }
        try {
            $film->create($data);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                $msg = '["Film name already exists"]';
            } else {
                $msg = '["' . $e->getMessage() . '"]';
            }
            return response(
                $msg, 400
            )->header('Content-Type', 'application/json');
        }

        $filmId = DB::getPdo()->lastInsertId();

        $genreModel = new FilmGenre();
        $genres = explode(",", $request->get('genre'));
        foreach ($genres as $genre) {
            $genreModel->create([
                "film_id" => $filmId,
                "genre" => $genre
            ]);
        }
        
        return redirect()->route("films-create")
            ->with('message','Film was successfully created!');
            ; 
        
    }
    /***********************************************************************
    /*                     API ROUTES CALLS
    /***********************************************************************

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        //
    }
}
