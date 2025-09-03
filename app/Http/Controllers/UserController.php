<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cache;

class UserController extends Controller
{

    /**
     * Show user online status.
     *
     */
    public function userOnlineStatus()
    {
        $users = DB::table('itdp_admin_users')->get();
    
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo "User " . $user->id . " is online.";
            else
                echo "User " . $user->id . " is offline.";
        }
    }
}