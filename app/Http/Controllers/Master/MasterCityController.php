<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterCityController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'List City';
      return view('master.city.index',compact('pageTitle'));
    }

    public function getData()
    {
      $city = MasterCity::leftjoin('mst_country as a', 'a.id','=','mst_city.id_mst_country')
            ->orderby('a.country', 'asc')
            ->orderby('mst_city.city', 'asc')
            ->select('mst_city.*', 'a.country')
            ->get();

      return \Yajra\DataTables\DataTables::of($city)
          ->addColumn('action', function ($data) {
//              return '
//              <center>
//              <div class="btn-group">
//                <a href="'.route('master.city.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//                <a href="'.route('master.city.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
//                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.city.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
//              </div>
//              </center>
//              ';

              return '
              <center>
              <div class="btn-group">
                <a href="'.route('master.city.view', $data->id).'" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                <a href="'.route('master.city.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.city.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'List City';
      $page = 'create';
      $url = "/master-city/store/Create";
      $country = MasterCountry::orderby('country','asc')->get();
      return view('master.city.create',compact('url','pageTitle','page','country'));
    }

    public function store(Request $req, $param)
    {
      $id = MasterCity::orderby('id','desc')->first();
      if($id){
        $id = $id->id+1;
      } else {
        $id = 1;
      }
      
      if($param == 'Create'){
        $data = MasterCity::insert([
          'id' => $id,
          'id_mst_country' => $req->country,
          'city' => $req->city
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterCity::where('id', $pecah[1])->update([
          'id_mst_country' => $req->country,
          'city' => $req->city
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-city/')->with('success', 'Success '.$param.' Data!');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-city/')->with('error', 'Failed '.$param .' Data!');
       }
    }

    public function view($id)
    {
      $pageTitle = "List City";
      $page = "view";
      $data = MasterCity::where('id', $id)->first();
      $country = MasterCountry::orderby('country','asc')->get();
      return view('master.city.create',compact('page','data','pageTitle','country'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "List City";
      $url = "/master-city/store/Update_".$id;
      $data = MasterCity::where('id', $id)->first();
      $country = MasterCountry::orderby('country','asc')->get();
      return view('master.city.create',compact('url','data','pageTitle','page','country'));
    }

    public function destroy($id)
    {
      $data = MasterCity::where('id', $id)->delete();
      if($data){
         Session::flash('error','Success Delete Data');
         return redirect('/master-city/')->with('error', 'Success Delete Data');
       }else{
         Session::flash('error','Failed Delete Data');
         return redirect('/master-city/')->with('error', 'Failed Delete Data');
       }
    }

    public function export()
    {
      return Excel::download(new CityExport, 'City_Data.xlsx');
    }
}
