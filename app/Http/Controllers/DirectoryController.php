<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use auth;

class DirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
		if (Auth::guard('eksmp')->user()->id_role == 2) {
            $pageTitle = 'Directory Buyer';
            $country = DB::table('mst_country')->orderby('country','asc')->get();
            return view('directory.index', compact('pageTitle','country'));
        } else {
            return redirect('/home');
        }
    }

    public function view($id)
    {
		if (Auth::guard('eksmp')->user()->id_role == 2) {
            $pageTitle = 'Detail Buyer';
            $data = DB::table('itdp_profil_imp')->where('id',$id)->first();
            // dd($data);
            return view('directory.view', compact('pageTitle','data'));
        } else {
            return redirect('/home');
        }
    }

    public function getData(Request $req){
    	$query = DB::table('itdp_company_users as a')->join('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
            	->where('a.status', '1')->selectRaw('b.id, b.company, b.id_mst_country')->leftjoin('mst_country as c', 'b.id_mst_country', '=', 'c.id')->orderby('c.country','asc')->orderby('b.company', 'asc');
        if($req->name != '' || $req->name != null){
        	$query->where('b.company', 'ILIKE', '%'.$req->name.'%');
        }
        if($req->country != '' || $req->country != null){
        	$query->where('b.id_mst_country', $req->country);
        }
    	$buyer = $query->get();

    	return \Yajra\DataTables\DataTables::of($buyer)
    		->addIndexColumn()
    		->addColumn('name', function($data) {
    			return '<div align="left">'.$data->company.'</div>';
    		})
    		->addColumn('country', function($data){
    			$negara = DB::table('mst_country')->where('id', $data->id_mst_country)->first();
    			if($negara){
    				return $negara->country;
    			} else {
    				return 'Unknown Country';
    			}
    		})
	      	->addColumn('action', function ($data) {
				return '
				<center>
					<div class="btn-group">
					<a href="'.route('directory.view', $data->id).'" class="btn btn-sm btn-info btn-eye" title="Detail">&nbsp;<i class="fa fa-eye text-white"></i> </a>
					</div>
				</center>
				';
	      	})
	      	->rawColumns(['action','name'])
	      	->make(true);
    }
}