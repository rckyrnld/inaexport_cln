<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class TrxController extends Controller
{
    /*
    public function __construct()
        {
            $this->middleware('auth:web');
            $this->middleware('auth:eksmp');
        }
    */


    public function index()
    {
        $topMenu = "";
        if (Auth::guard('eksmp')->user() || Auth::user()) {
            if(!empty(Auth::guard('eksmp')->user()->id)){
                if(Auth::guard('eksmp')->user()->id_role == 2){
                    $pageTitle = "Selling Transaction | Inaexport";
                    //$data = DB::select("select * from csc_transaksi where  id_eksportir='".Auth::guard('eksmp')->user()->id."' order by id_transaksi desc ");
                    $data = DB::select("select * from csc_transaksi where  id_eksportir='".Auth::guard('eksmp')->user()->id."' order by created_at desc ");
                    return view('trx.index_eks', compact('pageTitle','data'));
                }else if(Auth::guard('eksmp')->user()->id_role == 3){
                    $pageTitle = "Selling Transaction Admin";
                    //$data = DB::select("select * from csc_transaksi where  id_pembuat='".Auth::guard('eksmp')->user()->id."' order by id_transaksi desc");
                    $data = DB::table('csc_transaksi')
                        ->select('*',DB::raw("case when created_at - now() < INTERVAL '0' then -(created_at - now())else created_at - now() end as abs_beda_tanggal"))
                        ->where('id_pembuat', Auth::guard('eksmp')->user()->id )
                        ->orderby('abs_beda_tanggal')
                        ->get();
                    return view('trx.index_imp', compact('pageTitle','data', 'topMenu'));
                }
            }else{
                if(Auth::user()->id_group == 4){
                    $pageTitle = "Selling Transaction Representative";
                    //$data = DB::select("select * from csc_transaksi  where id_pembuat='".Auth::user()->id."' and by_role='4' order by id_transaksi desc ");
                    $data = DB::select("select * from csc_transaksi  where id_pembuat='".Auth::user()->id."' and by_role='4' order by created_at desc ");
                    return view('trx.index_pw', compact('pageTitle','data'));
                }else{
                    $pageTitle = "Selling Transaction Admin";
                    //$data = DB::select("select * from csc_transaksi  order by id_transaksi desc ");
                    $data = DB::select("select * from csc_transaksi  order by created_at desc ");
                    return view('trx.index_adm', compact('pageTitle','data'));
                }
            }
        } else {
            return redirect('/login');
        }
    }

    public function caritab($id,$id2)
    {
        $pageTitle = "";
        if($id == 0 && $id2 == 0){
            //$data = DB::select("select * from csc_transaksi order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi order by created_at desc");
        }else if ($id == 0 && $id2 != 0){
            //$data = DB::select("select * from csc_transaksi where origin='".$id2."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where origin='".$id2."' order by created_at desc");
        }else if ($id != 0 && $id2 == 0){
            //$data = DB::select("select * from csc_transaksi where by_role='".$id."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' order by created_at desc");
        }else if($id != 0 && $id2 != 0){
            //$data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by created_at desc");
        }
        return view('trx.caritab', compact('id','id2','data','pageTitle'));
    }

    public function cetaktrx($id,$id2)
    {
        $pageTitle = "";
        if($id == 0 && $id2 == 0){
            //$data = DB::select("select * from csc_transaksi order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi order by created_at desc");
        }else if ($id == 0 && $id2 != 0){
            //$data = DB::select("select * from csc_transaksi where origin='".$id2."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where origin='".$id2."' order by created_at desc");
        }else if ($id != 0 && $id2 == 0){
            //$data = DB::select("select * from csc_transaksi where by_role='".$id."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' order by created_at desc");
        }else if($id != 0 && $id2 != 0){
            //$data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by id_transaksi desc");
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by created_at desc");
        }
        return view('trx.cetaktrx2', compact('id','id2','data','pageTitle'));
    }

    public function input_transaksi($id)
    {
        $pageTitle = "Selling Transaction";
        return view('trx.trx2', compact('id','pageTitle'));
    }

    public function save_trx(Request $request)
    {
    //    dd($request);
//        dd(Auth::guard('eksmp')->user()->id);
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
		$ch1 = str_replace(".","",$request->tp);
		$ch2 = str_replace(",",".",$ch1);
		if($request->origin == 2){
		    //buying request
			$update = DB::select("update csc_buying_request set eo='".$request->eo."', neo='".$request->neo."',tp='".$ch2."',ntp='".$request->ntp."' where id='".$request->id_br."' ");
			$update = DB::select("update csc_transaksi set id_product='".$request->id_product."' where id_transaksi='".$request->id_transaksi."' ");
		}
		if($request->tipekirim == 1){
                    if($request->by_role == 3){
                        $caripembuat = DB::select("select * from itdp_company_users where id='".$request->id_pembuat."'");
                        foreach($caripembuat as $cp){ $mailimp = $cp->email; }
                        $ket = "Transaction Created by ".getExBadan(Auth::guard('eksmp')->user()->id).getCompanyName(Auth::guard('eksmp')->user()->id);
                        $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,waktu,status_baca) values	
                        ('3','".getCompanyName(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','".getCompanyNameImportir($request->id_pembuat)."','".$request->id_pembuat."','".$ket."','trx_list','".$date."','0')
                        ");

                        $ket2 = "Transaction Created by ".getExBadan(Auth::guard('eksmp')->user()->id).getCompanyName(Auth::guard('eksmp')->user()->id);
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                        ('1','".getCompanyName(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','br_trx2','".$request->id_transaksi."','".$date."','0')
                        ");

                        $data = [
                            'email' => "",
                            'email1' => $mailimp,
                            'receiver' =>getCompanyNameImportir($request->id_pembuat),
                            'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                            'main_messages' => "",
                            'id' => $request->id_transaksi,
                            'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                            'bur' =>getExBadanImportir($request->id_pembuat),
                        ];
                        Mail::send('UM.user.sendtrx', $data, function ($mail) use ($data) {
                            $mail->to($data['email1'], $data['username']);
                            $mail->subject('Transaction Created By Exporters');
                        });

                        //notif email for env email
//                        $data22 = [
//                            'email' => "",
//                            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
//                            'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
//                            'main_messages' => "",
//                            'id' => $request->id_transaksi,
//                            'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
//                            'url' => "inquiry_admin/view",
//                        ];
//                        Mail::send('UM.user.sendtrx2', $data22, function ($mail) use ($data22) {
//                            $mail->to($data22['email1'], $data22['username']);
//                            $mail->subject('Transaction Created By '.$data22['username']);
//                        });

                        //notif email for all admin
                        $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
                        foreach($admin_all as $aa){
                            $data2 = [
                                'email' => $aa->email,
                                'email1' => $aa->email,
                                'admin' => $aa->name,
                                'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                                'url' =>  "inquiry_admin/view",
                                'id' => $request->id_transaksi,
                                'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                            ];
                            Mail::send('UM.user.sendtrx2', $data2, function ($mail) use ($data2) {
                                $mail->to($data2['email1']);
                                $mail->subject('Transaction Created By Exporters');
                            });
                        }


                    }else{
//                        $caripenerima = DB::select("select * from itdp_admin_users where id = '".$request->id_pembuat."'");
//                        $caripembuat = DB::select ("select * from itdp_profil_eks where id = '".Auth::guard('eksmp')->user()->id_profil."'");
//                        $namapembuat = $caripembuat[0]->company;
//                        $namapenerima = $caripenerima[0]->name;
//                        $bupembuat = $caripembuat[0]->badanusaha;
//                        if($bupembuat == "-"){
//                            $bupembuat2 = "";
//                        }
//                        else{
//                            $bupembuat2 = $bupembuat;
//                        }
        //                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
        //                ('4',$namapembuat,'".Auth::guard('eksmp')->user()->id_profil."',$namapenerima,$request->id_pembuat,'".$ket."','br_trx2','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
        //                ");
//                        dd($request->id_transaksi);
                        if($request->origin == 2 || $request->origin == 1){
                            //transaksi buying request
                            // $request->origin == 1 inquiry di perwakilan
                            $url = "br_trx2";
                            $idnya = $request->id_transaksi;
                        }else{
                            //transaksi inqury
                            $url = "inquiry_perwakilan/view";
                            $idnya = $request->id_in;
                        }
//                dd(auth::guard('eksmp')->user()->id_profil);


                        $ket = "Transaction Created by ".getExBadan(Auth::guard('eksmp')->user()->id).getCompanyName(Auth::guard('eksmp')->user()->id);
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                        ('4','".getCompanyName(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','".getAdminName($request->id_pembuat)."',$request->id_pembuat,'".$ket."','".$url."','".$idnya."','".$date."','0')
                        ");
                        $data22 = [
                            'email' => "",
                            'email1' => getAdminMail($request->id_pembuat),
                            'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                            'main_messages' => "",
                            'id' => $idnya,
                            'sender' => getCompanyName(Auth::guard('eksmp')->user()->id),
                            'receiver' => getAdminName($request->id_pembuat),
                            'url' => $url,
                            'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                        ];
                        Mail::send('UM.user.sendtrx3', $data22, function ($mail) use ($data22) {
                            $mail->to($data22['email1'], $data22['username']);
//                    $mail->subject('Transaction Created By '.Auth::guard('eksmp')->user()->username);
                            $mail->subject('Transaction Created By Exporter');
                        });

                        //notif system for admin
                        $ket2 = "Transaction Created by ".getExBadan(Auth::guard('eksmp')->user()->id).getCompanyName(Auth::guard('eksmp')->user()->id);
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                        ('1','".getCompanyName(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','".$url."','".$idnya."','".$date."','0')
                        ");

                        //notif email for all admin
                        $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
                        foreach($admin_all as $aa){
                            $data2 = [
                                'email' => $aa->email,
                                'email1' => $aa->email,
                                'admin' => $aa->name,
                                'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                                'url' =>  "inquiry_admin/view",
                                'id' => $request->id_transaksi,
                                'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                            ];
                            Mail::send('UM.user.sendtrx2', $data2, function ($mail) use ($data2) {
                                $mail->to($data2['email1']);
                                $mail->subject('Transaction Created By Exporter');
                            });
                        }
                    }


//            $ket3 = "Transaction Created By You";
//            $insertnotif3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//			('2','Eksportir','".Auth::guard('eksmp')->user()->id."','Eksportir','".Auth::guard('eksmp')->user()->id."','".$ket3."','input_transaksi','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
//			");
//
//
//			$data33 = [
//            'email' => "",
//            'email1' => Auth::guard('eksmp')->user()->email,
//            'username' => Auth::guard('eksmp')->user()->username,
//            'main_messages' => "",
//            'id' => $request->id_transaksi
//			];
//			Mail::send('UM.user.sendtrx3', $data33, function ($mail) use ($data33) {
//			$mail->to($data33['email1'], $data33['username']);
//			$mail->subject('Transaction Created By '.Auth::guard('eksmp')->user()->username);
//			});
        }
        // dd($request);
		$update = DB::select("update csc_transaksi set total='".($request->eo * $ch2)."' , eo='".$request->eo."', neo='".$request->neo."',tp='".$ch2."',ntp='".$request->ntp."', status_transaksi='".$request->tipekirim."', type_tracking='".$request->type_tracking."',no_tracking='".$request->no_track."',link_tracking='".$request->link_tracking."' where id_transaksi='".$request->id_transaksi."' ");
		return redirect('trx_list');
		
	}
	
	public function detailtrx($id)

    {
        $pageTitle = "Transaction Detail | Inaexport";
        $topMenu = "";

        return view('trx.detailtrx', compact('pageTitle', 'id', 'pageTitle', 'topMenu'));
    }

    public function allgr($id)
    {
        $pageTitle = "";
        if($id == 0){
            $pembuat = "All";
        }else if($id == 1){
            $pembuat = "Admin";
        }else if($id == 4){
            $pembuat = "Perwakilan";
        }else if($id == 3){
            $pembuat = "Importir";
        }
        if($id == 0){
            $data = DB::select("select * from csc_buying_request  order by id desc ");
        }else{
            $data = DB::select("select * from csc_buying_request where by_role='".$id."' order by id desc ");
        }
        return view('trx.cetaktrx', compact('pageTitle','id','pembuat','data'));
    }

    public function joineks($id,$id2)
    {
        $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,status_join,date) values 
		('".$id."','".$id2."','1','".Date('Y-m-d')."')
		");
        return redirect('br_importir_all');
    }

    public function data_br3()
    {

        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row,a.*,a.id as ida,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id_pembuat='".Auth::guard('eksmp')->user()->id."' and  b.status_join='4' and  a.id = b.id_br ");


        return DataTables::of($buy)
            ->addColumn('col1', function ($buy) {
                return $buy->subyek;
            })
            ->addColumn('col2', function ($buy) {
                $carieks = DB::select("select * from itdp_company_users where id='".$buy->id_eks."'");
                foreach($carieks as $eks){ $rty=  $eks->username; }
                return $rty;
            })
            ->addColumn('col3', function ($buy) {
                return $buy->date;
            })
            ->addColumn('col4', function ($buy) {
                if($buy->status_trx == 1){
                    return "<font color='green'>Already Sent</font>";
                }else{
                    return "<span class='badge bg-danger' style='color: #fff; '>On Process</span>";
                }
            })
            ->addColumn('col5', function ($buy) {
                return $buy->no_track;

            })
            ->addColumn('col6', function ($buy) {
                return '<center><a href="'.url('detailtrx/'.$buy->ida.'/'.$buy->idb).'" class="btn btn-sm btn-success">View</a></center>';
            })


            ->rawColumns(['col4','col5','col2','col6'])
            ->make(true);
    }


    public function data_br4()
    {
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row,* from csc_buying_request ");


        return DataTables::of($buy)
			->addColumn('row', function ($buy) {
				 return "<center>".$buy->row."</center>";
            })
            ->addColumn('col1', function ($buy) {
                return $buy->subyek;
            })
            ->addColumn('col2', function ($buy) {
                $cr = explode(',',$buy->id_csc_prod);
                $hitung = count($cr);
                $semuacat = "";
                for($a = 0; $a < ($hitung - 1); $a++){
                    $namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					if(count($namaprod) != 0){
                    foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
                    $semuacat = $semuacat."- ".$napro."<br>";
					}
                }
                return $semuacat;
            })
            ->addColumn('col3', function ($buy) {
                return $buy->date;
            })
            ->addColumn('col4', function ($buy) {
                return 'Valid '.$buy->valid." days";
            })
            ->addColumn('col5', function ($buy) {
                if($buy->deal == null || $buy->deal == 0 || empty($buy->deal)){
					if(app()->getLocale() == "en"){
						return "Negotiation";
					}else if(app()->getLocale() == "in"){
						return "Negosiasi";
					}else if(app()->getLocale() == "ch"){
						return "谈判";
					}else{
						return "";
					}
                }else{
                    if(app()->getLocale() == "en"){
						return "Deal";
					}else if(app()->getLocale() == "in"){
						return "Sepakat";
					}else if(app()->getLocale() == "ch"){
						return "成交";
					}else{
						return "";
					}
                }
            })
            ->addColumn('col6', function ($buy) {
                if($buy->by_role == 3){
                    if(app()->getLocale() == "en"){
						return "Importer";
					}else if(app()->getLocale() == "in"){
						return "Importir";
					}else if(app()->getLocale() == "ch"){
						return "进口商";
					}else{
						return "";
					}
                }else if($buy->by_role == 4){
                    if(app()->getLocale() == "en"){
						return "Representative";
					}else if(app()->getLocale() == "in"){
						return "Perwakilan";
					}else if(app()->getLocale() == "ch"){
						return "代表人物";
					}else{
						return "";
					}
                }else if($buy->by_role == 1){
                    if(app()->getLocale() == "en"){
						return "Admin";
					}else if(app()->getLocale() == "in"){
						return "Admin";
					}else if(app()->getLocale() == "ch"){
						return "管理员";
					}else{
						return "";
					}
                }else{
                    return "";
                }
            })

            ->addColumn('aks', function ($buy) {
                $adaga = DB::select("select * from csc_buying_request_join where id_br='".$buy->id."' and id_eks='".Auth::guard('eksmp')->user()->id."'");
                if(count($adaga) == 0){
                    return '<center><a href="'.url('joineks/'.$buy->id.'/'.Auth::guard('eksmp')->user()->id).'" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Join</a></center	>';
                }else{
                    return '<center><font color="green">On List</font></center>';
                }

            })


            ->rawColumns(['col4','col5','col2','col6','aks','row'])
            ->make(true);
    }




}
