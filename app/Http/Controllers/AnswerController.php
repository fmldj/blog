<?php

namespace App\Http\Controllers;


use App\Answer;
use App\Events\AnswerEvent;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;


class AnswerController extends BaseController
{
    // 用户回答
    public function store(AnswerRequest $request, $id)
    {
    	$answer = Answer::create([
    		'question_id' =>$id,
    		'user_id' => authId(),
    		'body' => $request->body,
    	]);
        event(new AnswerEvent($answer));//回答后触发的事件


    	return back();
    }


    public function index(){

        return view('answer.index');
        
    }
}
