<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
    	'name','bio','questions_count,followers_count'
    ];


    public function questions()
    {
    	return $this->belongsToMany(Question::class,'questions_topics')->withTimestamps();
    }

    // 那个话题被用户关注
    public function followTopicUser()
    {
    	return $this->belongsToMany(User::class,'user_topic')->withTimestamps();
    }
}
