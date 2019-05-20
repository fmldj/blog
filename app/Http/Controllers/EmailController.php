<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class EmailController extends BaseController
{
    public function verify(Request $request)
    {

    	$token = $request->input('token');
    	$user = User::where('token',$token)->first();
    	if(!$user){
            flash('网络异常')->error();
    		return redirect(route('login'));
    	}

    	$user->is_active = 1;
    	$user->token = str_random(40);
    	$user->save();
    	Auth::login($user);
        flash('邮箱激活成功！')->success();
    	return redirect(route('questions.index'));
    }
}
