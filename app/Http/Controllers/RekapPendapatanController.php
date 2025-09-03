<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class RekapPendapatanController extends Controller
{
	public function __construct()
        {
            $this->middleware('auth:web');
        }
	
    public function index()
    {
		if(empty(Auth::guard('eksmp')->user()->id)){
		$pageTitle = "Company Incomes";
		$data = "";
        return view('rekap-pendapatan.index', compact('pageTitle','data'));
		}else{
			echo "abc";
		}
		
    } 
	
	public function cetakrc()
    {
		$pageTitle = "Rekap Pendapatan";
		$research = DB::select("select * from csc_research_corner order by id desc");
        return view('rekap-pendapatan.cetakrc', compact('pageTitle','research'));
		
    }
	
	public function exportpendapatanall()
    {
		
		$pageTitle = "Rekap Pendapatan";
		$data = "";
        return view('rekap-pendapatan.cetakall', compact('pageTitle','data'));
		
    }
	
	public function exportpendapatandetail($id)
    {
		
		$pageTitle = "Rekap Pendapatan";
		$data = DB::select("select * from csc_transaksi where id_eksportir='".$id."' and status_transaksi='1'");
        return view('rekap-pendapatan.cetakdetail', compact('pageTitle','data','id'));
		
    }
	
	public function detailpendapatan($id)
    {
		
		$pageTitle = "Detail Company Incomes";
		$data = DB::select("select * from csc_transaksi where id_eksportir='".$id."' and status_transaksi='1'");
        return view('rekap-pendapatan.detailpendapatan', compact('pageTitle','data','id'));
		
    }
	
	


}
