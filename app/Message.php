<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Collection\MarkReadCollection;

class Message extends Model
{
    protected $fillable = ['from_user_id','to_user_id','body','dialog_id'];

    public function fromUser()
    {
    	return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
    	return $this->belongsTo(User::class,'to_user_id');
    }

    public function markRead()
    {
    		if(is_null($this->read_at)){
    				$this->forceFill(['has_read' => 'T', 'read_at' => $this->freshTimestamp()])->save();
    		}
    }

    public function newCollection(array $models = [])
    {
    	return new MarkReadCollection($models);

    }

    public function read()
    {
    	return $this->has_read === 'T';
    }

    public function unread()
    {
    	return $this->has_read === 'F';
    }

    public function readOrUnread(){
    	if($this->to_user_id == Auth::user()->id){
    		return $this->unread();
    	}
    	return false;
    }


}
