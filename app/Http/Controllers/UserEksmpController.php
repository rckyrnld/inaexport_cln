<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cache;

class UserEksmpController extends Controller
{

    /**
     * Show user online status.
     *
     */
    public function usereksmpOnlineStatus()
    {
        $users = DB::table('itdp_company_users')->get();
    
        foreach ($users as $user) {
            if (Cache::has('user-is-eksmp-' . $user->id))
                echo "User " . $user->id . " is online.";
            else
                echo "User " . $user->id . " is offline.";
        }
    }
}