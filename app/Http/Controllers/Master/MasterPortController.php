<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPort;
use App\Models\MasterProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PortExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterPortController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'List Port';
      return view('master.port.index',compact('pageTitle'));
    }

    public function getData()
    {
      $port = MasterPort::leftjoin('mst_province as a', 'mst_port.id_mst_province','=','a.id')
            ->orderby('mst_port.name_port', 'asc')
            ->select('mst_port.*')
            ->get();

      return \Yajra\DataTables\DataTables::of($port)
          ->addColumn('province_en', function ($port) {
              $data = MasterProvince::where('id', $port->id_mst_province)->first();
              if($data){
                return '<div align="left">'.$data->province_en.'</div>';
              } else {
                return '<div align="left">PROVINCE NOT FOUND</div>';
              }
          })
		  ->addColumn('name_port', function ($port) {
              
                return '<div align="left">'.$port->name_port.'</div>';
             
          })
          ->addColumn('action', function ($data) {
//              return '
//              <center>
//              <div class="btn-group">
//                <a href="'.route('master.port.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//                <a href="'.route('master.port.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
//                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.port.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
//              </div>
//              </center>
//              ';
              return '
              <center>
              <div class="btn-group">
                <a href="'.route('master.port.view', $data->id).'" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                <a href="'.route('master.port.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('master.port.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action','province_en','name_port'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'List Port';
      $page = 'create';
      $url = "/master-port/store/Create";
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.port.create',compact('url','pageTitle','page','province'));
    }

    public function store(Request $req, $param)
    { 
      if($param == 'Create'){
        $data = MasterPort::insert([
          'id' => $req->id,
          'id_mst_province' => $req->province,
          'name_port' => $req->port
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterPort::where('id', $pecah[1])->update([
          'id' => $req->id,
          'id_mst_province' => $req->province,
          'name_port' => $req->port
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-port/')->with('success', 'Success '.$param.' Data!');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-port/')->with('error', 'Failed '.$param .' Data!');
       }
    }

    public function view($id)
    {
      $pageTitle = "List Port";
      $page = "view";
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.port.create',compact('page','data','pageTitle','province'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "List Port";
      $url = "/master-port/store/Update_".$id;
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.port.create',compact('url','data','pageTitle','page','province'));
    }

    public function destroy($id)
    {
      $data = MasterPort::where('id', $id)->delete();
      if($data){
//         Session::flash('error','Success Delete Data');
         return redirect('/master-port/')->with('error', 'Success Delete Data');
       }else{
//         Session::flash('error','Failed Delete Data');
         return redirect('/master-port/')->with('error', 'Failed Delete Data');
       }
    }

    public function check(Request $req){
      $checking = MasterPort::where('id', $req->kode)->first();
      echo json_encode($checking);
    }

    public function export()
    {
      return Excel::download(new PortExport, 'Port_Data.xlsx');
    }
}
