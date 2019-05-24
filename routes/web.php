<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', 'QuestionsController@index')->name('questions.index');







// 提出问题的一系列路由
Route::get('/questions-create','QuestionsController@create')->name('questions.create');
Route::post('/questions-store','QuestionsController@store')->name('questions.store');
Route::get('/questions/{id}','QuestionsController@show')->name('questions.show');
Route::get('/questions/edit/{id}','QuestionsController@edit')->name('questions.edit');
Route::post('/questions/update/{id}','QuestionsController@update')->name('questions.update');
Route::delete('/questions/{id}','QuestionsController@destroy')->name('questions.delete');
// 提出问题的一系列路由（end）


// // 首页关注
Route::get('/follow','QuestionsController@follow')->name('follow');
// // 首页热榜
Route::get('/hot','QuestionsController@hot')->name('hot');



// 话题广场
Route::get('/topics','TopicController@index')->name('topic.index');

// 话题详情页
Route::get('/topic/{topic_id}','TopicController@info')->name('topic');


// 写回答
Route::get('/answer','AnswerController@index')->name('answer.index');


// 根据主题获得对应的话题(写回答)
Route::get('/topic/{topic_id}/question','TopicController@getTopicQuetion')->name('topic.getTopicQuetion');

//搜索页面
Route::get('/search','SearchController@index')->name('search');

// 邮箱验证
Route::get('/email-verify','EmailController@verify')->name('email.verify');

Route::middleware('auth')->group(function(){

			// 回答
			Route::post('/questions/{id}/answer','AnswerController@store')->name('answer.store');


			// 关注问题
			Route::get('/questions/{question}/follow','QuestionFollowController@follow')->name('questions.follow');


			// 站内通知
			Route::get('/notifications','NotificationsController@index')->name('notifications');
			Route::get('/notifications/show/{notifications_id}','NotificationsController@show')->name('notifications.show');

			// 私信列表
			Route::get('/messages/index','MessagesController@index')->name('messages.index');
			Route::get('/messages/show/{dialog_id}','MessagesController@show')->name('messages.show');
			Route::post('/messages/store','MessagesController@store')->name('messages.store');


			// 用户头像上传
			Route::get('/user/avatar','UserController@avatar')->name('user.avatar');
			Route::post('/user/changeAvatar','UserController@changeAvatar')->name('user.changeAvatar');


			// 用户密码修改
			Route::get('/user/password','UserController@password')->name('user.password');
			Route::post('/password','UserController@changePassword')->name('password');

			// 个人设置
			Route::get('/user/setting','UserController@setting')->name('user.setting');
			Route::post('/setting','UserController@changeSetting')->name('setting');

			// 用户主页
			Route::get('/people/{user}/index','UserController@index')->name('people.index');

			// 用户背景封面上传
			Route::post('/user/changeCover','UserController@changeCover')->name('user.changeCover');

});
