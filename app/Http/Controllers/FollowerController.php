<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use App\Events\UserFollowerEvent;


class FollowerController extends BaseController
{

    // 初始化当前用户的被关注信息
    public function index($id)
    {

    	$user = authApiUser();
    	$res = $user->follower()->where(['followed_id' => $id])->first();
    	if($res){

    		return response()->json(['status' => true]);

    	}

	    	return response()->json(['status' => false]);


    }

    // 关注某个用户，若已关注，则取消关注

    public function follower(Request $request)
    {

    	$user = User::find($request->get('user_id'));
    	$res = authApiUser()->follower()->toggle($user->id);

    	if(count($res['detached']) > 0){
    		$user->decrement('follwers_count');//被关注者
    		authApiUser()->decrement('follwings_count');//关注者
    		return response()->json(['status' => false]);
    	}else{
    		$user->notify(new \App\Notifications\NewUserFollowNotification());
			$user->increment('follwers_count');
			authApiUser()->increment('follwings_count');
            broadcast(new UserFollowerEvent(authApiUser(),$user)); //广播给被关注者
			return response()->json(['status' => true]);
    	}

    }
}
