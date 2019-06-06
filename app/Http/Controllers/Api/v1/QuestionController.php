<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\EmptyException;


class QuestionController extends Controller
{

    public function show(Request $request)
    {
    	echo $request->input('id');
    }

    public function index()
    {
		$data = Question::all();

        if(!$data){
            throw new EmptyException('数据不存在',400);
        }
        3/0;
        return $this->success($data);

    }
}
