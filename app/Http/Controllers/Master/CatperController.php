<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatperController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $pageTitle = 'Master Representative Category';
        return view('master.cat_perwakilan.index',compact('pageTitle'));
    }


    public function create()
    {
        $pageTitle = 'Add Representative Category';
        $page = 'create';
        return view('master.cat_perwakilan.create',compact('url','pageTitle','page','province'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $insert = DB::select("
			insert into mst_catper (type,created_at) values
			('".$request->catper."','".$date."')");

        return redirect('master-catper')->with('success','Success Add Data');
    }

    public function view($id)
    {
        $pageTitle = "List Representative Category";
        $page = "view";
        $data = MasterPort::where('id', $id)->first();
        $province = MasterProvince::orderby('province_en','asc')->get();
        return view('master.cat_perwakilan.create',compact('page','data','pageTitle','province'));
    }

    public function hapus($id)
    {
        $data = DB::select("
			delete from mst_catper where id='".$id."'
			");
        return redirect('master-catper')->with('error','Success Delete Data');


    }

    public function check(Request $req){
        $checking = MasterPort::where('id', $req->kode)->first();
        echo json_encode($checking);
    }
}
