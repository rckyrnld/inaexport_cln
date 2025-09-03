<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use App\buying_and_inqueri;
use Lang;
use Mail;
use Carbon\Carbon;

class HistoryFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
        changeStatusInquiry();
    }

    public function index()
    {
        if (Auth::guard('eksmp')->user()) {

            $pageTitle = "History Transaction | Inaexport";
            $topMenu = "";
            // die;
            $id_user = Auth::guard('eksmp')->user()->id;
            // $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request  where id_pembuat='".$id_user."' and deleted_at ISNULL order by id desc ");
            
            return view('frontend.history', compact('pageTitle', 'topMenu'));
        } else {
            return redirect('/');
        }
    }

    public function data_inquiry()
    {
        $loc = app()->getLocale();
        $lct = "";
        if ($loc == "ch") {
            $lct = "chn";
        } elseif ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }
        // dd($lct);
        $id_user = Auth::guard('eksmp')->user()->id;
        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            //->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.prodname_en, csc_product_single.prodname_in, csc_product_single.prodname_chn, csc_product_single.id_itdp_company_user, csc_product_single.image_1')
            ->select('csc_inquiry_br.*', 'csc_product_single.id as id_product', 'csc_product_single.prodname_en', 'csc_product_single.prodname_in', 'csc_product_single.prodname_chn', 'csc_product_single.id_itdp_company_user', 'csc_product_single.image_1', DB::raw("case when csc_inquiry_br.created_at - now() < INTERVAL '0' then -(csc_inquiry_br.created_at - now())else csc_inquiry_br.created_at - now() end as abs_beda_tanggal"))
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            //->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->orderby('abs_beda_tanggal')
            ->get();
        // dd($user);

        return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('category', function ($mjl) use ($lct) {
                $category = "-";
                $catbhs = "nama_kategori_" . $lct;
                if ($mjl->id_csc_prod_cat != NULL) {
                    if ($mjl->id_csc_prod_cat_level1 != NULL) {
                        if ($mjl->id_csc_prod_cat_level2 != NULL) {
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level2)->first();
                            $category = $catprod->$catbhs;
                        } else {
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level1)->first();
                            $category = $catprod->$catbhs;
                        }
                    } else {
                        $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat)->first();
                        $category = $catprod->$catbhs;
                    }
                }
                return $category;
            })
            ->addColumn('prodname', function ($mjl) use ($lct) {
                $img1 = "image/noimage.jpg";
                if ($mjl->image_1 != NULL) {
                    $imge1 = 'uploads/Eksportir_Product/Image/' . $mjl->id_product . '/' . $mjl->image_1;
                    if (file_exists($imge1)) {
                        $img1 = 'uploads/Eksportir_Product/Image/' . $mjl->id_product . '/' . $mjl->image_1;
                    }
                }
                $imgnya = '<a href="' . url('/front_end/product/') . '/' . $mjl->id_product . '"><img src="' . url('/') . '/' . $img1 . '" alt="" class="myImg" /></a>';
                $prodname = "-";
                $prodbhs = "prodname_" . $lct;
                if ($mjl->$prodbhs != NULL) {
                    $prodname = $mjl->$prodbhs;
                }

                return '<div align="left">' . $prodname . '<br>' . $imgnya . '</div>';
            })
            ->addColumn('exportir', function ($mjl) use ($lct) {
                $exp = "-";
                if ($mjl->id_itdp_company_user != NULL) {
                    $exp = getCompanyName($mjl->id_itdp_company_user);
                }

                return $exp;
            })
            ->addColumn('notrack', function ($mjl) use ($lct) {
                $notracking = "-";
                return $notracking;
            })
            ->addColumn('origin', function ($mjl) use ($lct) {
                $org = "Inquiry";
                return $org;
            })
            ->addColumn('date', function ($mjl) use ($lct) {
                $datenya = "-";
                if ($mjl->date != NULL) {
                    $datenya = date('d/m/Y', strtotime($mjl->date));
                }

                return $datenya;
            })
            ->addColumn('kos', function ($mjl) use ($lct) {
                $kosnya = "-";
                $kosbhs = "jenis_perihal_" . $lct;
                if ($mjl->$kosbhs != NULL) {
                    $kosnya = $mjl->$kosbhs;
                }

                return $kosnya;
            })
            ->addColumn('subject', function ($mjl) use ($lct) {
                $subject = "-";
                $subhs = "subyek_" . $lct;
                if ($mjl->$subhs != NULL) {
                    $subject = $mjl->$subhs;
                }

                return $subject;
            })
            ->addColumn('msg', function ($mjl) use ($lct) {
                $msgnya = "-";
                $msgbhs = "messages_" . $lct;
                if ($mjl->$msgbhs != NULL) {
                    $num_char = 70;
                    $text = $mjl->$msgbhs;
                    if (strlen($text) > 70) {
                        $cut_text = substr($text, 0, $num_char);
                        if ($text[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                            $cut_text = substr($text, 0, $new_pos);
                        }
                        $msgnya = $cut_text . '...';
                    } else {
                        $msgnya = $text;
                    }
                }

                return $msgnya;
            })
            ->addColumn('status', function ($mjl) use ($lct) {
                $statnya = "-";
                if ($mjl->status != NULL) {
                    if ($mjl->status == 0) {
                        $stat = 1;
                    } else {
                        $stat = $mjl->status;
                    }
                    $statnya = Lang::get('inquiry.stat' . $stat);
                }

                return $statnya;
            })
            ->addColumn('action', function ($mjl) use ($lct, $id_user) {
                if ($mjl->status == 0) {
                    return '
                        <center>
                        <a href="' . url('/front_end/ver_inquiry') . '/' . $mjl->id . '" class="btn btn-sm btn-success" style="font-size: 12.5px;" title="' . Lang::get('button-name.verified') . '"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                        </center>';
                } else if ($mjl->status == 1) {
                    return '
                        <center>
                        <button type="button" class="btn btn-sm btn-danger" style="font-size: 12.5px;">' . Lang::get('button-name.noact') . '</button>
                        </center>';
                } else if ($mjl->status == 2) {
                    return '
                        <center>
                        <a href="' . url('/front_end/chat_inquiry') . '/' . $mjl->id . '" class="btn btn-sm btn-warning" style="color: white; font-size: 12.5px;" title="' . Lang::get('button-name.chat') . ' "><i class="fa fa-comments-o" aria-hidden="true"></i><span class="badge badge-danger">' . $this->getCountChat($mjl->id, $id_user) . '</span></a>
                        </center>';
                } else if ($mjl->status == 3 || $mjl->status == 4 || $mjl->status == 5) {
                    return '
                        <center>
                        <div class="btn-group">
                        <a href="' . url('/front_end/view_inquiry') . '/' . $mjl->id . '" class="btn btn-sm btn-info" style="font-size: 12.5px;" title="' . Lang::get('button-name.view') . '"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="' . url('/front_end/chat_inquiry') . '/' . $mjl->id . '" class="btn btn-sm btn-warning" style="color: white; font-size: 12.5px;" title="' . Lang::get('button-name.chat') . '"><i class="fa fa-comments-o" aria-hidden="true"></i></a>
                        </div>
                        </center>';
                } else {
                    return '
                        <center>
                        <button type="button" class="btn btn-sm btn-danger" style="font-size: 12.5px;">' . Lang::get('button-name.noact') . '</button>
                        </center>';
                }
            })
            ->rawColumns(['action', 'msg', 'prodname'])
            ->make(true);
    }

    function getCountChat($id, $receiver)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function data_ticketing()
    {
        $loc = app()->getLocale();
        $lct = "";
        if ($loc == "ch") {
            $lct = "chn";
        } elseif ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }
        $id_user = Auth::guard('eksmp')->user()->id;
        $type = Auth::guard('eksmp')->user()->type;
        $tick = TicketingSupportModel::from('ticketing_support as ts')
            ->where('ts.id_pembuat', $id_user)
            ->orderBy('ts.created_at', 'DESC')
            ->get();

        return \Yajra\DataTables\DataTables::of($tick)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'No Response';
                } else if ($data->status == 2) {
                    return 'Response';
                } else if ($data->status == 3) {
                    return 'Closed';
                }
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 1) {
                    return '
                            <center>
                            <div class="btn-group">
                                <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-info" title="' . Lang::get('button-name.view') . '">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                            </div>
                            </center>
                            ';
                } else if ($data->status == 2) {
                    return '
                          <center>
                          <div class="btn-group">
                                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-info" title=" ' . Lang::get('button-name.view') . ' ">&nbsp;<i class="fa fa-eye text-white"></i></a>
                            <a href="' . route('front.ticket.vchat', $data->id) . '" class="btn btn-warning" style="color: white;" title=" ' . Lang::get('button-name.chat') . '"><i class="fa fa-comments-o" aria-hidden="true"></i></a>
                          </div>
                          </center>
                          ';
                } else if ($data->status == 3) {
                    return '
                          <center>
                          <div class="btn-group">
                                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-info" title="' . Lang::get('button-name.view') . '">&nbsp;<i class="fa fa-eye text-white"></i>  </a>
                            <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('front.ticket.delete', $data->id) . '" class="btn btn-danger" title="' . Lang::get('button-name.delete') . '">&nbsp;<i class="fa fa-trash text-white"></i></a>
                          </div>
                          </center>
                          ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function data_br()
    {
        $loc = app()->getLocale();
        $lct = "";
        if ($loc == "ch") {
            $lct = "chn";
        } elseif ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }
        $id_user = Auth::guard('eksmp')->user()->id;
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request  where id_pembuat='" . $id_user . "' and deleted_at ISNULL order by id desc ");


        return DataTables::of($buy)
            ->addColumn('col1', function ($buy) {
                return $buy->subyek;
            })
            ->addColumn('col2', function ($buy) {
                $cr = explode(',', $buy->id_csc_prod);
                $hitung = count($cr);
                $semuacat = "";
                for ($a = 0; $a < ($hitung - 1); $a++) {
                    $id = (is_numeric($cr[$a])) ? $cr[$a] : 0;
                    $namaprod = DB::select("select * from csc_product where id='" . $id . "' ");
                    if (count($namaprod) != 0) {
                        foreach ($namaprod as $prod) {
                            $napro = $prod->nama_kategori_en;
                        }
                        $semuacat = $semuacat . "- " . $napro . "<br>";
                    }
                }
                return $semuacat;
            })
            ->addColumn('col3', function ($buy) {
                return $buy->date;
            })
            ->addColumn('col4', function ($buy) {
                if ($buy->valid == 0) {
                    return 'Selesai';
                } else {
                    return 'Valid ' . $buy->valid . " days";
                }
            })
            ->addColumn('col5', function ($buy) {
                if ($buy->deal == null || $buy->deal == 0 || empty($buy->deal)) {
                    return "Negosiation";
                } else {
                    return "Deal";
                }
            })


            ->addColumn('col7', function ($buy) {

                if ($buy->status == 0 || $buy->status == null) {
                    // return '<center>
					// <a title="Broadcast" onclick="xy(' . $buy->id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-bullhorn"></i></font></a>
					// <a title="Detail" href="' . url('br_importir_detail/' . $buy->id) . '" class="btn btn-info"><i class="fa fa-pencil"></i></a>
					// <a title="Delete" href="' . url('br_importir_dele/' . $buy->id) . '" class="btn btn-danger"><i class="fa fa-trash"></i></a>
					// </center>';
                    return '<center>
					<a title="Detail" href="' . url('br_importir_detail/' . $buy->id) . '" class="btn btn-info"><i class="fa fa-pencil"></i></a>
					<a title="Delete" href="' . url('br_importir_dele/' . $buy->id) . '" class="btn btn-danger"><i class="fa fa-trash"></i></a>
					</center>';
                } else if ($buy->status == 1) {
                    return '<center><a title="Detail" href="' . url('br_importir_lc/' . $buy->id) . '" class="btn btn-info"><i class="fa fa-comments"></i></a></center>';
                } else if ($buy->status == 4) {
                    return '<center><a title="Detail" href="' . url('br_importir_lc/' . $buy->id) . '" class="btn btn-info"><i class="fa fa-comments"></i></a></center>';
                }

                /*if($pesan->status_a == 1 || $pesan->status_a == 2){ 
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}else{
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success"><i class="fa fa-check text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning"><i class="fa fa-key text-white"></i></a>
				';
				} */
            })
            ->rawColumns(['col7', 'col4', 'col5', 'col2'])
            ->make(true);
    }

    public function data_br_new()
    {
        $loc = app()->getLocale();
        $lct = "";
        if ($loc == "ch") {
            $lct = "chn";
        } elseif ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }
        $id_user = Auth::guard('eksmp')->user()->id;
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY date DESC) AS Row, * from csc_buying_request  where id_pembuat='" . $id_user . "' and deleted_at ISNULL order by date DESC");
        $data = buying_and_inqueri::where('id_pembuat', $id_user)->orderBy('date', 'DESC')->get();
        // $data = DB::table('csc_buying_request')->where('id_pembuat', $id_user)->orderBy('date', 'DESC')->get();

        // dd($data);

        return DataTables::of($data)
            ->addColumn('col1', function ($data) {
                return $data->subyek;
            })
            //     ->addColumn('type', function ($data) {
            //         if ($data->tipe == "br") {
            //             return "Buying Request";

            //         } else {
            //             return "Inquery";
            //         }

            //         return $data->subyek;
            //    })
            // ->addColumn('col2', function ($data) {
            // 	$cr = explode(',',$data->id_csc_prod);
            // 	$hitung = count($cr);
            // 	$semuacat = "";
            // 	for($a = 0; $a <a ($hitung - 1); $a++){
            // 		$namaprod = (is_numeric($cr[$a])) ? DB::select("select * from csc_product where id='".$cr[$a]."' ") : [];
            // 		if(count($namaprod) > 0){
            // 		foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
            // 		$semuacat = $semuacat."- ".$napro."<br>";
            // 		}
            // 	}
            // 	return $semuacat;
            // })
            // ->addColumn('col3', function ($data) {
            // 	 return $data->date;
            // })
            ->addColumn('col4', function ($data) {
                if ($data->valid == 0) {
                    return 'Selesai';
                } else {
                    $now = Carbon::now()->startOfDay();
                    $compare = Carbon::parse($data->date)->startOfDay()->addDays($data->valid);
                    // dd($d->id,Carbon::parse($d->date)->startOfDay());
                    if ($compare->gt($now)) {
                        $d = (int) $compare->diffInDays($now) . ' Day(s)';
                    } else {
                        $d = 'Expired';
                    }
                    return $d;
                }
            })
            ->addColumn('col5', function ($data) {
                if ($data->deal == null || $data->deal == 0 || empty($data->deal)) {
                    return "Negosiation";
                } else {
                    return "Deal";
                }
            })
            ->addColumn('col6', function ($data) {
                $return_value = '';

                if(isset($data->id_csc_buying_request)) {
                    $buying_requests = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb,a.id as id_user from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='" . $data->id_csc_buying_request . "'order by date DESC");
                    $lb = '';
                    if (count($buying_requests) > 0) {
                        $lb .= '<br>';
                        foreach ($buying_requests as $br) {
                            $status_join = '';
                            if ($br->status_join == null) {
                                $status_join = 'pending';
                            } elseif ($br->status_join == '1') {
                                $status_join = 'Waiting for your repply';
                            } elseif ($br->status_join == '2') {
                                $status_join = 'Negosiation';
                            } elseif ($br->status_join == '4') {
                                $status_join = 'Deal';
                            } else {
                                $status_join = '-';
                            }
                            $return_value .= "<a class='link-company' href=" . url('front_end/list_perusahaan/view', $br->id_user . "-" . $br->company) . " target='_blank'>" . $br->company . ' (' . $status_join . ')</a>' . $lb;
                        }
                    }
                    else{
                        $return_value .= "Haven't found a supplier yet";
                    }
                }
                
                return $return_value;
            })
            ->addColumn('col7', function ($data) {
                if ($data->tipe == "br") {
                    if ($data->status == 0 || $data->status == null) {
                        // return '<center>
                        // <a title="Broadcast" onclick="xy(' . $data->id_csc_buying_request . ')" data-toggle="modal" data-target="#myModal" class="btn btn-warning tombol_aksi" style="font-size:15px;display:none; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fa fa-bullhorn"></i></font></a>
                        // <a title="Detail" href="' . url('br_importir_detail/' . $data->id_csc_buying_request) . '" class="btn btn-info tombol_aksi" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fas fa-pencil-alt"></i></a>
                        // <a title="Delete" href="' . url('br_importir_dele/' . $data->id_csc_buying_request) . '" class="btn btn-danger tombol_aksi" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fa fa-trash"></i></a>
                        // </center>';
                        return '<center>
                        <a title="Detail" href="' . url('br_importir_detail/' . $data->id_csc_buying_request) . '" class="btn btn-info tombol_aksi" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fas fa-pencil-alt"></i></a>
                        <a title="Delete" href="' . url('br_importir_dele/' . $data->id_csc_buying_request) . '" class="btn btn-danger tombol_aksi" onclick="deleteAct(this); return false" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fa fa-trash"></i></a>
                        </center>';
                    } else if ($data->status == 1) {
                        return '<center><a title="Detail" href="' . url('br_importir_lc/' . $data->id_csc_buying_request) . '" class="btn btn-info tombol_aksi" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fa fa-comments"></i></a></center>';
                    } else if ($data->status == 4) {
                        return '<center><a title="Detail" href="' . url('br_importir_lc/' . $data->id_csc_buying_request) . '" class="btn btn-info tombol_aksi" style="font-size:15px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;"><font color="white"><i class="fa fa-comments"></i></a></center>';
                    }
                } else {
                    if ($data->status == 0) {
                        return '
                            <center>
                            <a href="' . url('/front_end/ver_inquiry') . '/' . $data->id_csc_inquiry_br . '" class="btn btn-success" style="font-size: 12.5px;" title="' . Lang::get('button-name.verified') . '"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                            </center>';
                    } else if ($data->status == 1) {
                        return '
                            <center>
                            <button type="button" class="btn btn-danger" style="font-size: 12.5px;">' . Lang::get('button-name.noact') . '</button>
                            </center>';
                    } else if ($data->status == 2) {
                        return '
                            <center>
                            <a href="' . url('/front_end/chat_inquiry') . '/' . $data->id_csc_inquiry_br . '" class="btn btn-warning" style="color: white; font-size:12.5px; padding-bottom: 0px; padding-top: 0px; padding-left: 4px; padding-right: 4px;" title="' . Lang::get('button-name.chat') . ' "><i class="fas fa-comments" aria-hidden="true"></i><span class="badge badge-danger">' . $this->getCountChat($data->id_csc_inquiry_br, Auth::guard('eksmp')->user()->id) . '</span></a>
                            </center>';
                    } else if ($data->status == 3 || $data->status == 4 || $data->status == 5) {
                        return '
                            <center>
                            <a href="' . url('/front_end/view_inquiry') . '/' . $data->id_csc_inquiry_br . '" class="btn btn-info" style="font-size: 12.5px;" title="' . Lang::get('button-name.view') . '"><font color="white"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="' . url('/front_end/chat_inquiry') . '/' . $data->id_csc_inquiry_br . '" class="btn btn-warning" style="color: white; font-size: 12.5px;" title="' . Lang::get('button-name.chat') . '"><font color="white"><i class="fas fa-comments" aria-hidden="true"></i></a>
                            </center>';
                    } else {
                        return '
                            <center>
                            <button type="button" class="btn btn-danger" style="font-size: 12.5px;">' . Lang::get('button-name.noact') . '</button>
                            </center>';
                    }
                }
            })
            ->rawColumns(['col7', 'col4', 'col5', 'col1', 'type', 'col6'])
            ->addIndexColumn()
            ->make(true);
    }



    public function create($id)
    {
        //
    }

    public function store($id, Request $request)
    {
        //
    }

    public function edit()
    {
        # code...
    }

    public function update()
    {
        # code...
    }
}
