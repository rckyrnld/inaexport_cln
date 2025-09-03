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

class MasterSliderController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'Master Slider';
      return view('master.slider.index',compact('pageTitle'));
    }

    
    public function create()
    {
      $pageTitle = 'Add Slider';
      $page = 'create';
      $url = "/master-port/store/Create";
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.slider.create',compact('url','pageTitle','page','province'));
    }

    public function store(Request $request)
    { 
		if(empty($request->file('file_img'))){
			$file = "";
		}else{
			$file = $request->file('file_img')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/slider";
			$request->file('file_img')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into mst_slide (file_img,keterangan,publish,created_at) values
			('".$file."','".$request->keterangan."','".$request->publish."','".Date('Y-m-d H:i:s')."')");
		
		return redirect('master-slide')->with('success','Success Add Data');
    }
	
	public function update(Request $request)
    { 
		if(empty($request->file('file_img'))){
			$file = $request->last_file;
		}else{
			$file = $request->file('file_img')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/slider";
			$request->file('file_img')->move($destinationPath, $file);
		}
		$insert = DB::select("
			update mst_slide set file_img='".$file."', keterangan='".$request->keterangan."', publish='".$request->publish."'
			where id='".$request->idnya."'
			");
		
		return redirect('master-slide')->with('success','Success Update Data');
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
      $pageTitle = "Edit Slide";
      
      return view('master.slider.edit',compact('pageTitle','page','id'));
    }
	
	public function hapus($id)
    {
      $insert = DB::select("
			delete from mst_slide where id='".$id."'
			");
		
		return redirect('master-slide')->with('success','Success Delete Data');
    }

    public function destroy($id)
    {
      $data = MasterPort::where('id', $id)->delete();
      if($data){
         Session::flash('error','Success Delete Data');
         return redirect('/master-port/')->with('success', 'Success Delete Data');
       }else{
         Session::flash('error','Failed Delete Data');
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
