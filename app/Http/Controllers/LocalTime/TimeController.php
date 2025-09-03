<?php

namespace App\Http\Controllers\LocalTime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class TimeController extends Controller
{

	public function __construct(){

  }

    public function index(){
        $pageTitle = 'Local Time';
        // $comp = DB::table('mst_localtime')->join('mst_country', 'mst_country.id', '=', 'mst_localtime.id_country')->get();
        if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
            return view('localtime.index',compact('pageTitle', 'comp'));
        else
            return redirect('/home');
        } else {
        return redirect('/');
        }
    }

    public function getData()
    {
      $localtime = DB::table('mst_country')->select('mst_country.id', 'mst_country.country', 'mst_localtime.selisih_waktu')
                    ->leftJoin('mst_localtime', 'mst_localtime.id_country', '=', 'mst_country.id')->orderBy('country', 'asc')->get();

      return \Yajra\DataTables\DataTables::of($localtime)
          ->addIndexColumn()
          ->addColumn('action', function ($data) {
            $p = '<center><div class="btn-group">';
            $p .= '<a href="'.route('localtime.view', $data->id).'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;<a href="'.route('localtime.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>';
            return $p.'</div></center>';
          })
                   
          ->make(true);
    }

    public function change(Request $req)
    {
        $id = $req->id_country;
        $td = $req->selisih_waktu;

        $data =  DB::table('mst_localtime')->where('id_country', $id)->first();
        if(isset($data)){
            $query =  DB::table('mst_localtime')->where('id_country', $id)->update([
                'selisih_waktu' => $td
              ]);
        } else {
            $query =  DB::table('mst_localtime')->insert([
                'id_country' => $id,
                'selisih_waktu' => $td
            ]);
        }
        
        if($query){
            Session::flash('error','Success Updating Data');
            return redirect('/localtime')->with('error', 'Success Updating Data');
        }else{
            Session::flash('error','Failed Updating Data');
            return redirect('/localtime')->with('error', 'Failed Updating Data');
        }
    }

    public function view($id)
    {
      $pageTitle = "Localtime";
      $page = "view";
      $data =  DB::table('artikel')->where('id', $id)->first();
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('localtime.create',compact('page','data','pageTitle'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "News";
      $url = "/localtime/change";      
      $data =  DB::table('mst_country')->select('mst_country.id', 'mst_country.country', 'mst_localtime.selisih_waktu')
                ->leftJoin('mst_localtime', 'mst_localtime.id_country', '=', 'mst_country.id')->where('mst_country.id', $id)->first();

      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('localtime.create',compact('url','data','pageTitle','page'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

}