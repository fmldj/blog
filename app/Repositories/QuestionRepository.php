<?php
namespace App\Repositories;

use Auth;
use Redis;
use App\Topic;
use App\Question;

class QuestionRepository
{


	public function all()
	{
		$questions = Question::published()->with(['user','likes'])->orderBy('created_at','DESC')->get();
        $questions->map(function($query){

            preg_match( '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$query->body,$res);
            $res = isset($res[1])&&!empty($res[1]) ? $res[1] : '';
            $query->cover = $res;
            $mysql_count = isset($query->like) ? $query->like->count : 0;
            $query->likes_count = Redis::get('like_count'.$query->id) + $mysql_count;

            if(Auth::check()){
            		$like_self = Redis::smembers('question:'.$query->id);
            		$query->like_self_user = !empty($like_self) && in_array(Auth::id(), $like_self) ? true : false;
            }else{
	            	$query->like_self_user = false;
            }

        });
        return $questions;

	}


	public function getHotData()
	{
        $questions = Question::published()->with('user')->orderBy('look','DESC')->get();

        $questions->map(function($query){
            preg_match( '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$query->body,$res);
            $res = isset($res[1])&&!empty($res[1]) ? $res[1] : '';
            $query->cover = $res;
        });

        return $questions;
	}


	public function getById($id)
	{
		$question = Question::where('id',$id)->with(['topics','answer','user'])->first();
		return $question;
	}


	// 问题提交
	public function store($request)
	{
    	$question = Question::create([
    		'title' => $request->get('title'),
    		'body' => $request->get('body'),
            'desc' => $request->get('desc'),
    		'user_id' => Auth::id(),
    	]);
    	return $question;		
	}

	// 问题更新
	public function update($request,$id)
	{
		$question = Question::find($id);
        $res = $question->update([

            'title' => $request->title,
            'body' => $request->body,
            'desc' => $request->desc,
        ]);

        return compact('question','res');


	}

    public function normalTopic(array $data, $type = 'store',$question = ''){

            if($type == 'store'){
                        $topic = collect($data)->map(function($name,$key) use ($data){

                            if(is_numeric($name)){
                                $is_value = Topic::find($name);
                                if($is_value){
                                        Topic::find($name)->increment('questions_count');
                                        return $name;
                                }else{
                                        return '';
                                }
                                
                                return '';
                            }

                        })->toArray();

                        foreach ($topic as $key => &$value) {
                            if($value == ''){
                                unset($topic[$key]);
                            }
                        }

                        return $topic;
            }

            if($type == 'update'){

                        $exits_id = $question->topics->pluck('id')->toArray();
                        $topic = collect($data)->map(function($name,$key) use ($data){
                            if(is_numeric($name)){
                                $is_value = Topic::find($name);
                                if($is_value){
                                        return $name;
                                }                              
                            }
                        })->toArray();


                        foreach ($topic as $key => $value) {
                            if($value == null){
                                unset($topic[$key]);
                            }
                        }

                        foreach ($topic as $k => $v) {
                            if(!in_array($v, $exits_id)){
                                Topic::find($v)->increment('questions_count');
                            }
                        }

                        foreach ($exits_id as $k => $v) {
                            if(!in_array($v, $topic)){
                                Topic::find($v)->decrement('questions_count');
                            }
                        }

                        return $topic;

            }

    }





}







