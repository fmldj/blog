<?php

namespace App\Http\Controllers;

use DB;
use Redis;
use App\Question;
use Illuminate\Http\Request;

class LikeController extends BaseController
{	
	// 点赞
    public function store(Request $request)
    {
    	$question_id = $request->get('question_id');
    	$question = Question::find($question_id);
    	$user = authApiUser();


    	Redis::sadd('question_set',$question_id);//用set类型保存被点赞的文章

    	$mysql_like = DB::table('user_like_question')->where('question_id' , $question_id)->where('user_id' , $user->id)->first();

    	$redis_like = Redis::sadd('question:'.$question_id,$user->id);

    	// 当前并没有点赞
    	if(empty($mysql_like) && $redis_like){
    		Redis::incr('like_count'.$question_id);
    		Redis::zadd('user:'.$user->id, strtotime(now()), $question_id);
    		Redis::hmset('question_user_like_'.$question_id.'_'.$user->id ,'user_id', $user->id,
                'user_name', $user->name,
                'user_avatar', $user->avatar,
                'question_id', $question_id,
                'question_title', $question->title,
                'ctime', now());
            return [
                'code' => 200,
                'msg'  => 'LIKE',
            ];

    	}else{
    		Redis::srem('question:'.$question_id,$user->id);
			 // 反之, 不管是 Mysql 中还是 Redis 中有过点赞记录, 此次操作均被视为取消点赞
    		Redis::decr('like_count'.$question_id);
    		Redis::zrem('user:'.$user->id, $question_id);
			DB::table('user_like_question')->where('question_id', $question_id)->where('user_id', $user->id)->delete();
			Redis::hdel('question_user_like_'.$question_id.'_'.$user->id,'user_id','user_name','user_avatar','question_id','question_title','ctime');
            return [
                'code' => 202,
                'msg'  => 'UNLIKE',
            ];

    	}

    	// dd($my_like);
    }
}
