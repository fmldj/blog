<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\QuestionsDelEvent' => [
            'App\Listeners\QuestionsDelEventListener',
        ],
        'App\Events\QuestionSendEvent' => [
            'App\Listeners\QuestionsSendEventListener',
        ],
        'App\Events\AnswerEvent' => [
            'App\Listeners\AnswerEventListener',
        ],
        'App\Events\CommentEvent' => [
            'App\Listeners\CommentEventListener',
        ],
        'App\Events\TopicEvent' => [
            'App\Listeners\TopicEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
