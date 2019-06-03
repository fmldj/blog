<?php

namespace App\Jobs;

use Mail;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $st = new SendCloudTemplate('test_template_active',['url' => route('email.verify',['token' => $this->user->token]), 'name' => $this->user->name]);
            $user = $this->user;
            Mail::raw($st, function ($message) use($user){
                    $message->from('18565854805@163.com', '海是天的倒影');
                    $message->to($user->email);
            });

    }
}
