<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = "user_question";

    protected $fillable = ['user_id', 'question_id'];
}
