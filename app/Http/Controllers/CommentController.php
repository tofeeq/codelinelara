<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\FilmComment;

class CommentController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'comments' => 'required|string',
        ]);
    }

    protected function getRequestData(Request $request) {
		return [
            'name' => $request->get('name'),
            'comments' => $request->get('comments'),
        ];
	} 

	public function store(Request $request, $filmId)
	{
		$filmComment = new FilmComment();
		$data = $this->getRequestData($request);
		
        $validator = $this->validator($data);
        if ($validator->fails()) {
        	return response(
        			$this->formatValidationErrors($validator), 400
        		)->header('Content-Type', 'application/json');

        } else {
        	//creating slug
        	try {
        		$data['film_id'] = $filmId;
        		$filmComment->create($data);

        		return response()->json([
	        		"status" => "success", 
	        	]);

        	} catch (QueryException $e) {
       			$msg = '["' . $e->getMessage() . '"]';
        		return response(
        			$msg, 400
        		)->header('Content-Type', 'application/json');
        	}
        }
	}
}
