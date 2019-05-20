<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Broadcast::routes();

        Broadcast::channel('message-{id}', function ($user, $id) {

            return (int)$user->id === (int)$id;

        });
        Broadcast::channel('myFollower-{id}', function ($user, $id){
            return (int)$user->id === (int)$id;
        });


        Broadcast::channel('question-send',function($user , $id){
            return true;
        });

        // Broadcast::channel('djfml', function ($user, $id) {

        //     return true;
            
        // });
        // require base_path('routes/channels.php');

    }
}
