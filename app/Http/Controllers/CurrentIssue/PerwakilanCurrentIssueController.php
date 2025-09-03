<?php

namespace App\Http\Controllers\CurrentIssue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;
use Mail;

class PerwakilanCurrentIssueController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'Trade Update';
      if(Auth::user()->id_group == 4){
        return view('current-issue.perwakilan.index',compact('pageTitle'));
      } else {
        return redirect('/admin/curris');
      }
    }

    public function getData()
    {
      $user = Auth::user()->id;
      $currentissue = DB::table('tbl_curris')
                    ->join('mst_country', 'tbl_curris.id_mst_country', 'mst_country.id')
                    ->select('tbl_curris.id','tbl_curris.title_en','tbl_curris.publish_date','mst_country.country')
                    ->orderby('publish_date', 'desc')
                    ->where('created_by_id',$user);

      return \Yajra\DataTables\DataTables::of($currentissue)
          ->addIndexColumn()
          ->addColumn('title_en', function ($value) {
            
              return '<div align="left">'.$value->title_en.'</div>';
            
          })
		      ->addColumn('country', function ($value) {
            if($value->country){
              return '<div align="left">'.$value->country.'</div>';
            } else {
              return '<div align="left">Country Not Found</div>';
            }
          })
          // ->addColumn('download', function ($value) {
          //   return getDataDownload($value->id);
          // })
          ->addColumn('date', function ($data) {
            return date('d F Y', strtotime($data->publish_date));
          })
          ->addColumn('action', function ($data) {
            // $research = DB::table('csc_broadcast_research_corner')
            //   ->where('id_research_corner', $data->id)
            //   ->first();
            //   if($research){
                return '<center>
                  <a href="'.route("perwakilan.curris.edit", $data->id).'" id="button" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>&nbsp;&nbsp;
                  <a href="'.route("perwakilan.curris.view", $data->id).'" id="button" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white" ></i></a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Are You Sure ?\')" href="'.route("admin.curris.destroy", $data->id).'" id="button" class="btn btn-sm btn-danger" title="Delete">&nbsp<i class="fa fa-trash text-white"></i></a>
                  </center>';
              // } else {
              //   return '<center>
              //     <button onclick="broadcast(\''.$data->title_en.'||'.$data->id.'\')" id="button" class="btn btn-sm btn-warning text-white" title="Broadcast"><i class="fa fa-bullhorn text-white"></i></button> 
              //     <a href="'.route("admin.curris.edit", $data->id).'" id="button" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>
              //     <a onclick="return confirm(\'Are You Sure ?\')" href="'.route("admin.curris.destroy", $data->id).'" id="button" class="btn btn-sm btn-danger" title="Delete">&nbsp<i class="fa fa-trash text-white"></i></a>
              //     </center>';
              // }
          })
          ->rawColumns(['action','title_en','country'])
          ->make(true);
    }

    // public function getDataDownload($id)
    // {
    //   $download = DB::table('csc_download_research_corner')
    //   ->orderby('waktu', 'asc')->where('id_research_corner', $id)->get();

    //   return \Yajra\DataTables\DataTables::of($download)
    //       ->addIndexColumn()
    //       ->addColumn('company', function ($var) {
    //         $data = DB::table('itdp_profil_eks')->where('id', $var->id_itdp_profil_eks)->first();
    //         if($data){
    //           return '<div align="left">'.$data->company.'</div>';
    //         } else {
    //           return '<div align="left">Company '.$var->id_itdp_profil_eks.' Not Found</div>';
    //         }
    //       })
    //       ->addColumn('download_date', function ($data) {
    //         return date('d F Y', strtotime($data->waktu)).' ( '.date('H:i', strtotime($data->waktu)).' )';
    //       })
    //       ->rawColumns(['company'])
    //       ->make(true);
    // }

    public function getDataDownload($id)
    {
      $download = DB::table('tbl_download_curris')
      ->join('itdp_profil_eks','itdp_profil_eks.id','tbl_download_curris.id_itdp_profil_eks')
      ->orderby('tbl_download_curris.waktu', 'asc')
      ->select('tbl_download_curris.id','itdp_profil_eks.company','tbl_download_curris.waktu','tbl_download_curris.id_itdp_profil_eks')
      ->where('tbl_download_curris.id_curris', $id)
      ->get();

      return \Yajra\DataTables\DataTables::of($download)
          ->addIndexColumn()
          ->addColumn('company', function ($data) {
            // $data = DB::table('itdp_profil_eks')->where('id', $var->id_itdp_profil_eks)->first();
            if($data->company){
              return '<div align="left">'.$data->company.'</div>';
            } else {
              return '<div align="left">Profile '.$data->id_itdp_profil_eks.' Not Found</div>';
            }
          })
          ->addColumn('download_date', function ($data) {
            return date('d F Y', strtotime($data->waktu)).' ( '.date('H:i', strtotime($data->waktu)).' )';
          })
		      ->rawColumns(['company'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'Trade Update';
      $page = 'create';
      $url = "/perwakilan/curris/store/Create";
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      $type = 'Create';
      if(Auth::user()->id_group == 4){
        return view('current-issue.perwakilan.create',compact('url','pageTitle','page','country', 'type'));
      } else {
        return redirect('/admin/curris');
      }
    }

    public function store(Request $req, $param)
    {
      // dd(Auth::user());
      $id_user = Auth::user()->id;
      $id_group = Auth::user()->id_group;
      $id = DB::table('tbl_curris')->orderby('id','desc')->first();
      if($id){ $id = $id->id+1; } else { $id = 1; }
            
      $destination= 'uploads\Current Issue\File\\';
      if($req->hasFile('file')){ 
        $file = $req->file('file');
        $nama_file = time().'_CurrentIssue '.$req->title_en.'_'.$req->file('file')->getClientOriginalName();
        Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
      } else { $nama_file = $req->lastest_file; }
      
      if($param == 'Create'){
        $data = DB::table('tbl_curris')->insert([
          'id' => $id,
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_mst_country' => $req->country,
          'publish_date' => $req->date,
          'exum' => $nama_file,
          'download' => 0,
          'created_by_role' => $id_group,
          'created_by_id' => $id_user
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = DB::table('tbl_curris')->where('id', $pecah[1])->update([
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_mst_country' => $req->country,
          'publish_date' => $req->date,
          'exum' => $nama_file,
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('perwakilan/curris/')->with('success', 'Success '.$param.' Data!');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('perwakilan/curris/')->with('error', 'Failed '.$param .' Data!');
       }
    }


    public function broadcast(Request $req)
    {
      date_default_timezone_set('Asia/Jakarta');
      $id_user = Auth::user()->id;
      $array = array();
      $date = date('Y-m-d H:i:s');

      for($i = 0; $i<count($req->categori); $i++){
        $var = $req->categori[$i];
        $id = DB::table('csc_broadcast_research_corner')->orderby('id','desc')->first();
        if($id){ $id = $id->id+1; } else { $id = 1; }

        $data = DB::table('csc_broadcast_research_corner')->insert([
          'id' => $id,
          'id_research_corner' => $req->research,
          'id_categori_product' => $req->categori[$i],
          'created_at' => $date
        ]);

        $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
              ->where(function ($query) use ($var) {
                      $query->where('id_csc_product', $var)
                            ->orWhere('id_csc_product_level1', $var)
                            ->orWhere('id_csc_product_level2', $var);
                  })
              ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
        foreach ($perusahaan as $key) {
          if (!in_array($key->id_itdp_company_user, $array)){
            array_push($array, $key->id_itdp_company_user);
          }
        }
      }
      sort($array);
      for ($user=0; $user < count($array) ; $user++) { 
        $pengirim = DB::table('itdp_admin_users')->where('id',$id_user)->first();
        $account_penerima = DB::table('itdp_company_users')->where('id',$array[$user])->first();
        if($account_penerima){
          $profile_penerima = DB::table('itdp_profil_eks')->where('id',$account_penerima->id_profil)->first();
          if($profile_penerima){
            $notif = DB::table('notif')->insert([
                'dari_nama' => $pengirim->name,
                'dari_id' => $pengirim->id,
                'untuk_nama' => $profile_penerima->company,
                'untuk_id' => $array[$user],
                'keterangan' => 'New Broadcast from '.$pengirim->name.' with Title  "'.$req->title_en.'"',
                'url_terkait' => 'research-corner/read',
                'status_baca' => 0,
                'waktu' => $date,
                'id_terkait' => $req->research,
                'to_role' => '2',
            ]);

              $data = [
                  'email' => $account_penerima->email,
                  'username' => $profile_penerima->company,
                  'bu' => $profile_penerima->badanusaha,
                  'judul' => $req->title_en,
              ];

              Mail::send('UM.user.sendnotifrceks', $data, function ($mail) use ($data) {
                  $mail->to($data['email'], $data['username']);
                  $mail->subject('Dokumen Baru di Market Research');
              });

          }
        }
      }

      if($data){
         Session::flash('success','Success Broadcast Data');
         return redirect('perwakilan/research-corner/');
       }else{
         Session::flash('error','Failed Broadcast Data');
         return redirect('perwakilan/research-corner/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Trade Update";
      $page = "view";
      $type = "";
      $data = DB::table('tbl_curris')->where('id', $id)->first();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      if(Auth::user()->id_group == 4){
        return view('current-issue.perwakilan.create',compact('page','data','pageTitle','country','type'));
      } else {
        return redirect('/admin/curris');
      }
    }


    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Trade Update";
      $url = "/perwakilan/curris/store/Update_".$id;
      $data = DB::table('tbl_curris')->where('id', $id)->first();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      if(Auth::user()->id_group == 4){
        return view('current-issue.perwakilan.create',compact('url','data','pageTitle','page','country'));
      } else {
        return redirect('/admin/curris');
      }
    }

    public function destroy($id)
    {
      $data = DB::table('tbl_curris')->where('id', $id)->delete();
      if($data){
         Session::flash('error','Success Delete Data');
         return redirect('perwakilan/curris/');
       }else{
         Session::flash('error','Failed Delete Data');
         return redirect('perwakilan/curris/');
       }
    }
}
