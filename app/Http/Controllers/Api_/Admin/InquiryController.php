<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mail;
use Lang;


class InquiryController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }
	
	public function list_inquiry_admin(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		/*
		$page = $request->page;
		$limit = $request->limit;
		$user = DB::table('csc_inquiry_br')
			->where('csc_inquiry_br.type', 'admin')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
			->paginate($limit);
			//->limit(10)
            //->offset($offset)
            //->get();
		$user2 = DB::table('csc_inquiry_br')
			->where('csc_inquiry_br.type', 'admin')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
			->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;

			}
//        dd($jsonResult);
        if (count($user) > 0) {
			
			$countall = count($user2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
		
		*/
		
		$user = [];
		
		/*
                $importer = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*,csc_inquiry_br.created_at as ca,csc_inquiry_br.id as idb ,csc_inquiry_br.status as stabr , csc_product_single.*, csc_product_single.id as id_product')
                   // ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                   // ->where('csc_inquiry_br.status', 1)
                    // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('ca', 'DESC')
					->paginate($limit);
					//->get();
			$user2 = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*,csc_inquiry_br.status as stabr , csc_product_single.*, csc_product_single.id as id_product')
                   // ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                   // ->where('csc_inquiry_br.status', 1)
                    // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('csc_inquiry_br.created_at', 'DESC')
					->get();
					// dd($user);
					// echo count($importer);die();
                
                foreach ($importer as $key) {
                    array_push($user, $key);
                } 
		*/
//                dd($user);
				
                $perwakilan = DB::table('csc_inquiry_br')
                 //   ->leftjoin('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                 //   ->selectRaw('a.*,a.created_at as ca,a.id as idb,b.status as stabr, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.*, b.status')
                //    ->where('b.id_itdp_company_users', '=', $id_user)
                //   ->where('type', 'admin')
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($limit);
					//->get();
				$user3 = DB::table('csc_inquiry_br')
                //    ->leftjoin('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                //    ->selectRaw('a.*,a.id as idb,b.status as stabr, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.*, b.status')
                 //   ->where('b.id_itdp_company_users', '=', $id_user)
               //     ->where('b.status', 1)
			   // ->where('type', 'admin')
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
        
				
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
			$jsonResult[$i]["type"] = $user[$i]->type;
			if($user[$i]->type == "admin"){
				$jsonResult[$i]["id_type"] = 1;
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();
				
				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				
				
			}else if($user[$i]->type == "perwakilan"){
				$jsonResult[$i]["id_type"] = 4;
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
			}else{
				$jsonResult[$i]["id_type"] = 3;
				$jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				$jsonResult[$i]["status"] = $user[$i]->status;
				
			}
			/*
			if($user[$i]->status == 0){ $ct = "New Inquiry"; }else if($user[$i]->status == 1){ $ct = "New Inquiry"; }else if($user[$i]->status == 2){ $ct = "Transaction"; } 
			else if($user[$i]->status == 3){ $ct = "Deal"; } else if($user[$i]->status == 4){ $ct = "Cancel"; } else if($user[$i]->status == 5){ $ct = "Duration Timeout"; } 
			else { $ct = "-"; } 
			*/
			$statnya = "-";
                    if($user[$i]->status != NULL){
                        if($user[$i]->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $user[$i]->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
                    }

             
			$jsonResult[$i]["status"] = $user[$i]->status;
			$jsonResult[$i]["status_desc"] = $statnya;
           
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            
            
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
			if(empty($user[$i]->updated_at) || $user[$i]->updated_at == null){ 
			$jsonResult[$i]["updated_at"] =  ""; 
			}else{ 
			$jsonResult[$i]["updated_at"] =  $user[$i]->updated_at; 
			}
            
            $jsonResult[$i]["duration"] = $user[$i]->duration;
			if($user[$i]->type == "importir"){
				$jsonResult[$i]["to"] = $user[$i]->to;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role;
				$jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
				
            }else{
				$jsonResult[$i]["to"] = $user[$i]->id_pembuat;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				/*$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role; */
				$jsonResult[$i]["company_name"] = "";
				/*$jsonResult[$i]["csc_product_desc"] = "";
				$jsonResult[$i]["csc_product_level1_desc"] = "";
				$jsonResult[$i]["csc_product_level2_desc"] = "";*/
			
			}
		}
		
		// echo count($user);die();
        if ($perwakilan) {
            /*$meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($user3);
			// $bagi = $countall / ($request->limit * 2);
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => 0,
                'results' => $jsonResult
            ];

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
	
	public function verif_inquiry_admin(Request $request)
    {
		$id = $request->id;
		$data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
                $datenow = date('Y-m-d H:i:s');
                $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();

                if($inquiry){
                    if($inquiry->duration != "None"){
                        $durasi = 0;
                        $jn = explode(' ', $inquiry->duration);
                        if($jn[1] == "week" || $jn[1] == "weeks"){
                            $durasi = (int)$jn[0] * 7;
                        }else if($jn[1] == "month" || $jn[1] == "months"){
                            $durasi = (int)$jn[0] * 30;
                        }

                        $date = strtotime("+".$durasi." days", strtotime($datenow));
                        $duedate = date('Y-m-d H:i:s', $date);

                        $inquirynya = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->update([
                            'status' => 2,
                        ]);

                        $inquirybroadcast = DB::table('csc_inquiry_broadcast')->where('id', $id)->update([
                            'status' => 2,
                            'date' => $datenow,
                            'due_date' => $duedate,
                        ]);
                    }else{
                        $inquirynya = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->update([
                            'status' => 2,
                        ]);

                        $inquirybroadcast = DB::table('csc_inquiry_broadcast')->where('id', $id)->update([
                            'status' => 2,
                            'date' => $datenow,
                        ]);
                    }
				if($inquirybroadcast){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
					
                }

                
	}
	
	public function list_inquiry_broadcast(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$id_inquiry = $request->id_inquiry;
		$user = DB::table('csc_inquiry_broadcast')
			->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_inquiry_broadcast.id_itdp_company_users')
			->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
			->select('itdp_company_users.*','itdp_company_users.id as idc','itdp_profil_eks.*','csc_inquiry_broadcast.*','csc_inquiry_broadcast.id as id_broad')
			->where('csc_inquiry_broadcast.id_inquiry', $id_inquiry)
            ->orderBy('csc_inquiry_broadcast.created_at', 'DESC')
			->paginate($limit);
        //    ->get();
		$user2 = DB::table('csc_inquiry_broadcast')
			->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_inquiry_broadcast.id_itdp_company_users')
			->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
			->where('csc_inquiry_broadcast.id_inquiry', $id_inquiry)
            ->orderBy('csc_inquiry_broadcast.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broad"] = $user[$i]->id_broad;
            $jsonResult[$i]["id_itdp_company_users"] = $user[$i]->idc;
			$jsonResult[$i]["company"] = $user[$i]->badanusaha." ".$user[$i]->company;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
			$jsonResult[$i]["foto_profil"] = $path = ($user[$i]->foto_profil) ? url('uploads/Profile/Eksportir/' . $user[$i]->id . '/' . $user[$i]->foto_profil) : url('image/nia-01-01.jpg');            
            $qy1 = DB::select("select messages,file,created_at from csc_chatting_inquiry where id_inquiry='".$user[$i]->id_inquiry."' and sender ='".$user[$i]->id_itdp_company_users."' or receive ='".$user[$i]->id_itdp_company_users."' order by created_at desc limit 1");
			if(count($qy1) == 0){
				$lc = ".......";
				$ext = "text";
				$tc = "";
			}else{
				foreach($qy1 as $y1){
					if($y1->file == null || empty($y1->file) ){
					$lc = $y1->messages;
					$ext = "text";
					$tc = $y1->created_at;
					}else{
					$lc = $y1->files;
					$tc = $y1->created_at;
					$ext = pathinfo($y1->files, PATHINFO_EXTENSION);
					$gbr = ['png', 'jpg', 'jpeg'];
					$file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

					if (in_array($ext, $gbr)) {
						$ext = "Image";
					} else if (in_array($ext, $file)) {
						$ext = "File";
					} else {
						$ext = "Not Identified";
					}
					}
				}
				
			}
            $jsonResult[$i]["last_chat"] = $lc;
            $jsonResult[$i]["ext"] = $ext;
            $jsonResult[$i]["tanggal_chat"] = $tc;
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
			/*
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($user2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
			$countall = count($user2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = [
                'page' => $request->page,
                'total_results' => 0,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
            ];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function list_inquiry_hc(Request $request)
    {
		$id_inquiry = $request->id_inquiry;
		$id_broad = $request->id_broad;
	if(empty($id_broad) || $id_broad == null || $id_broad == ""){
		$user = DB::table('csc_chatting_inquiry')
			->where('csc_chatting_inquiry.id_inquiry', $id_inquiry)
            ->orderBy('csc_chatting_inquiry.created_at', 'DESC')
            ->get();
	}else{
		$user = DB::table('csc_chatting_inquiry')
			->where('csc_chatting_inquiry.id_inquiry', $id_inquiry)
			->where('csc_chatting_inquiry.id_broadcast_inquiry', $id_broad)
            ->orderBy('csc_chatting_inquiry.created_at', 'DESC')
            ->get();
	}
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
			$ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
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
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["pesan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggapan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggal"] = $user[$i]->created_at;
            $jsonResult[$i]["status"] = $user[$i]->status;
			$jsonResult[$i]["id_pengirim"] = $user[$i]->sender;
			$quek = DB::select("select * from itdp_company_users where id='".$user[$i]->sender."'");
            if(count($quek) == 0){
			$jsonResult[$i]["id_role"] = 1;
            $jsonResult[$i]["username_pengirim"] = "admin";	
			}else{
			foreach($quek as $wk){
			$jsonResult[$i]["id_role"] = $wk->id_role;
            $jsonResult[$i]["username_pengirim"] = $wk->username;
			}
			}
			
            $jsonResult[$i]["files"] = $path = ($user[$i]->file) ? url('/Inquiry/'.$id_inquiry.'/'. $user[$i]->file) : "";
            $jsonResult[$i]["ext"] = $extension;
            
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($jsonResult);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        $type = "admin";


                //Jenis Perihal
                $jpen = "";
                $jpin = "";
                $jpchn = "";
                if($request->kos == "offer to sell"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk menjual";
                    $jpchn = "出售要约";
                }else if($request->kos == "offer to buy"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk membeli";
                    $jpchn = "报价购买";
                }else if($request->kos == "consultation"){
                    $jpen = $request->kos;
                    $jpin = "konsultasi";
                    $jpchn = "咨询服务";
                }

                if($request->duration == NULL){
                    $duration = "None";
                }else{
                    $duration = $request->duration;
                }

                $save = DB::table('csc_inquiry_br')->insertGetId([
                    'id_pembuat' => '1',
                    'type' => $type,
                    'prodname' => $request->prodname,
                    'jenis_perihal_en' => $jpen,
                    'jenis_perihal_in' => $jpin,
                    'jenis_perihal_chn' => $jpchn,
                    'messages_en' => $request->messages,
                    'messages_in' => $request->messages,
                    'messages_chn' => $request->messages,
                    'subyek_en' => $request->subject,
                    'subyek_in' => $request->subject,
                    'subyek_chn' => $request->subject,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $duration,
                    'created_at' => $datenow,
                ]);

                $nama_file1 = NULL;
                $destination= 'uploads\Inquiry\\'.$save;
                if($request->hasFile('file')){
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                    Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
                }

                $savefile = DB::table('csc_inquiry_br')->where('id', $save)->update([
                    'file' => $nama_file1,
                ]);
                if($save){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
            

    }
	
	public function bc_inquiry_admin(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
            $id_user = 1;
                $id_inquiry = $request->id_inquiry;
                $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
                $datenow = date("Y-m-d H:i:s");

                //update status
                $upd = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
                    'status' => 0,
                ]);

                $array = [];
                for($i = 0; $i<count($request->categori); $i++){
                    $var = $request->categori[$i];
                    
                    $input_cat = DB::table('csc_inquiry_category')->insert([
                        'id_inquiry' => $id_inquiry,
                        'id_cat_prod' => $var,
                        'created_at' => date('Y-m-d H:i:s')
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
                $users = [];
                $usernames = [];
                $userbadanusaha = [];
                for ($k=0; $k <count($array) ; $k++) { 
                    $untuk = DB::table('itdp_company_users')->where('id', $array[$k])->first();
                    if($untuk != NULL){
                        $company = DB::table('itdp_profil_eks')->where('id', $untuk->id_profil)->first();
                        $save = DB::table('csc_inquiry_broadcast')->insert([
                            'id_inquiry' => $id_inquiry,
                            'id_itdp_company_users' => $array[$k],
                            'status' => 1,
                            'created_at' => $datenow,
                        ]);

                        $admin = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                        $notif = DB::table('notif')->insert([
                            'dari_nama' => $admin->name,
                            'dari_id' => $id_user,
                            'untuk_nama' => getCompanyName($array[$k]),
                            'untuk_id' => $array[$k],
                            'keterangan' => 'New Inquiry By '.$admin->name.' with Subyek  "'.$inquiry->subyek_en.'"',
                            'url_terkait' => 'inquiry',
                            'status_baca' => 0,
                            'waktu' => $datenow,
                            'to_role' => 2,
                        ]);

                        $data = [
                            'email' => $untuk->email,
                            'type' => "eksportir",
                            'company' => getCompanyName($array[$k]),
                            'dari' => auth::user()->name,
                            'bu' =>$company->badanusaha,
                        ];

                        Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data, $users) {
                            $mail->subject('Inquiry Information');
                            $mail->to($data['email']);
                        });


                $users_admin = [];
                $adminnya = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                array_push($users_admin, env('MAIL_USERNAME','no-reply@inaexport.id'));

                
            }else{
                   
            }
        }
			if($upd){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
		
	}
	
	public function inquiry_detail_admin(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		
		$id_inquiry = $request->id_inquiry;
        $user = DB::table('csc_inquiry_br')
                    ->where('id', $id_inquiry)
					->get();

        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
			$jsonResult[$i]["type"] = $user[$i]->type;
			if($user[$i]->type == "admin"){
				$jsonResult[$i]["id_type"] = 1;
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();
				
				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				
				
			}else if($user[$i]->type == "perwakilan"){
				$jsonResult[$i]["id_type"] = 4;
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
			}else{
				$jsonResult[$i]["id_type"] = 3;
				$jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				$jsonResult[$i]["status"] = $user[$i]->status;
				
			}
			/*
			if($user[$i]->status == 0){ $ct = "New Inquiry"; }else if($user[$i]->status == 1){ $ct = "New Inquiry"; }else if($user[$i]->status == 2){ $ct = "Transaction"; } 
			else if($user[$i]->status == 3){ $ct = "Deal"; } else if($user[$i]->status == 4){ $ct = "Cancel"; } else if($user[$i]->status == 5){ $ct = "Duration Timeout"; } 
			else { $ct = "-"; } 
			*/
			$statnya = "-";
                    if($user[$i]->status != NULL){
                        if($user[$i]->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $user[$i]->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
                    }

             
			$jsonResult[$i]["status"] = $user[$i]->status;
			$jsonResult[$i]["status_desc"] = $statnya;
           
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            
            
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
			if(empty($user[$i]->updated_at) || $user[$i]->updated_at == null){ 
			$jsonResult[$i]["updated_at"] =  ""; 
			}else{ 
			$jsonResult[$i]["updated_at"] =  $user[$i]->updated_at; 
			}
            
            $jsonResult[$i]["duration"] = $user[$i]->duration;
			if($user[$i]->type == "importir"){
				$jsonResult[$i]["to"] = $user[$i]->to;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role;
				$jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
				
            }else{
				$jsonResult[$i]["to"] = $user[$i]->id_pembuat;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				/*$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role; */
				$jsonResult[$i]["company_name"] = "";
				/*$jsonResult[$i]["csc_product_desc"] = "";
				$jsonResult[$i]["csc_product_level1_desc"] = "";
				$jsonResult[$i]["csc_product_level2_desc"] = "";*/
			
			}
		}


        if ($user) {
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
	
	public function count_inq_chat_admin(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $id_broad = $request->id_broad;
        
//        $qwr = DB::select("select * from csc_buying_request_chat where id_br='" . $id_br . "' and id_join='" . $id . "'");
		if(empty($id_broad) || $id_broad == null || $id_broad == "" || $id_broad == 0){
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->orderBy('id', 'desc')
            ->count();
		}else{
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->where('id_broadcast_inquiry', '=', $id_broad)
            ->orderBy('id', 'desc')
            ->count();
		}
        


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
	
	
	public function simpanchat_inquiry_admin(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $sender = $request->sender;
        $receive = $request->receive;
		$messages = $request->messages;
        $id_broadcast_inquiry = $request->id_broad;
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
//        $getusername = DB::table('itdp_company_users')
//            ->where('id', '=', $id5)
//            ->first()->username;

        $insert = DB::table('csc_chatting_inquiry')->insertGetId([
                'id_inquiry' => $id_inquiry,
                'sender' => $sender,
                'receive' => $receive,
                'messages' => $messages,
                'status' => 0,
                'created_at' => $datenow,
                'id_broadcast_inquiry' => $id_broadcast_inquiry,
            ]
        );
		
        if(empty($id_broadcast_inquiry) || $id_broadcast_inquiry == null || $id_broadcast_inquiry == "" || $id_broadcast_inquiry == 0){
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->orderBy('id', 'desc')
            ->get();
		}else{
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->where('id_broadcast_inquiry', '=', $id_broadcast_inquiry)
            ->orderBy('id', 'desc')
            ->get();
		}

        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
			$ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
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
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["pesan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggapan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggal"] = $user[$i]->created_at;
            $jsonResult[$i]["status"] = $user[$i]->status;
			$jsonResult[$i]["id_pengirim"] = $user[$i]->sender;
			$quek = DB::select("select * from itdp_company_users where id='".$user[$i]->sender."'");
            if(count($quek) == 0){
			$jsonResult[$i]["id_role"] = 1;
            $jsonResult[$i]["username_pengirim"] = "admin";	
			}else{
			foreach($quek as $wk){
			$jsonResult[$i]["id_role"] = $wk->id_role;
            $jsonResult[$i]["username_pengirim"] = $wk->username;
			}
			}
			
            $jsonResult[$i]["files"] = $path = ($user[$i]->file) ? url('/Inquiry/'.$id_inquiry.'/'. $user[$i]->file) : "";
            $jsonResult[$i]["ext"] = $extension;
            
            

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
	
	public function uploadpop_inquiry(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		$id_inquiry = $request->id_inquiry;
        $sender = $request->sender;
        $receive = $request->receive;
		$messages = $request->messages;
        $id_broadcast_inquiry = $request->id_broad;
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
		
        $file = $request->file('filez')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/Inquiry/".$id_inquiry;
        $request->file('filez')->move($destinationPath, $file);
       


        $insert = DB::table('csc_chatting_inquiry')->insertGetId([
                'id_inquiry' => $id_inquiry,
                'sender' => $sender,
                'receive' => $receive,
                'messages' => $messages,
                'status' => 0,
                'created_at' => $datenow,
                'file' => $file,
                'id_broadcast_inquiry' => $id_broadcast_inquiry,
            ]
        );
		
        if(empty($id_broadcast_inquiry) || $id_broadcast_inquiry == null || $id_broadcast_inquiry == "" || $id_broadcast_inquiry == 0){
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->orderBy('id', 'desc')
            ->get();
		}else{
			$user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', '=', $id_inquiry)
            ->where('id_broadcast_inquiry', '=', $id_broadcast_inquiry)
            ->orderBy('id', 'desc')
            ->get();
		}

        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
			$ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
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
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["pesan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggapan"] = $user[$i]->messages;
            $jsonResult[$i]["tanggal"] = $user[$i]->created_at;
            $jsonResult[$i]["status"] = $user[$i]->status;
			$jsonResult[$i]["id_pengirim"] = $user[$i]->sender;
			$quek = DB::select("select * from itdp_company_users where id='".$user[$i]->sender."'");
            if(count($quek) == 0){
			$jsonResult[$i]["id_role"] = 1;
            $jsonResult[$i]["username_pengirim"] = "admin";	
			}else{
			foreach($quek as $wk){
			$jsonResult[$i]["id_role"] = $wk->id_role;
            $jsonResult[$i]["username_pengirim"] = $wk->username;
			}
			}
			
            $jsonResult[$i]["files"] = $path = ($user[$i]->file) ? url('/Inquiry/'.$id_inquiry.'/'. $user[$i]->file) : "";
            $jsonResult[$i]["ext"] = $extension;
            
            

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
	

    

}
