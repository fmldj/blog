<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dynamic extends Model
{
    protected $fillable = ['user_id', 'question_id', 'type','user_question','topic_id','answer_id','comments_id'];


    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }

    public function question()
    {
    	return $this->belongsTo(Question::class);
    }

    public function userQuestion()
    {
    	return $this->belongsTo(Question::class,'user_question');
    }

    public function answer()
    {
    	return $this->belongsTo(Answer::class);
    }
}
