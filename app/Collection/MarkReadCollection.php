<?php

namespace App\Collection;

use Illuminate\Database\Eloquent\Collection;
use Auth;

class MarkReadCollection extends Collection
{
        public function markRead()
        {
            $this->each(function($messages){
                if($messages->to_user_id == Auth::user()->id){
                        $messages->markRead();
                }
                
            });
        }

}
