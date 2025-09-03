<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Auth;
class Permissions {
    public static function get() { 
	
	if(empty(Auth::user()->id_group) && empty(Auth::guard('eksmp')->user()->id_role)) {
		// return redirect()->route('front_end_goh');
	}else{
		if(empty(Auth::user()->id_group)){
			$id_group = Auth::guard('eksmp')->user()->id_role; 
		}else{
			$id_group = Auth::user()->id_group; 
		}
		$menu = DB::select("select a.*,b.* from permissions a, menu b where a.id_group = '".$id_group."' and a.id_menu = b.id_menu order by b.order asc");
        return $menu;
	}
    	

        // $menu = DB::table('permissions')->where('id_group',$id_group)->join('menu','menu.id_menu','=','permissions.id_menu')->orderBy('order','ASC')->get();
		
    }
}