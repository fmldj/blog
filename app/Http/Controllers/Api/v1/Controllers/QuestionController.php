<?php

namespace App\Http\Controllers\Api\v1\Controllers;

use App\Model\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function show(Request $request)
    {
    	echo $request->input('id');
    }

    public function index()
    {
		$data = Question::all();
		dd($data);
		// return response()->json(['res' => $data]);
    }
}
