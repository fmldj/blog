<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionFollowController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}



    public function follow(Request $request,$question)
    {	

// dd(\Auth::user()->followd());
    	authUser()->followThis($question);
    	return back();
    }
}
