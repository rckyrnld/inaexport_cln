<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Carbon\Carbon;

class ResearchCornerController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:eksmp');
    }

    public function index()
    {
        if (Auth::guard('eksmp')->user() != '' && Auth::guard('eksmp')->user()->id_role == 2) {
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

            $kategori = DB::table('csc_product_single')
                // ->where('id_itdp_profil_eks', $id_profil)
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
                ->select('b.*', 'a.created_at', 'a.id_research_corner')
                ->get();

            $array_res = array();
            $array_exist = array();
            $array_end = array();
            //untuk masukin data $research ke array_res
            foreach ($research as $rese) {
                array_push($array_res, $rese->id);
            }

            //untuk ngepush data $research yang udah ada di $array_res ke array_research
            foreach ($array_res as $next) {
                if (!in_array($next, $array_research)) {
                    array_push($array_research, $next);
                }
            }

            //untuk ngecek yang ada ditable csc_research_corner apa aja. mencegah nampilin research corner / market research yang udah dihapus
            $exist = DB::table('csc_research_corner')->where('exum', '!=', null)->where('id', '!=', null)->get();
            foreach ($exist as $exi) {
                array_push($array_exist, $exi->id);
            }

            //diseleksi disini, supaya research corner yang udah dihapus, gak ada di array lagi
            foreach ($array_research as $key) {
                if (!in_array($key, $array_exist)) {
                } else {
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

                    $title = DB::table('csc_research_corner')->where('id', $value)->select('title_en')->first();
                    if ($title == null) {
                    } else {
                        //				        dd($title);
                        return '<div align="left">' . $title->title_en . '</div>';
                    }
                })
                ->addColumn('country', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id', $value)->select('id_mst_country')->first();
                    if ($title == null) {
                    } else {
                        $data = DB::table('mst_country')->where('id', $title->id_mst_country)->first();
                        return $data->country;
                    }
                })
                ->addColumn('type', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id', $value)->select('id_csc_research_type')->first();
                    if ($title == null) {
                    } else {
                        $data = DB::table('csc_research_type')->where('id', $title->id_csc_research_type)->first();
                        return $data->nama_en;
                    }
                })
                ->addColumn('date', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id', $value)->select('publish_date')->first();
                    if ($title == null) {
                    } else {
                        // return getTanggalIndo(date('Y-m-d', strtotime($title->publish_date))) . ' ( ' . date('H:i', strtotime($title->publish_date)) . ' )';
                        return Carbon::parse($title->publish_date)->format('d M Y');
                    }
                })
                ->addColumn('action', function ($value) {
                    $title = DB::table('csc_research_corner')->where('id', $value)->select('id', 'exum')->first();
                    if ($title == null) {
                    } else {
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
                ->rawColumns(['action', 'title_en'])
                ->make(true);
        } else {
            return redirect('/home');
        }
    }

    public function download(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (Auth::user() != null && in_array(Auth::user()->id_group, [1, 8])) {
            $rc = DB::table('csc_research_corner')->where('id', $req->id)->first();
            $url = url('/') . '/uploads/Market Research/File/' . $rc->exum;

            echo json_encode($url);
        } elseif (Auth::guard('eksmp')->user() != null && Auth::guard('eksmp')->user()->id_role == 2) {
            $id_profil = Auth::guard('eksmp')->user()->id_profil;
            $id_user = Auth::guard('eksmp')->user()->id;
            $date = date('Y-m-d H:i:s');
            $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $req->id)->first();

            $rc = DB::table('csc_research_corner')->where('id', $req->id)->first();
            $url = url('/') . '/uploads/Market Research/File/' . $rc->exum;

            $arr = explode(',', $rc->category);
            $cat = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : 0;
            $lvl1 = (isset($arr[1]) && $arr[1] != '') ? $arr[1] : 0;
            $lvl2 = (isset($arr[2]) && $arr[2] != '') ? $arr[2] : 0;
         

            $vibe = DB::table('csc_product_single')
                ->where('status', '2')
                ->where('id_itdp_company_user', $id_user)
                ->where(function ($q) use ($cat) {
                    return $q->where('id_csc_product', $cat);
                })
                ->where(function ($q) use ($lvl1) {
                    return $q->where('id_csc_product_level1', $lvl1);
                })
                ->where(function ($q) use ($lvl2) {
                    return $q->where('id_csc_product_level2', $lvl2);
                })
                ->first();

            if ($checking && isset($vibe)) {
                $hasil = 'positif';
                echo json_encode($url);
            } elseif (isset($vibe)) {
                $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
                if ($id) {
                    $id = $id->id + 1;
                } else {
                    $id = 1;
                }
                DB::table('csc_download_research_corner')->insert([
                    'id' => $id,
                    'id_itdp_profil_eks' => $id_profil,
                    'id_research_corner' => $req->id,
                    'waktu' => $date
                ]);

                $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
                if ($notif) {
                    DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
                        'status_baca' => 1
                    ]);
                }

                $before = DB::table('csc_research_corner')->where('id', $req->id)->first();
                DB::table('csc_research_corner')->where('id', $req->id)->update([
                    'download' => $before->download + 1
                ]);

                $hasil = 'nihil';
                echo json_encode($url);
            } else {
                echo json_encode('prohibited');
            }
        } else {
            echo json_encode('prohibited');
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
