<?php

use App\User;
use App\Follow;
use App\Dynamic;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login','ApiController\v1\JwtController@login');

Route::group(['middleware' => 'jwt.auths', 'namespace' => 'ApiController\v1', 'prefix' => 'v1'], function(){
		Route::get('/getuser','JwtController@getuser');
		Route::get('/show/{id}','QuestionController@show');

});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/topics',function(Request $request){
	$q = $request->input('q');
	return \App\Topic::where('name','like','%'.$q.'%')->get();
});


// 初始化(用户关注问题)
Route::post('/question/followed',function(Request $request){

	$user = \Auth::guard('api')->user();
	$res = $user->followed($request->get('question_id'));
	$status = $res ? true : false;
	return response()->json(['status' => $status]);
})->middleware('auth:api');

// 用户关注问题
Route::post('/question/follow',function(Request $request){


	$user = \Auth::guard('api')->user();
	$question = \App\Question::find($request->get('question_id'));

	$res = $user->followThis($question->id);

	if(count($res['detached']) > 0){
		// 动态删除
        Dynamic::where([            
        		'user_id' => \Auth::guard('api')->user()->id,
                'user_question' => $question->id,
                'type' => 5,])->delete();

		$question->decrement('followers_count');
		$status = false;
	}else{
		// 动态添加
        Dynamic::create([
                'user_id' => \Auth::guard('api')->user()->id,
                'user_question' => $question->id,
                'type' =>5,
        ]);

		$question->increment('followers_count');
		$status = true;
	}
	
	return response()->json(['status' => $status]);

})->middleware('auth:api');

// 关注用户
Route::get('/follower/index/{id}','FollowerController@index')->middleware('auth:api');
Route::post('/follower','FollowerController@follower')->middleware('auth:api');


// 检测该用户是否对某个评论已经点赞了
Route::get('/answer/index/{id}','VotesController@index')->name('user.index');
Route::post('/answer/vote','VotesController@vote')->name('user.vote');


// 站内私信
Route::post('/send/messages','MessagesController@send')->name('send.message');


// 对于答案的评论
Route::get('/answer/{id}/comments','CommentController@answer')->name('answer.comments');

// 对于问题的评论
Route::get('/question/{id}/comments','CommentController@question')->name('answer.question');

// 提交评论
Route::post('/comment','CommentController@store')->name('comment.store');

// 多级回复
Route::post('/comment/pl','CommentController@pl')->name('comment.pl');


// 用户关注某个话题
Route::post('/topic/following','TopicController@following')->name('topic.following');

// 点赞
Route::post('/like','LikeController@store')->name('like');
