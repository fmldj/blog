<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Response\ApiResponse;

class QuestionController extends Controller
{
    use ApiResponse;
    public function show(Request $request)
    {
    	echo $request->input('id');
    }

    public function index()
    {
		$data = Question::all();
        // 3/0;
        return $this->success($data);

    }
}
