<?php

namespace App\Http\Controllers\CurrentIssue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class CurrentIssueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $pageTitle = 'Market Research';
            return view('research-corner.eksportir.index', compact('pageTitle'));
        } else {
            return redirect('/home');
        }
    }

    public function getData()
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $array_kategori = array();
            $array_research = array();
            $id_profil = Auth::guard('eksmp')->user()->id_profil;

            $kategori = DB::table('csc_product_single')->where('id_itdp_profil_eks', $id_profil)
                ->select('id_csc_product as kategori', 'id_csc_product_level1 as sub_kategori', 'id_csc_product_level2 as sub_sub_kategori')
                ->distinct('kategori', 'sub_kategori', 'sub_sub_kategori')->get();

            foreach ($kategori as $key) {
                if (!in_array($key->kategori, $array_kategori)) {
                    array_push($array_kategori, $key->kategori);
                }
                if ($key->sub_kategori != null) {
                    if (!in_array($key->sub_kategori, $array_kategori)) {
                        array_push($array_kategori, $key->sub_kategori);
                    }
                }
                if ($key->sub_sub_kategori != null) {
                    if (!in_array($key->sub_sub_kategori, $array_kategori)) {
                        array_push($array_kategori, $key->sub_sub_kategori);
                    }
                }
            }

            //untuk ambil data yang udah dia download
            $tambahan = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->get();
            foreach ($tambahan as $key) {
                if (!in_array($key->id_research_corner, $array_research)) {
                    array_push($array_research, $key->id_research_corner);
                }
            }

            //untuk ambil data yang udah dia terima lewat broadcast
            $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
                ->whereIn('a.id_categori_product', $array_kategori)
                ->orWhereIn('a.id_research_corner', $array_research)
//                ->orderby('b.publish_date', 'desc')
                ->orderby('a.created_at', 'desc')
                ->distinct('a.id_research_corner')
                ->select('b.*','a.created_at','a.id_research_corner')
                ->get();

            $array_res = array();
            $array_exist = array();
            $array_end = array();
            //untuk masukin data $research ke array_res
            foreach ($research as $rese){
                array_push($array_res, $rese->id);
            }

            //untuk ngepush data $research yang udah ada di $array_res ke array_research
            foreach ($array_res as $next){
                if (!in_array($next, $array_research)) {
                    array_push($array_research, $next);
                }
            }

            //untuk ngecek yang ada ditable csc_research_corner apa aja. mencegah nampilin research corner yang udah dihapus
            $exist = DB::table('csc_research_corner')->where('exum','!=',null)->where('id','!=',null)->get();
            foreach ($exist as $exi){
                array_push($array_exist,$exi->id);
            }

            //diseleksi disini, supaya research corner yang udah dihapus, gak ada di array lagi
            foreach ($array_research as $key) {
                if (!in_array($key, $array_exist)) {

                }else{
                    array_push($array_end, $key);
                }
            }
//            dd($array_end);

//            $research = DB::table('csc_research_corner')
//                ->whereIn('a.id_categori_product', $array_kategori)
//                ->orWhereIn('a.id_research_corner', $array_research)
////                ->orderby('b.publish_date', 'desc')
//                ->orderby('a.created_at', 'desc')
//                ->distinct('a.id_research_corner')
//                ->select('b.*','a.created_at','a.id_research_corner')
//                ->get();

            return \Yajra\DataTables\DataTables::of($array_end)
                ->addIndexColumn()
				->addColumn('title_en', function ($value) {

				    $title = DB::table('csc_research_corner')->where('id',$value)->select('title_en')->first();
				    if($title == null){

                    }else{
//				        dd($title);
                        return '<div align="left">'.$title->title_en.'</div>';
                    }

					
				  })
                ->addColumn('country', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id',$value)->select('id_mst_country')->first();
                    if($title == null){

                    }else{
                        $data = DB::table('mst_country')->where('id', $title->id_mst_country)->first();
                        return $data->country;
                    }
                })
                ->addColumn('type', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id',$value)->select('id_csc_research_type')->first();
                    if($title == null){

                    }else {
                        $data = DB::table('csc_research_type')->where('id', $title->id_csc_research_type)->first();
                        return $data->nama_en;
                    }
                })
                ->addColumn('date', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id',$value)->select('publish_date')->first();
                    if($title == null){

                    }else {
                        return getTanggalIndo(date('Y-m-d', strtotime($title->publish_date))) . ' ( ' . date('H:i', strtotime($title->publish_date)) . ' )';
                    }
                })
                ->addColumn('action', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id',$value)->select('id','exum')->first();
                    if($title == null){

                    }else {
                    $id_profil = Auth::guard('eksmp')->user()->id_profil;
                    $download = DB::table('csc_download_research_corner')
                        ->where('id_research_corner', $value)
                        ->where('id_itdp_profil_eks', $id_profil)
                        ->first();
                    if ($download) {
                        return '<center>
                      <a href="' . route("research-corner.view", $title->id) . '" style="" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                      </center>';
                    } else {
                        return '<center>
                      <a href="' . url('/') . '/uploads/Market Research/File/' . $title->exum . '" style="" onclick="cek_download(' . $title->id . ', event, this)" class="btn btn-sm btn-warning text-white" title="Download"><i class="fa fa-download"></i></a>&nbsp;&nbsp;
                      <a href="' . route("research-corner.view", $title->id) . '" style="" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                      </center>';
                    }
                    }
                })
                ->rawColumns(['action','title_en'])
                ->make(true);
        } else {
            return redirect('/home');
        }

    }

    public function download(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $id_profil = Auth::guard('eksmp')->user()->id_profil;
            $id_user = Auth::guard('eksmp')->user()->id;
            $date = date('Y-m-d H:i:s');
            $checking = DB::table('tbl_download_curris')->where('id_itdp_profil_eks', $id_profil)->where('id_curris', $req->id)->first();
            if ($checking) {
                $hasil = 'positif';
            } else {
                $id = DB::table('tbl_download_curris')->orderby('id', 'desc')->first();
                if ($id) {
                    $id = $id->id + 1;
                } else {
                    $id = 1;
                }
                DB::table('tbl_download_curris')->insert([
                    'id' => $id,
                    'id_itdp_profil_eks' => $id_profil,
                    'id_curris' => $req->id,
                    'waktu' => $date
                ]);

                $notif = DB::table('notif')->where('url_terkait', 'curris/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
                if ($notif) {
                    DB::table('notif')->where('url_terkait', 'curris/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
                        'status_baca' => 1
                    ]);
                }

                $before = DB::table('tbl_curris')->where('id', $req->id)->first();
                DB::table('tbl_curris')->where('id', $req->id)->update([
                    'download' => $before->download + 1
                ]);

                $hasil = 'nihil';
            }
            echo json_encode($hasil);
        } else {
            return redirect('/home');
        }
    }

    public function read($id)
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $id_user = Auth::guard('eksmp')->user()->id;
            $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')
                ->where('id_terkait', $id)
                ->where('untuk_id', $id_user)
                ->first();

            if ($notif) {
                DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $id)->where('untuk_id', $id_user)->update([
                    'status_baca' => 1
                ]);
            }

            $pageTitle = "Market Research";
            $data = DB::table('csc_research_corner')->where('id', $id)->first();
            return view('research-corner.eksportir.view', compact('data', 'pageTitle'));
        } else {
            return redirect('/home');
        }
    }
}
