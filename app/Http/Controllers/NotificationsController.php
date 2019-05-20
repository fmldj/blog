<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends BaseController
{
    public function index()
    {
    	return view('notifications.index');
    }

    public function show(DatabaseNotification $notifications_id,Request $request)
    {


    	$res = $notifications_id->markAsRead();
    	return redirect($request->query('query'));

    }
}
