<?php
namespace App\Repositories;

use App\Topic;

/**
 * 
 */
class TopicRepository
{
	// 获取全部主题
	 public function getAllTopicData()
	 {
			$topics = Topic::get();
	        $topics = $topics->map(function($query){
	            if(authCheck()){
	                $count = $query->followTopicUser()->where('user_id' , authUser()->id)->count();
	            }else{
	                $count = 0;
	            }
	            
	            $query->is_followed = !!$count;
	            return $query;
	        });	
	        return $topics;		
	 }

	// 通过主题id获得详细信息
	 public function getById($topic_id)
	 {
	 	$topic = Topic::where('id',$topic_id)->first();
	 	return $topic;
	 }

	// 获得当前主题被多少个用户关注
	public function getTopicFollowedUserCount($topic_id)
	{
        if(authCheck()){
            $count = !!authUser()->followUserTopic()->where('topic_id', $topic_id)->count();
        }else{
            $count = false;
        }

        return $count;
	}	 
	
	// 搜索话题获得对应的主题列表
	public function getTopicQuetion($topic_id)
	{
        $res = Topic::find($topic_id)->questions;
        $res = $res->map(function($query){
                $query->name = $query->user->name;
                $query->answer = $query->answer()->count();
                return $query;
        })->toArray();
        return $res;		
	}


}