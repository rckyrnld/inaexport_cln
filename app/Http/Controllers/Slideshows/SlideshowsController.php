<?php

namespace App\Http\Controllers\Slideshows;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class SlideshowsController extends Controller
{
	public function __construct(){

  }

  public function index(){
    $pageTitle = 'Slideshows';
    
    if(isset(Auth::user()->id)){
      if(Auth::user()->id_group == 1)
        return view('slideshows.index',compact('pageTitle'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

    public function getData()
    {
      $slideshows = DB::table('slideshows')->get();

      return \Yajra\DataTables\DataTables::of($slideshows)
          ->addIndexColumn()

          ->addColumn('judul', function($data){            
            return $data->judul;
          })

          ->addColumn('nama', function($data){       
            $nama = '';
            $nama .= '<img src="'.asset('/image/slide/'.$data->nama).'" alt="Lights" style="width:100%">';    
            return $nama;
          })
          
          ->addColumn('status', function ($data) {
            $p = '';
            if($data->status == '0'){$p = '<center><span class="btn btn-sm btn-success" style="cursor:default;"><i class="fa fa-check"></i></span></center> ';}
            return $p;
          })
        
          ->addColumn('action', function ($data) {
            $p = '<center><div class="btn-group">';
            $p .= '<a href="'.route('slideshows.view', $data->id).'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;
            <a href="'.route('slideshows.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>&nbsp;
            <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('slideshows.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete">
            <i class="fa fa-trash text-white"></i></a> ';
            return $p.'</div></center>';
          })

          ->rawColumns(['nama','action','status'])  
          ->make(true);    
    }

    

    public function store(Request $req, $param)
    {
      $send_to = '';
      if($req->send_to){
        $send_to = '0';
      } else {
        $send_to = '1';
      }
      
      $destination= 'image\slide\\';
      if($req->hasFile('file')){ 
        $file = $req->file('file');
        $nama_file = time().'_'.date('Y_m_d').'_'.$req->file('file')->getClientOriginalName();
  
        Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
      } else { $nama_file = $req->lastest_file; }

      if($param == 'Create'){
        $data = $id =  DB::table('slideshows')->insertGetId([
          'nama' => $nama_file,
          'judul' => $req->judul,
          'status' => $send_to
        ]);
      } else {
        $pecah = explode('|', $param);
        $param = $pecah[0];
        $id = $pecah[1];

        $data =  DB::table('slideshows')->where('id', $id)->update([
          'nama' => $nama_file,
          'judul' => $req->judul,
          'status' => $send_to       
        ]);
      }
     
      if($data){
         Session::flash('success','Success '.$param.'d Data');
         return redirect('/slideshows')->with('success', 'Success '.$param.'d Data!');
       }else{
         Session::flash('failed','Failed '.$param.'d Data');
         return redirect('/slideshows')->with('error', 'Failed '.$param .'d Data!');
       }
    }

    public function view($id)
    {
      $pageTitle = "Slideshows";
      $page = "view";
      $data =  DB::table('slideshows')->where('id', $id)->first();
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('slideshows.create',compact('page','data','pageTitle'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function create()
    {
      $pageTitle = 'Slideshows';
      $page = 'create';
      $url = "/slideshows/store/Create";
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('slideshows.create',compact('url','pageTitle','page'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Slideshows";
      $url = "/slideshows/store/Update|".$id;      
      $data =  DB::table('slideshows')->where('id', $id)->first();
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('slideshows.create',compact('url','data','pageTitle','page'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function destroy($id)
    {
      $data =  DB::table('slideshows')->where('id', $id)->delete();
      if($data){
         Session::flash('error','Success Deleted Data');
         return redirect('/slideshows')->with('error', 'Success Deleted Data');
       }else{
         Session::flash('error','Failed Deleted Data');
         return redirect('/slideshows')->with('error', 'Failed Deleted Data');
       }
    }
}