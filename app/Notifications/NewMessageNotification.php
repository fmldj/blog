<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Message;
use Auth;

class NewMessageNotification extends Notification
{
    use Queueable;
    protected $message;
    protected $api_flag = 0;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message , $api_flag = 0)
    {
        $this->api_flag = $api_flag;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {       
            //因为从详情页发送私信和互聊都需要这个通知，所以判断是否是api无状态或者是网页有状态请求 
            $name = $this->api_flag == 1 ? Auth::guard('api')->user()->name : Auth::user()->name;
            return [
                'name' => $name,
                'dialog_id' => $this->message->dialog_id,
            ];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
