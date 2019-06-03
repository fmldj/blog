<?php
namespace App\Repositories;

use App\Model\User;
use App\Model\Message;
/**
 * 
 */
class MessageRepository
{
	
	// 私信列表;
	public function getAllMessageData()
	{
		$message = Message::where('to_user_id' , authUser()->id)->orWhere('from_user_id' ,authUser()->id)->with(['fromUser','toUser'])->latest()->orderBy('created_at','DESC')->get();
		$message = $message->unique('dialog_id')->groupBy('to_user_id');
		return $message;
	}

	// 通过$dialog_id展现私信对话
	public function getByDialogId($dialog_id)
	{
        $messages = Message::where('dialog_id' , $dialog_id)->orderBy('created_at','DESC')->get();
        $send_to_user_id = authId() == $messages[0]->from_user_id ? $messages[0]->to_user_id : $messages[0]->from_user_id;
        $messages->markRead();//标记为已读
        return compact('messages','send_to_user_id');
	}


	// 回复私信
	public function create(array $request, $type = 'web')
	{

      	
        $newMessage = Message::create([
                'from_user_id' => $type == 'web' ? authUser()->id : authApiUser()->id,
                'to_user_id' => $request['send_to_user_id'],
                'body' => $request['body'],
                'dialog_id' => $request['dialog_id'],
        ]);

        return $newMessage;

	}



}