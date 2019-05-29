<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use Searchable;
    protected $fillable = [
    	'title',
    	'body',
    	'user_id',
        'desc',

    ];

    public function topics()
    {
    	return $this->belongsToMany(Topic::class,'questions_topics')->withTimestamps();
    }

    // 问题被哪些用户关注了
    public function followed()
    {
        return $this->belongsToMany(User::class,'user_question');
    }

    public function user()
    {
    	return $this->belongsTo(\App\User::class);
    }

    public function scopePublished($query)
    {

    	return $query->where('is_hidden','F');

    }

    public function answer()
    {
    	return $this->hasMany(Answer::class);
    }


    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    public function likes()
    {
        return $this->belongsTo(Like::class);
    }


    public function searchableAs()
    {
        return '_doc';
    }

    public function toSearchableArray()
    {
        return [
            'user_id' => $this->user->id,
            'desc' => $this->desc,
            'user_name' => $this->user->name,
            'avatar' => $this->user->avatar,
            'comments' => $this->comments()->count(),
            'question_title' => $this->title,
            'question_body' => $this->body,
            'question_created_at' => $this->created_at,
        ];
    }


}
