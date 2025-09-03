<?php

namespace App\Http\Controllers\Api\User;

use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Yajra\DataTables\Facades\DataTables;
use Mail;


class BuyingreqController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function impmasukbr()
    {
        $kategoriprod = DB::table('csc_product')
            ->get();
        date_default_timezone_set('Asia/Jakarta');
        $quantity = array(
            "Each",
            "Foot",
            "Gallons",
            "Kilograms",
            "Liters",
            "Packs",
            "Pairs",
            "Pieces",
            "Reams",
            "Rods",
            "Rolls",
            "Sets",
            "Sheets",
            "Square Meters",
            "Tons",
            "Unit",
            "令",
            "件",
            "加仑",
            "包",
            "千克",
            "升",
            "单位",
            "卷",
            "吨",
            "套",
            "对",
            "平方米",
            "张",
            "根",
            "每个",
            "英尺",
            "集装箱",
        );
        $data = array();
        array_push($data, array(
            'kategori' => $kategoriprod,
            'quantity' => $quantity
        ));
//        dd($kategoriprod);
        if (count($data) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = $cars;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function br_importir_save(Request $request)
    {
//        dd($request);
        $kumpulcat = "";
        date_default_timezone_set('Asia/Jakarta');
        $g = count($request->category);
        for ($a = 0; $a < $g; $a++) {
            $kumpulcat = $kumpulcat . $request->category[$a] . ",";
        }
//        dd($kumpulcat);
//        $h = explode(",",$kumpulcat);

        if (empty($request->file('doc'))) {
            $file = "";
        } else {
            $file = $request->file('doc')->getClientOriginalName();
            $destinationPath = public_path() . "/uploads/buy_request";
            $request->file('doc')->move($destinationPath, $file);
        }
        $insert = DB::table('csc_buying_request')->insert([
            'subyek' => $request->subyek,
            'valid' => $request->valid,
            'id_mst_country' => $request->country,
            'city' => $request->city,
//            'id_csc_prod_cat' => $h[0],
            'id_csc_prod_cat_level1' => '0',
            'id_csc_prod_cat_level2' => '0',
            'shipping' => $request->ship,
            'spec' => $request->spec,
            'files' => $file,
            'eo' => $request->eo,
            'neo' => $request->neo,
            'tp' => $request->tp,
            'ntp' => $request->ntp,
            'by_role' => '3',
            'id_pembuat' => $request->id_user,
            'date' => date('Y-m-d H:i:s'),
            'id_csc_prod' => $kumpulcat,
        ]);
        if ($insert) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }

    public function impdata_br(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request  
                           where id_pembuat='" . $id_user . "' order by id desc ");

//        for($i = 0; $i < count($buy);  $i++){
//
//        }
//
//        foreach ($buy as $datanya) {
//            $coba = explode(",", $datanya->id_csc_prod);
//        }

        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            $brjoin = DB::table('csc_buying_request_join')
                ->where('id_br', '=', $buy[$i]->id)
                ->where('status_join', '!=', 0)
                ->get();
//            dd($brjoin);
            if ($brjoin == null) {
                $countJoin = 0;
            } else {
                $countJoin = count($brjoin);
            }
            $jsonResult[$i]["count_join"] = $countJoin;
            $jsonResult[$i]["row"] = $buy[$i]->row;
            $jsonResult[$i]["id"] = $buy[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $buy[$i]->id_mst_country;
            $jsonResult[$i]["id_csc_prod_cat"] = $buy[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $buy[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $buy[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $buy[$i]->jenis_perihal_en;
            $jsonResult[$i]["subyek"] = $buy[$i]->subyek;
            $jsonResult[$i]["message"] = $buy[$i]->message;
            $jsonResult[$i]["files"] = $buy[$i]->files;
            $jsonResult[$i]["message_answer"] = $buy[$i]->message_answer;
            $jsonResult[$i]["file_answer"] = $buy[$i]->file_answer;
            $jsonResult[$i]["date"] = $buy[$i]->date;
            $jsonResult[$i]["st_approve"] = $buy[$i]->st_approve;
            $jsonResult[$i]["date_approve"] = $buy[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $buy[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $buy[$i]->by_role;
            $jsonResult[$i]["id_pembuat"] = $buy[$i]->id_pembuat;
            $jsonResult[$i]["city"] = $buy[$i]->city;
            $jsonResult[$i]["shipping"] = $buy[$i]->shipping;
            $jsonResult[$i]["spec"] = $buy[$i]->spec;
            $jsonResult[$i]["eo"] = $buy[$i]->eo;
            $jsonResult[$i]["neo"] = $buy[$i]->neo;
            $jsonResult[$i]["tp"] = $buy[$i]->tp;
            $jsonResult[$i]["ntp"] = $buy[$i]->ntp;
            $jsonResult[$i]["valid"] = $buy[$i]->valid;
            if ($buy[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'Selesai';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $buy[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $buy[$i]->status;
            if ($buy[$i]->status == null || $buy[$i]->status == 0 || empty($buy[$i]->status) || $buy[$i]->status == 1) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else if ($buy[$i]->status == 4) {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $buy[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $buy[$i]->jenis_perihal_chn;
            $jsonResult[$i]["message_perihal_en"] = $buy[$i]->message_perihal_en;
            $jsonResult[$i]["message_perihal_in"] = $buy[$i]->message_perihal_in;
            $jsonResult[$i]["message_perihal_chn"] = $buy[$i]->message_perihal_chn;
            $jsonResult[$i]["subyek_en"] = $buy[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $buy[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $buy[$i]->subyek_chn;
            $jsonResult[$i]["deal"] = $buy[$i]->deal;
            $jsonResult[$i]["id_csc_prod"] = $buy[$i]->id_csc_prod;
            $jsonResult[$i]["type_tracking"] = $buy[$i]->type_tracking;
            $jsonResult[$i]["no_track"] = $buy[$i]->no_track;
            $jsonResult[$i]["status_trx"] = $buy[$i]->status_trx;
            $id_csc = explode(",", $buy[$i]->id_csc_prod);
            $list_k = array();

            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }

            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["kategori_desc"] = $getName;

//
//            $jsonResult[$i]["tes"] = $namas;
//            for($x=0;$x<count($namas);$x++){
//
//            }
//            $nama = $namas;

//            $jsonResult[$i]["csc_product_name"] = (!empty($id_csc[$i])) ? DB::table('csc_product')->where('id', $id_csc[$i])->first()->nama_kategori_en : "";

//            print_r($id_csc);


//            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
//
//            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
        }
//        dd($buy);
        if ($buy) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }

    public function get_csc($id)
    {

        return DB::table('csc_product')->where('id', $id)->first()->nama_kategori_en;
    }

    public function br_importir_bc(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $coba = str_replace('"', '', $request->id_csc_buying_request);
        $id = (int)$coba;
//        dd($id);
        $cariprod = DB::select("select * from csc_buying_request where id='" . $id . "'");
        foreach ($cariprod as $prodcari) {
            $rrr = $prodcari->id_csc_prod;
            $zzz = $prodcari->id_pembuat;
        }
        $namacom = DB::select("select * from itdp_company_users where id='" . $zzz . "'");
        foreach ($namacom as $comnama) {
            $namapembuat = $comnama->username;
        }
        $cr = explode(',', $rrr);
        $hitung = count($cr);
        $semuacat = "";
        for ($a = 0; $a < ($hitung - 1); $a++) {
            //echo $rrr;die();
            // echo "select * from csc_product_single where id_csc_product='".$cr[0]."' or id_csc_product_level1='".$cr[0]."' or id_csc_product_level2='".$cr[0]."'";die();
            $namaprod = DB::select("select * from csc_product_single where id_csc_product='" . $cr[$a] . "' or id_csc_product_level1='" . $cr[$a] . "' or id_csc_product_level2='" . $cr[$a] . "' ");
            if (count($namaprod) == 0) {

            } else {
                foreach ($namaprod as $prod) {
                    $napro = $prod->id_itdp_company_user;
                    $cekada = DB::select("select * from csc_buying_request_join where id_br='" . $id . "' and id_eks='" . $napro . "'");
                    if (count($cekada) == 0) {

                        $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('" . $id . "','" . $napro . "','" . date('Y-m-d H:i:s') . "')");

                        //NOTIF
                        $id_terkait = "";
                        $ket = "Buying Request created by " . $namapembuat;
                        $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','" . $namapembuat . "','" . $zzz . "','Eksportir','" . $napro . "','" . $ket . "','br_list','" . $id_terkait . "','" . date('Y-m-d H:i:s') . "','0')");
                        //END NOTIF
                        //EMAIL
                        $caridataeks = DB::select("select * from itdp_company_users where id='" . $napro . "'");
                        foreach ($caridataeks as $vm) {
                            $vc1 = $vm->email;
                        }
                        $data = ['username' => $namapembuat, 'id2' => '0', 'nama' => $namapembuat, 'bu' => '', 'company' => '' ,  'password' => '', 'email' => $vc1];

                        Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['username']);
                            $mail->subject('Buying Was Created');

                        });
                        //END EMAIL
                    } else {

                    }
                }
            }
        }
        $update = DB::select("update csc_buying_request set status='1' where id='" . $id . "'");
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function ekslistbr(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $iduser = $request->id_user;
        $data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id = b.id_br and b.id_eks='" . $iduser . "' order by b.id desc ");
        $jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $data[$i]->id_mst_country;
            $jsonResult[$i]["id_csc_prod_cat"] = $data[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $data[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $data[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $data[$i]->jenis_perihal_en;
            $jsonResult[$i]["subyek"] = $data[$i]->subyek;
            $jsonResult[$i]["message"] = $data[$i]->message;
            $jsonResult[$i]["files"] = $data[$i]->files;
            $jsonResult[$i]["message_answer"] = $data[$i]->message_answer;
            $jsonResult[$i]["file_answer"] = $data[$i]->file_answer;
            $jsonResult[$i]["date"] = $data[$i]->date;
            $jsonResult[$i]["st_approve"] = $data[$i]->st_approve;
            $jsonResult[$i]["date_approve"] = $data[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $data[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $data[$i]->by_role;
            $jsonResult[$i]["id_pembuat"] = $data[$i]->id_pembuat;
            $id_role = $data[$i]->by_role;
            if ($id_role == 3) {
                $companyUser = DB::table('itdp_company_users')->where('id', $data[$i]->id_pembuat)->first();
                if ($companyUser != null) {
                    $id_profile = DB::table('itdp_company_users')->where('id', $data[$i]->id_pembuat)->first()->id_profil;
                }
                $jsonResult[$i]["company_name"] = DB::table('itdp_profil_imp')->where('id', $id_profile)->first()->company;
            } else if ($id_role == 1) {
                $jsonResult[$i]["company_name"] = DB::table('itdp_admin_users')->where('id', $data[$i]->id_pembuat)->first();
                if (isset($jsonResult[$i]["company_name"])) {
                    $jsonResult[$i]["company_name"] = $jsonResult[$i]["company_name"]->name;
                } else {
                    $jsonResult[$i]["company_name"] = '-';
                }
            }else if ($id_role == 4) {
                $jsonResult[$i]["company_name"] = DB::table('itdp_admin_users')->where('id', $data[$i]->id_pembuat)->first();
					$jsonResult[$i]["company_name"] = $jsonResult[$i]["company_name"]->name;
               
            }else {
                $companyUser = DB::table('itdp_company_users')->where('id', $data[$i]->id_pembuat)->first();
                if ($companyUser != null) {
                    $id_profile = DB::table('itdp_company_users')->where('id', $data[$i]->id_pembuat)->first()->id_profil;
                }
				if (count(DB::table('itdp_profil_eks')->where('id', $id_profile)->get()) != 0) {
                    $jsonResult[$i]["company_name"] = DB::table('itdp_profil_eks')->where('id', $id_profile)->first()->company;
                } else {
                    $jsonResult[$i]["company_name"] = '-';
                }
                // $jsonResult[$i]["company_name"] = DB::table('itdp_profil_eks')->where('id', $id_profile)->first()->company;
            }
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["shipping"] = $data[$i]->shipping;
            $jsonResult[$i]["spec"] = $data[$i]->spec;
            $jsonResult[$i]["eo"] = $data[$i]->eo;
            $jsonResult[$i]["neo"] = $data[$i]->neo;
            $jsonResult[$i]["tp"] = $data[$i]->tp;
            $jsonResult[$i]["ntp"] = $data[$i]->ntp;
            $jsonResult[$i]["valid"] = $data[$i]->valid;
            if ($data[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'Selesai';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $data[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $data[$i]->status;
            if ($data[$i]->status == null || $data[$i]->status == 0 || empty($data[$i]->status)) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $data[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $data[$i]->jenis_perihal_chn;
            $jsonResult[$i]["message_perihal_en"] = $data[$i]->message_perihal_en;
            $jsonResult[$i]["message_perihal_in"] = $data[$i]->message_perihal_in;
            $jsonResult[$i]["message_perihal_chn"] = $data[$i]->message_perihal_chn;
            $jsonResult[$i]["subyek_en"] = $data[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $data[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $data[$i]->subyek_chn;
            $jsonResult[$i]["deal"] = $data[$i]->deal;
            $jsonResult[$i]["id_csc_prod"] = $data[$i]->id_csc_prod;
            $id_csc = explode(",", $data[$i]->id_csc_prod);
            $list_k = array();
            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }
            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["kategori_desc"] = $getName;
            $jsonResult[$i]["type_tracking"] = $data[$i]->type_tracking;
            $jsonResult[$i]["no_track"] = $data[$i]->nop_track;
            $jsonResult[$i]["status_trx"] = $data[$i]->status_trx;
            $jsonResult[$i]["ida"] = $data[$i]->ida;
            $jsonResult[$i]["statusa"] = $data[$i]->statusa;
            $jsonResult[$i]["id_br"] = $data[$i]->id_br;
            $jsonResult[$i]["id_eks"] = $data[$i]->id_eks;
            $jsonResult[$i]["status_join"] = $data[$i]->status_join;
            if ($data[$i]->status_join == null) {
                $jsonResult[$i]["status_join_desc"] = "-";
            } else if ($data[$i]->status_join == 1) {
                $jsonResult[$i]["status_join_desc"] = "Wait Importir Verification";
            } else if ($data[$i]->status_join == 4) {
                $jsonResult[$i]["status_join_desc"] = "Deal";
            } else {
                $jsonResult[$i]["status_join_desc"] = "Negosiation";
            }
            $jsonResult[$i]["expired_at"] = $data[$i]->expired_at;
            $jsonResult[$i]["idb"] = $data[$i]->idb;
        }
//        dd($jsonResult);
        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }

    public function eksjoinbr(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->id;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
        $q2 = DB::select("select * from csc_buying_request where id='" . $id_br . "'");
//        dd($q2);
        if ($q2) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $q2;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function br_save_join(Request $request)
    {
        $id = $request->id;
        $data1 = "";
        $data2 = "";
        $data3 = "";
        $data4 = "";
        $data5 = "";
        date_default_timezone_set('Asia/Jakarta');
//        $caribrsl = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        $caribrsl = DB::table('csc_buying_request_join')
            ->where('id', '=', $id)
            ->get();
        foreach ($caribrsl as $val1) {
            $data1 = $val1->id_eks; //id eksportir
            $data2 = $val1->id_br;
        }

        $getusernameeks = DB::table('itdp_company_users')
            ->where('id', '=', $data1)
            ->first()->username;
        $getemaileks = DB::table('itdp_company_users')
            ->where('id', '=', $data1)
            ->first()->email;

        $caribrs2 = DB::table('csc_buying_request')
            ->where('id', '=', $data2)
            ->get();
        foreach ($caribrs2 as $val2) {
            $data3 = $val2->id_pembuat;
            $data5 = $val2->by_role;
        }

        $caribrs3 = DB::table('itdp_company_users')
            ->where('id', '=', $data3)
            ->get();
        foreach ($caribrs3 as $val3) {
            $data4 = $val3->email;
            $id_user_importir = $val3->id;
        }

//        dd($caribrs2);

        $ket = 'Exporter ' . $getusernameeks . " Join to your Buying Request!";
//        $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//		('3',getCompanyName($data1),'" . $request->id_user . "','Importir','" . $data3 . "','" . $ket . "','br_importir_lc','" . $data2 . "','" . date('Y-m-d H:i:s') . "','0')
//		");
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyName($data1),
            'dari_id' => $data1,
            'untuk_nama' => getCompanyNameImportir($data3),
            'untuk_id' => $data3,
            'keterangan' => $ket,
            'url_terkait' => 'br_importir_lc',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'to_role' => '3',
            'id_terkait' => $data2
        ]);

        $ket2 = $getusernameeks . " Join to Buying Request!";
//        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//		('1','Eksportir','" . $request->id_user . "','Super Admin','1','" . $ket2 . "','br_pw_lc','" . $data2 . "','" . date('Y-m-d H:i:s') . "','0')
//		");
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyName($data1),
            'dari_id' => $data1,
            'untuk_nama' => 'Super Admin',
            'untuk_id' => '1',
            'keterangan' => $ket2,
            'url_terkait' => 'br_pw_lc',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'to_role' => '1',
            'id_terkait' => $data2
        ]);
        if ($data5 == 3) {
            $data = [
                'email' => "",
                'email1' => $data4,
                'username' => $getusernameeks,
                'main_messages' => "",
                'id' => $data2
            ];
            Mail::send('UM.user.sendbrjoin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Eksportir Join to Your Buying Request');
            });

        }

        $data22 = [
            'email' => "",
            'email1' => $getemaileks,
            'username' => "",
            'main_messages' => $getusernameeks,
            'id' => $id
        ];

        Mail::send('UM.user.sendbrjoin2', $data22, function ($mail) use ($data22) {
            $mail->to($data22['email1'], $data22['username']);
            $mail->subject('You Join To Buying Request');
        });

        $data33 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => $getusernameeks,
            'main_messages' => "",
            'id' => $data2
        ];
        Mail::send('UM.user.sendbrjoin3', $data33, function ($mail) use ($data33) {
            $mail->to($data33['email1'], $data33['username']);
            $mail->subject('Eksportir Join to Buying Request');
        });
//        $update = DB::select("update csc_buying_request_join set status_join='1' where id='" . $id . "' ");
        $update = DB::table('csc_buying_request_join')
            ->where('id', $id)
            ->update([
                'status_join' => '1',
            ]);
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function br_importir_lc(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_br = $request->id_br;
        $pesan = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='" . $id_br . "'");
        if ($pesan) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $pesan;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function br_konfirm(Request $request)
    {
        $id = $request->idb;
        $id2 = $request->id_br;
        date_default_timezone_set('Asia/Jakarta');
        $crv = DB::table('csc_buying_request')
            ->where('id', '=', $id2)
            ->get();
        foreach ($crv as $cr) {
            $vld = $cr->valid;
            $data3 = $cr->id_pembuat;
        }

        $dy = $vld . " day";
        $besok = date('Y-m-d', strtotime($dy, strtotime(date("Y-m-d"))));

        $caribrsl = DB::table('csc_buying_request_join')
            ->where('id', '=', $id)
            ->get();
        foreach ($caribrsl as $val1) {
            $data1 = $val1->id_eks;
            $data2 = $val1->id_br;
        }
        $getusernameimp = DB::table('itdp_company_users')
            ->where('id', '=', $data3)
            ->first()->username;

        $getemaileks = DB::table('itdp_company_users')
            ->where('id', '=', $data3)
            ->first()->email;

        $caribrs3 = DB::table('itdp_company_users')
            ->where('id', '=', $data1)
            ->get();
        foreach ($caribrs3 as $val3) {
            $data4 = $val3->email; //email eksportir
        }
//        dd($getemaileks);

        $ket = $getusernameimp . " Verified Buying Request!";
//        $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//		('2','Importir','" . $request->id_user . "','Eksportir','" . $data1 . "','" . $ket . "','br_chat','" . $id . "','" . date('Y-m-d H:i:s') . "','0')
//		");

        $notif = DB::table('notif')->insert([
            'dari_nama' => 'Importir',
            'dari_id' => $data3,
            'untuk_nama' => 'Eksportir',
            'untuk_id' => $data1,
            'keterangan' => $ket,
            'url_terkait' => 'br_chat',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'to_role' => '2',
            'id_terkait' => $id
        ]);

        $ket2 = $getusernameimp . " Verified Buying Request!";
        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Importir','" . $data3 . "','Super Admin','1','" . $ket2 . "','br_pw_lc','" . $id2 . "','" . date('Y-m-d H:i:s') . "','0')
		");

        $data = [
            'email' => "",
            'email1' => $data4,
            'username' => $getusernameimp,
            'main_messages' => "",
            'bu' => "",
            'receiver' => "",
            'id' => $id
        ];
        Mail::send('UM.user.sendbrchat', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Impotir Verified Buying Request');
        });
        $data22 = [
            'email' => "",
            'email1' => $getemaileks,
            'username' => $getusernameimp,
            'main_messages' => $getusernameimp,
            'id' => $id,
            'id2' => $id2
        ];

        Mail::send('UM.user.sendbrchat2', $data22, function ($mail) use ($data22) {
            $mail->to($data22['email1'], $data22['username']);
            $mail->subject('You Verified Buying Request');
        });

        $data33 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => $getusernameimp,
            'main_messages' => $getusernameimp,
            'id' => $id,
            'id2' => $id2
        ];

        Mail::send('UM.user.sendbrchat3', $data33, function ($mail) use ($data33) {
            $mail->to($data33['email1'], $data33['username']);
            $mail->subject('Importir Verified Join Buying Request');
        });

        $update = DB::select("update csc_buying_request_join set status_join='2', expired_at='" . $besok . "' where id='" . $id . "' ");
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;

        }
    }

    public function eks_br_chat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->id;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
//        $qwr = DB::select("select * from csc_buying_request_chat where id_br='" . $id_br . "' and id_join='" . $id . "'");
        $user = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id_br)
            ->where('id_join', '=', $id)
            ->orderBy('id', 'desc')
            ->get();
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->files, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_br"] = $user[$i]->id_br;
            $jsonResult[$i]["pesan"] = $user[$i]->pesan;
            $jsonResult[$i]["tanggapan"] = $user[$i]->tanggapan;
            $jsonResult[$i]["tanggal"] = $user[$i]->tanggal;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["id_pengirim"] = $user[$i]->id_pengirim;
            $jsonResult[$i]["id_role"] = $user[$i]->id_role;
            $jsonResult[$i]["username_pengirim"] = $user[$i]->username_pengirim;
            $jsonResult[$i]["files"] = $path = ($user[$i]->files) ? url('/uploads/pop/' . $user[$i]->files) : "";
            $jsonResult[$i]["id_join"] = $user[$i]->id_join;
            $jsonResult[$i]["ext"] = $extension;

        }

//        dd($jsonResult);

        if ($jsonResult) {
            return response($jsonResult);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function uploadpop(Request $request)
    {
        $a = $request->pesan;
        $id2 = $request->id_br;
        $id3 = $request->id_role;
        $id4 = $request->id_user;
        $id5 = $request->username;
        $id6 = $request->idb;
        $file = $request->file('filez')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/pop";
        $request->file('filez')->move($destinationPath, $file);
        date_default_timezone_set('Asia/Jakarta');


        $insert = DB::table('csc_buying_request_chat')->insertGetId([
                'id_br' => $id2,
                'pesan' => $a,
                'tanggal' => date('Y-m-d H:i:s'),
                'id_pengirim' => $id4,
                'id_role' => $id3,
                'username_pengirim' => $id5,
                'id_join' => $id6,
                'files' => $file,
            ]
        );
        $user = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id2)
            ->where('id_join', '=', $id6)
            ->where('id', '=', $insert)
            ->get();

        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->files, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_br"] = $user[$i]->id_br;
            $jsonResult[$i]["pesan"] = $user[$i]->pesan;
            $jsonResult[$i]["tanggapan"] = $user[$i]->tanggapan;
            $jsonResult[$i]["tanggal"] = $user[$i]->tanggal;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["id_pengirim"] = $user[$i]->id_pengirim;
            $jsonResult[$i]["id_role"] = $user[$i]->id_role;
            $jsonResult[$i]["username_pengirim"] = $user[$i]->username_pengirim;
            $jsonResult[$i]["files"] = $path = ($user[$i]->files) ? url('/uploads/pop/' . $user[$i]->files) : "";
            $jsonResult[$i]["id_join"] = $user[$i]->id_join;
            $jsonResult[$i]["ext"] = $extension;

        }
////        $users = DB::table('csc_buying_request_chat')
////            ->where('id_br', '=', $id2)
////            ->where('id_join', '=', $id6)
////            ->where('id', '=', $insert)
////            ->first();
////
////
//////        dd($users);
////        $ext = pathinfo($users->files, PATHINFO_EXTENSION);
////        $gbr = ['png', 'jpg', 'jpeg'];
////        $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
////
////        if (in_array($ext, $gbr)) {
////            $extension = "gambar";
////        } else if (in_array($ext, $file)) {
////            $extension = "file";
////        } else {
////            $extension = "not identified";
////        }
////
////        $list_k = array();
////        $list_k["id"] = $users->id;
////        $list_k["id_br"] = $users->id_br;
////        $list_k["pesan"] = $users->pesan;
////        $list_k["tanggapan"] = $users->tanggapan;
////        $list_k["tanggal"] = $users->tanggal;
////        $list_k["status"] = $users->status;
////        $list_k["id_pengirim"] = $users->id_pengirim;
////        $list_k["id_role"] = $users->id_role;
////        $list_k["username_pengirim"] = $users->username_pengirim;
////        $list_k["files"] = $path =  url('/uploads/pop' . $users->files);
////        $list_k["id_join"] = $users->id_join;
////        $list_k["ext"] = $extension;
//
////        dd($list_k);
////        $users->file_desc = $path = ($users->files) ? url('/uploads/pop' . $users->files) : url('image/nia3.png');
        $cari = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($cari as $aja) {
            $data1 = $aja->id_pembuat;
        }
        $cari2 = DB::select("select * from itdp_company_users where id='" . $data1 . "'");
        foreach ($cari2 as $aja2) {
            $data2 = $aja2->email;
        }

        if ($id3 == 2) {
            $ket = "Eksportir " . $id5 . " Respond Chat Buying Request !";
            $it = $id2 . "/" . $id6;
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('3','Eksportir','" . $id4 . "','Importir','" . $data1 . "','" . $ket . "','br_importir_chat','" . $it . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $ket2 = "Eksportir " . $id5 . " Respond Chat Buying Request !";
            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Eksportir','" . $id4 . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $data = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'receiver' => "",
                'bu' => "",
                'id' => $it
            ];
            Mail::send('UM.user.sendbrchateks', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Ekportir Respond Chat On Buying Request');
            });

            $data22 = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks2', $data22, function ($mail) use ($data22) {
                $mail->to($data22['email1'], $data22['username']);
                $mail->subject('You Was Respond Chat On Buying Request');
            });

            $data33 = [
                'email' => "",
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject('Ekportir Respond Chat On Buying Request');
            });


        } else if ($id3 == 3) {
            $cari3 = DB::select("select * from csc_buying_request_join where id='" . $id6 . "'");
            foreach ($cari3 as $aja3) {
                $data3 = $aja3->id_eks;
            }
            $cari4 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
            foreach ($cari4 as $aja4) {
                $data4 = $aja4->email;
            }
            $ket = "Importir " . $id5 . " Respond Chat Buying Request !";
            $it = $id2 . "/" . $id6;
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('2','Importir','" . $id4 . "','Eksportir','" . $data3 . "','" . $ket . "','br_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $ket2 = "Importir " . $id5 . " Respond Chat Buying Request !";
            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Importir','" . $id4 . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $data = [
                'email' => "",
                'email1' => $data4,
                'username' => $id5,
                'main_messages' => "",
                'bur' => "",
                'receiver' => "",
                'bu' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchatimp', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Importir Respond Chat On Buying Request');
            });

            $data22 = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'id' => $it
            ];
            Mail::send('UM.user.sendbrchatimp2', $data22, function ($mail) use ($data22) {
                $mail->to($data22['email1'], $data22['username']);
                $mail->subject('You Was Respond Chat On Buying Request');
            });

            $data33 = [
                'email' => "",
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject('Importir Respond Chat On Buying Request');
            });

        }
        if ($jsonResult) {

            return $jsonResult;
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function br_deal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->idb;
        $id2 = $request->id_br;
        $id3 = $request->id_user;

        $cari1 = DB::select("select id_pembuat,by_role from csc_buying_request where id='" . $id2 . "'");
        foreach ($cari1 as $aja1) {
            $data1 = $aja1->id_pembuat;
            $data3 = $aja1->by_role;
        }
        $cr1 = DB::select("select email from itdp_company_users where id='" . $data1 . "'");
		if(count($cr1) == 0){
			$cari2 = DB::select("select email from itdp_admin_users where id='" . $data1 . "'");
		}else{
			$cari2 = DB::select("select email from itdp_company_users where id='" . $data1 . "'");
		}
        foreach ($cari2 as $aja2) {
            $data2 = $aja2->email;
        }
        $getusernameeks = DB::table('itdp_company_users')
            ->where('id', '=', $id3)
            ->first()->username;

        $ket = $getusernameeks . " Deal Buying Request!";
        $it = $id2 . "/" . $id;
        $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('3','Eksportir','" . $id3 . "','Importir','" . $data1 . "','" . $ket . "','br_importir_chat','" . $it . "','" . date('Y-m-d H:i:s') . "','0')
		");

        $ket2 = $getusernameeks . " Deal Buying Request!";
        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Eksportir','" . $id3 . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id . "','" . date('Y-m-d H:i:s') . "','0')
		");


        if ($data3 == 3) {
            $data = [
                'email' => "",
                'email1' => $data2,
                'username' => $getusernameeks,
                'main_messages' => "",
                'receiver' => "",
                'bu' => "",
                'id' => $it
            ];
            Mail::send('UM.user.sendbrdeal', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Eksportir Deal Buying Request');
            });
        }
        $data22 = [
            'email' => "",
            'email1' => $data2,
            'username' => $getusernameeks,
            'main_messages' => "",
            'id' => $id
        ];
        Mail::send('UM.user.sendbrdeal2', $data22, function ($mail) use ($data22) {
            $mail->to($data22['email1'], $data22['username']);
            $mail->subject('You Was Deal Buying Request');
        });

        $data33 = [
            'email' => "",
            'email1' => "fahrisafari95@gmail.com",
            'username' => $getusernameeks,
            'main_messages' => "",
            'id' => $id
        ];
        Mail::send('UM.user.sendbrdeal3', $data33, function ($mail) use ($data33) {
            $mail->to($data33['email1'], $data33['username']);
            $mail->subject('Eksportir Was Deal Buying Request');
        });

        $maxid = 0;
        $update = DB::select("update csc_buying_request_join set status_join='4' where id='" . $id . "' ");
        $update2 = DB::select("update csc_buying_request set status='4', deal='" . $id3 . "' where id='" . $id2 . "' ");
        $ambildata = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($ambildata as $ad) {
            $isi1 = $ad->id_pembuat;
            $isi2 = $ad->by_role;
        }

        $insert = DB::table('csc_transaksi')->insert([
                'id_pembuat' => $isi1,
                'by_role' => $isi2,
                'id_eksportir' => $id3,
                'id_terkait' => $id2,
                'origin' => '2',
                'created_at' => date('Y-m-d H:i:s'),
                'status_transaksi' => '0'
            ]
        );
        $querymax = DB::select("select max(id_transaksi) as maxid from csc_transaksi");
        foreach ($querymax as $maxquery) {
            $maxid = $maxquery->maxid;
        }

        if ($insert) {
            $list_k = array();
            $list_k["id_transaksi"] = $maxid;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $list_k;
            return response($res);
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Erorr',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function simpanchatbr(Request $request)
    {
//        dd($request);
        $a = $request->pesan;
        $id2 = $request->id_br;
        $id3 = $request->id_role;
        $id4 = $request->id_user;
        $id5 = $request->username;
        $id6 = $request->idb;
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
//        $getusername = DB::table('itdp_company_users')
//            ->where('id', '=', $id5)
//            ->first()->username;

        $insert = DB::table('csc_buying_request_chat')->insertGetId([
                'id_br' => $id2,
                'pesan' => $a,
                'tanggal' => $datenow,
                'id_pengirim' => $id4,
                'id_role' => $id3,
                'username_pengirim' => $id5,
                'id_join' => $id6,
            ]
        );
        $user = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id2)
            ->where('id_join', '=', $id6)
            ->where('id', '=', $insert)
            ->get();

        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->files, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_br"] = $user[$i]->id_br;
            $jsonResult[$i]["pesan"] = $user[$i]->pesan;
            $jsonResult[$i]["tanggapan"] = $user[$i]->tanggapan;
            $jsonResult[$i]["tanggal"] = $user[$i]->tanggal;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["id_pengirim"] = $user[$i]->id_pengirim;
            $jsonResult[$i]["id_role"] = $user[$i]->id_role;
            $jsonResult[$i]["username_pengirim"] = $user[$i]->username_pengirim;
            $jsonResult[$i]["files"] = $path = ($user[$i]->files) ? url('/uploads/pop/' . $user[$i]->files) : "";
            $jsonResult[$i]["id_join"] = $user[$i]->id_join;
            $jsonResult[$i]["ext"] = $extension;

        }
        $cari = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($cari as $aja) {
            $data1 = $aja->id_pembuat;
        }
        $cari2 = DB::select("select * from itdp_company_users where id='" . $data1 . "'");
        foreach ($cari2 as $aja2) {
            $data2 = $aja2->email;
        }

        if ($id3 == 2) {
            $ket = "Eksportir " . $id5 . " Respond Chat Buying Request !";
            $it = $id2 . "/" . $id6;
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('3','Eksportir','" . $id4 . "','Importir','" . $data1 . "','" . $ket . "','br_importir_chat','" . $it . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $ket2 = "Eksportir " . $id5 . " Respond Chat Buying Request !";
            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Eksportir','" . $id4 . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $data = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'receiver' => "",
                'bu' => "",
                'id' => $it
            ];
            Mail::send('UM.user.sendbrchateks', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Ekportir Respond Chat On Buying Request');
            });

            $data22 = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks2', $data22, function ($mail) use ($data22) {
                $mail->to($data22['email1'], $data22['username']);
                $mail->subject('You Was Respond Chat On Buying Request');
            });

            $data33 = [
                'email' => "",
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject('Ekportir Respond Chat On Buying Request');
            });


        } else if ($id3 == 3) {
            $cari3 = DB::select("select * from csc_buying_request_join where id='" . $id6 . "'");
            foreach ($cari3 as $aja3) {
                $data3 = $aja3->id_eks;
            }
            $cari4 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
            foreach ($cari4 as $aja4) {
                $data4 = $aja4->email;
            }
            $ket = "Importir " . $id5 . " Respond Chat Buying Request !";
            $it = $id2 . "/" . $id6;
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('2','Importir','" . $id4 . "','Eksportir','" . $data3 . "','" . $ket . "','br_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $ket2 = "Importir " . $id5 . " Respond Chat Buying Request !";
            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
		('1','Importir','" . $id4 . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . date('Y-m-d H:i:s') . "','0')
		");

            $data = [
                'email' => "",
                'email1' => $data4,
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchatimp', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Importir Respond Chat On Buying Request');
            });

            $data22 = [
                'email' => "",
                'email1' => $data2,
                'username' => $id5,
                'main_messages' => "",
                'id' => $it
            ];
            Mail::send('UM.user.sendbrchatimp2', $data22, function ($mail) use ($data22) {
                $mail->to($data22['email1'], $data22['username']);
                $mail->subject('You Was Respond Chat On Buying Request');
            });

            $data33 = [
                'email' => "",
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $id5,
                'main_messages' => "",
                'id' => $id6
            ];
            Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject('Importir Respond Chat On Buying Request');
            });

        }
        if ($user) {

            return $jsonResult;
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }

    }

    public function count_br_chat(Request $request)
    {
        $id = $request->id;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
//        $qwr = DB::select("select * from csc_buying_request_chat where id_br='" . $id_br . "' and id_join='" . $id . "'");
        $user = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id_br)
            ->where('id_join', '=', $id)
            ->orderBy('id', 'desc')
            ->count();


//        dd($jsonResult);

        if ($user) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = [
                'count' => $user
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }
}
