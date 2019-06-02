<?php

namespace App\Http\Controllers\ApiController\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function show(Request $request)
    {
    	echo $request->input('id');
    }
}
