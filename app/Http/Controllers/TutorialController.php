<?php

namespace App\Http\Controllers;

use App\Models\LinkTutorial;
use Illuminate\Http\Request;
use Auth;

class TutorialController extends Controller
{
    public function index()
    {
        $pageTitle = 'Tutorial';
        // Check id_role
        if (Auth::guard('eksmp')->user()) {
            if (Auth::guard('eksmp')->user()->id_role == 2) {
                // Supplier
                $data = LinkTutorial::where('link_tutorial_user_type_id', '2')->first();
            } else if (Auth::guard('eksmp')->user()->id_role == 3) {
                // Buyer
                $data = LinkTutorial::where('link_tutorial_user_type_id', '1')->first();
                return view('tutorial_buyer.index', compact('pageTitle', 'data'));
            } else {
                return redirect('login');
            }
        } else {
            if (Auth::user() != null && Auth::user()->id_group == '4') {
                // Perwadag
                $data = LinkTutorial::where('link_tutorial_user_type_id', '3')->first();
            } else if (Auth::user() != null && Auth::user()->id_group == '5') {
                // Dinas
                $data = LinkTutorial::where('link_tutorial_user_type_id', '4')->first();
            } else {
                return redirect('login');
            }
        }
        return view('tutorial.index', compact('pageTitle', 'data'));
    }
}
