<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;
use Pusher\Pusher;

class NotificationController extends Controller
{
    //
    public function GetNotif()
    {
        $id = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
        $data['notif'] = DB::table('notif')->where('untuk_id', $id)->get();
        return $data;
    }
    public function notification($idadmin)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'New message';
        $channel = 'chat-notif-channel-admin-' . $idadmin;
        $pusher->trigger($channel, 'App\\Events\\Notify', $data);
    }
    public function notificationcom($idcompany)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'New message';
        $channel = 'chat-notif-channel-com-' . $idcompany;
        $pusher->trigger($channel, 'App\\Events\\Notify', $data);
    }
}
