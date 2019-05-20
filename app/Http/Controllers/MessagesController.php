<?php

namespace App\Http\Controllers;


use Auth;
use App\User;
use App\Message;
use App\Question;
use Illuminate\Http\Request;
use App\Events\MessageEvent;
use App\Repositories\MessageRepository;
use App\Notifications\NewMessageNotification;


class MessagesController extends BaseController
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

	// 发送私信(问题详情页)
    public function send(Request $request)
    {	
        $data = [
            'send_to_user_id' => $request->get('user_id'),
            'body' => $request->get('body'),
            'dialog_id' => authApiUser()->id.$request->get('user_id'),

        ];


        $Message = $this->messageRepository->create($data,'api');

    	if($Message){

            $Message->toUser->notify(new NewMessageNotification($Message,1));
            broadcast(new MessageEvent($Message,$Message->toUser));//广播
    		return response()->json(['status' => true]);

    	}else{

    		return response()->json(['status' => fasle]);

    	}

    }

    // 展现私信列表
    public function index()
    {
        $message = $this->messageRepository->getAllMessageData();


        return view('messages.index',['message' => $message]);

    }


    // 通过$dialog_id展现私信对话
    public function show($dialog_id)
    {   

        $res = $this->messageRepository->getByDialogId($dialog_id);
        $send_to_user_id = $res['send_to_user_id'];
        $messages = $res['messages'];


        return view('messages.show',compact('messages','dialog_id','send_to_user_id'));
    }

    // 回复私信
    public function store(Request $request)
    {

        $data = [
            'send_to_user_id' => $request->get('send_to_user_id'),
            'body' => $request->get('body'),
            'dialog_id' => $request->get('dialog_id'),

        ];


        $Message = $this->messageRepository->create($data,'web');
        
        if($Message){
                $toUser = User::find($request->get('send_to_user_id'));
                $Message->toUser->notify(new NewMessageNotification($Message));
                broadcast(new MessageEvent($Message,$toUser));//广播
        }


        return back();
    }
}
