<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';
    protected $fillable = ['user_id', 'body', 'commentable_id', 'commentable_type','parent_id'];
    public $parent_name =  '';

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    // 递归
    public static function _getSon($data,$pid,$parent_name=''){

        static $arr = array();
        foreach ($data as $k => $v) {
            if($v['parent_id'] == $pid){
                $v['parent_name'] = $parent_name;
                $arr[] = $v;
                 self::_getSon($data,$v['id'],$v['user']['name']);
                
            }


        }
        return $arr;
    }   


}
