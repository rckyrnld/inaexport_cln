<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DataContactUsController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'List Contact Us';
      return view('management.contact-us.index',compact('pageTitle'));
    }

    public function getData()
    {
      $contactus = DB::table('csc_contact_us')->orderby('id','desc')->get();

      return \Yajra\DataTables\DataTables::of($contactus)
          ->addIndexColumn()
          ->addColumn('action', function ($data) {
//              return '
//              <center>
//              <div class="btn-group">
//                <a href="'.route('management.contact-us.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('management.contact-us.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
//              </div>
//              </center>
//              ';

              return '
              <center>
              <div class="btn-group">
                <a href="'.route('management.contact-us.view', $data->id).'" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('management.contact-us.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
              </div>
              </center>
              ';
          })
		      ->addColumn('fullname', function ($data) {
              return '<div align="left">'.$data->fullname.'</div>';
          })
          ->addColumn('subyek', function ($data) {
              return '<div align="left">'.$data->subyek.'</div>';
          })
          ->addColumn('message', function ($data) {
              return '<div align="left">'.$data->message.'</div>';
          })
          ->rawColumns(['action','fullname','subyek','message'])
          ->make(true);
    }

    public function view($id)
    {
      $pageTitle = "Data Contact Us";
      $data = DB::table('csc_contact_us')->where('id',$id)->first();
      $read_notif = DB::table('notif')->where('id_terkait',$id)->update(['status_baca' => 1]);
      return view('management.contact-us.view',compact('data','pageTitle'));
    }

    public function destroy($id)
    {
      $data = DB::table('csc_contact_us')->where('id',$id)->delete();
      if($data){
         Session::flash('error','Success Delete Data');
         return redirect('/management/contact-us/')->with('success','Success Delete Data');
       }else{
         Session::flash('error','Failed Delete Data');
         return redirect('/management/contact-us/')->with('error','Failed Delete Data');
       }
    }
}
