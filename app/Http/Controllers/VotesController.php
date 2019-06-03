<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Answer;
use Illuminate\Http\Request;

class VotesController extends BaseController
{

	// 初始化获得当前登录的用户是否点赞了某一个评论
    public function index($id)
    {
    	$user = authApiUser();
    	$res = !! $user->votes()->where(['answer_id' => $id])->first();

    	return response()->json(['status' => $res]);

    }

    // 用户点赞评论，如果已经点过则删除原来的记录
    public function vote(Request $request)
    {
		$answer = Answer::find($request->get('answer'));
    	$user = authApiUser();
    	$res = $user->voteFor($answer->id);
    	if(count($res['detached']) > 0){

			$answer->decrement('votes_count');
			return response()->json(['status' => false]);

    	}else{

    		$answer->increment('votes_count');
    		return response()->json(['status' => true]);
    		
    	}


    }
}
