<?php
use App\Message;
use Illuminate\Support\Facades\Auth;

// 计算几分钟前、几小时前、几天前
function formatTime($date) {
		$str = '';
		$timer = strtotime($date);
		$diff = $_SERVER['REQUEST_TIME'] - $timer;
		$day = floor($diff / 86400);
		$free = $diff % 86400;
		if($day > 0) {
		return $day."天前";
		}else{
		if($free>0){
		$hour = floor($free / 3600);
		$free = $free % 3600;
		if($hour>0){
		return $hour."小时前";
		}else{
		if($free>0){
		$min = floor($free / 60);
		$free = $free % 60;
		if($min>0){
		return $min."分钟前";
		}else{
		if($free>0){
		return $free."秒前";
		}else{
		return '刚刚';
		}
		}
		}else{
		return '刚刚';
		}
		}
		}else{
		return '刚刚';
		}
		}
}


// 初始化未读消息条数
function getUnReadCount()
{	

	$notification = DB::table('notifications')->where(['notifiable_id' => \Auth::id(), 'read_at' => NULL, 'type' => 'App\Notifications\NewMessageNotification'])->count();
	$message = Message::where(['to_user_id' => \Auth::id(), 'has_read' => 'F'])->count();
	$total = intval($notification) + intval($message);
	return $total;
}

function authCheck(){
	return Auth::check();
}

function authUser()
{
	return Auth::user();
}

function authId()
{
	return Auth::id();
}

function authApiUser()
{
	return Auth::guard('api')->user();
}

