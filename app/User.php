<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','token','avatar','api_token','settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'settings' => 'json',
    ];


    // 该用户所发表的问题
    public function self_question()
    {
        return $this->hasMany(Question::class);
    }


    public function owns(\Illuminate\Database\Eloquent\Model $model)
    {
        return $this->id == $model->user_id;


    }


    public function answer()
    {
        return $this->hasMany(Answer::class);
    }


    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);//toggle 一般用在多对多关系上面
    }



    // 获得该用户是否关注了某个问题
    public function followed($question)
    {
        return !!$this->follows()->where('question_id',$question)->count();
    }


    // 获得关注的用户
    public function follower()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }


    // 对某个问题的评论
    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }



    public function message_to()
    {
        return $this->hasMany(Message::class,'to_user_id');
        
    }

    //用户关注了多少个问题 
    public function followQuestion()
    {
        return $this->belongsToMany(Question::class,'user_question');
    }


    // 用户关注的话题
    public function followUserTopic()
    {
        return $this->belongsToMany(Topic::class,'user_topic')->withTimestamps();

    }

    public function followTopicAction($topic){
        return $this->followUserTopic()->toggle($topic);
    }




}
