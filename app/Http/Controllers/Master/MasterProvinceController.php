<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ProvinceExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterProvinceController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'List Province';
      return view('master.province.index',compact('pageTitle'));
    }

    public function getData()
    {
      $province = MasterProvince::orderby('province_en', 'asc')->get();

      return \Yajra\DataTables\DataTables::of($province)
          ->addColumn('province_en', function ($data) {
              return '<div align="left">'.$data->province_en.'</div>';
          })
		  ->addColumn('province_in', function ($data) {
              return '<div align="left">'.$data->province_in.'</div>';
          })
		  ->addColumn('action', function ($data) {
//              return '
//              <center>
//              <div class="btn-group">
//                <a href="'.route('master.province.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//                <a href="'.route('master.province.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
//                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.province.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
//              </div>
//              </center>
//              ';

              return '
              <center>
              <div class="btn-group">
                <a href="'.route('master.province.view', $data->id).'" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                <a href="'.route('master.province.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.province.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action','province_en','province_in'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'List Province';
      $page = 'create';
      $url = "/master-province/store/Create";
      return view('master.province.create',compact('url','pageTitle','page'));
    }

    public function store(Request $req, $param)
    { 
      if($param == 'Create'){
        $data = MasterProvince::insert([
          'id' => $req->kode_province,
          'province_en' => $req->province_en,
          'province_in' => $req->province_in
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterProvince::where('id', $pecah[1])->update([
          'id' => $req->kode_province,
          'province_en' => $req->province_en,
          'province_in' => $req->province_in
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-province/')->with('success', 'Success '.$param.' Data!');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-province/')->with('error', 'Failed '.$param .' Data!');
       }
    }

    public function view($id)
    {
      $pageTitle = "List Province";
      $page = "view";
      $data = MasterProvince::where('id', $id)->first();
      return view('master.province.create',compact('page','data','pageTitle'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "List Province";
      $url = "/master-province/store/Update_".$id;
      $data = MasterProvince::where('id', $id)->first();
      return view('master.province.create',compact('url','data','pageTitle','page'));
    }

    public function destroy($id)
    {
      $data = MasterProvince::where('id', $id)->delete();
      if($data){
         Session::flash('error','Success Delete Data');
         return redirect('/master-province/')->with('error', 'Success Delete Data');
       }else{
         Session::flash('error','Failed Delete Data');
         return redirect('/master-province/')->with('error', 'Failed Delete Data');
       }
    }

    public function check(Request $req){
      $checking = MasterProvince::where('id', $req->kode)->first();
      echo json_encode($checking);
    }

    public function export()
    {
      return Excel::download(new ProvinceExport, 'Province_Data.xlsx');
    }
}
