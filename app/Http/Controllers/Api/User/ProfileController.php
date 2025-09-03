<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Intervention\Image\ImageManagerStatic as Image;


class ProfileController extends Controller
{
    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function findProfileExp(Request $request)
    {
        $dataProfil = DB::table('itdp_profil_eks')
            ->leftJoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_profil_eks.id', '=', $request->id_profil)
//            ->limit(1)
            ->get();
//        dd($dataProfil);
        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'Success'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findImageExp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_profil_eks.id', '=', $request->id_profil)
            ->limit(1)
            ->get();
//        dd($dataProfil);
        $id_user = DB::table('itdp_company_users')->where('id_profil', $request->id_profil)->first()->id;
//        dd($id_user);
        if (count($dataProfil) > 0) {

            foreach ($dataProfil as $rt) {
                $idFoto = $rt->foto_profil;
            }
//            $id_profil = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_profil;
            $path = ($idFoto) ? url('uploads/Profile/Eksportir/' . $id_user . '/' . $idFoto) : url('image/nia3.png');
//            $destination= 'uploads\Profile\Importir\\'.$id_user;
//            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');
//        $path3 = base64_encode(file_get_contents($path2));
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
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
    }

    public function updateProfilExp(Request $request)
    {
//        dd($request);
        if ($request->id_profile == null) {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $id_profile = $request->id_profile;
            $id_user = $request->id_user;
			//UPDATE TAB 1
            if ($request->password == null) {
//                dd($request->username);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        //'username' => $request->username,
                        'email' => $request->email,
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username= $request->username , email= $request->email , where id = $id_user  ");
//                dd('mantap');
            } else {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        //'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password)
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', email='" . $request->email . "' where id='" . $id_user . "' ");

            }
            //UPDATE TAB 2
            DB::table('itdp_profil_eks')
                ->where('id', $id_profile)
                ->update([
                    'company' => $request->company,
                    'addres' => $request->addres,
                    'city' => $request->city,
                    'id_mst_province' => $request->province,
                    'postcode' => $request->postcode,
                    'fax' => $request->fax,
                    'website' => $request->website,
                    'badanusaha' => $request->badanUsaha,
                    'phone' => $request->phone
                ]);
//            $updatetab2 = DB::select("update itdp_profil_eks set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' , id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "'
//            where id='" . $id_profile . "'");

            //UPDATE TAB 3
            if ($request->npwp == null) {

            } else {
                DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'npwp' => $request->npwp,
                        'tdp' => $request->tdp,
                        'siup' => $request->siup,
                        'upduserid' => $request->situ,
                        'id_eks_business_size' => $request->id_eks_business_size,
                        'id_business_role_id' => $request->id_business_role_id,
                        'employe' => $request->employe,
                    ]);
//                $updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "', tdp='" . $request->tdp . "', siup='" . $request->siup . "'
//				, upduserid='" . $request->situ . "' , id_eks_business_size='" . $request->id_eks_business_size . "', id_business_role_id='" . $request->id_business_role_id . "', employe='" . $request->employe . "', status='" . $request->staim . "'
//				where id='" . $id_profile . "'");
            }
            if (empty($request->file('foto_profil'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('foto_profil')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('foto_profil')->move($destinationPath, $file);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'foto_profil' => $file
                    ]);
//                $updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $id_user . "' ");
                DB::table('itdp_profil_eks')
                    ->where('id', $id_user)
                    ->update([
                        'logo' => $file

                    ]);
//                $updatetab22 = DB::select("update itdp_profil_eks set logo='" . $file . "' where id='" . $id_profile . "'");
            }
			
			if (empty($request->file('uploadnpwp'))) {
				//echo "njir";die();
                $file = "";
            } else {
                $filex = $request->file('uploadnpwp')->getClientOriginalName();
                $destinationPathx = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('uploadnpwp')->move($destinationPathx, $filex);
               DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'uploadnpwp' => $filex

                    ]);
            }
			
			if (empty($request->file('uploadtdp'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('uploadtdp')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('uploadtdp')->move($destinationPath, $file);
               DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'uploadtdp' => $file

                    ]);
            }
			
			if (empty($request->file('uploadsiup'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('uploadsiup')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('uploadsiup')->move($destinationPath, $file);
               DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'uploadsiup' => $file

                    ]);
            }
			
			if (empty($request->file('doc'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('doc')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('doc')->move($destinationPath, $file);
               DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'doc' => $file

                    ]);
            }
			
			$datas = DB::table('itdp_profil_eks')
						->select('itdp_profil_eks.*','itdp_company_users.agree','itdp_company_users.type','itdp_company_users.remember_token as access_token',
						'itdp_company_users.id as id_user','itdp_company_users.id_role','itdp_company_users.password','itdp_company_users.username',
						'itdp_company_users.id_template_reject'
						,'itdp_company_users.keterangan_reject','itdp_company_users.status as status_verif')
						->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->where('itdp_profil_eks.id', '=', $id_profile)
                        ->get();
			
			$meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'Success'
			];
			
			$role_name = $datas[0]->id_role == 2 ? "Eksportir" : "Importir";
		
			
			
			$data = array("id"=>$datas[0]->id,
			"company"=>$datas[0]->company,
			"addres"=>$datas[0]->addres,
			"city"=>$datas[0]->city,
			"postcode"=>$datas[0]->postcode,
			"phone"=>$datas[0]->phone,
			"fax"=>$datas[0]->fax,
			"email"=>$datas[0]->email,
			"website"=>$datas[0]->website,
			"upduserid"=>$datas[0]->upduserid,
			"created"=>$datas[0]->id,
			"modified"=>$datas[0]->modified,
			"id_mst_data_source"=>$datas[0]->id_mst_data_source,
			"status"=>$datas[0]->status,
			"logo"=>$datas[0]->logo,
			"npwp"=>$datas[0]->npwp,
			"kapasitas"=>$datas[0]->kapasitas,
			"id_prod_kat"=>$datas[0]->id_prod_kat,
			"id_prod_sub1_kat"=>$datas[0]->id_prod_sub1_kat,
			"id_prod_sub2_kat"=>$datas[0]->id_prod_sub2_kat,
			"kapasitas_tidak"=>$datas[0]->kapasitas_tidak,
			"id_port"=>$datas[0]->id_port,
			"bulan_ekspor1"=>$datas[0]->bulan_ekspor1,
			"tahun_ekspor1"=>$datas[0]->tahun_ekspor1,
			"tahun"=>$datas[0]->tahun,
			"bank"=>$datas[0]->bank,
			"id_mst_province"=>$datas[0]->id_mst_province,
			"tdp"=>$datas[0]->tdp,
			"siup"=>$datas[0]->siup,
			"id_eks_business_size"=>$datas[0]->id_eks_business_size,
			"id_business_role_id"=>$datas[0]->id_business_role_id,
			"employe"=>$datas[0]->employe,
			"doc"=>$datas[0]->doc,
			"id_itdp_eks_business_entity"=>$datas[0]->id_itdp_eks_business_entity,
			"id_type_capital_eks"=>$datas[0]->id_type_capital_eks,
			"situ"=>$datas[0]->situ,
			"addresspabrik"=>$datas[0]->addresspabrik,
			"kota_pabrik"=>$datas[0]->kota_pabrik,
			"phone_pabrik"=>$datas[0]->phone_pabrik,
			"fax_pabrik"=>$datas[0]->fax_pabrik,
			"metodeekspor"=>$datas[0]->metodeekspor,
			"frekwensi_pengirim"=>$datas[0]->frekwensi_pengirim,
			"upaya_pameran_ln"=>$datas[0]->upaya_pameran_ln,
			"upaya_pameran_dn"=>$datas[0]->upaya_pameran_dn,
			"upaya_misi_dagang"=>$datas[0]->upaya_misi_dagang,
			"upaya_pedagang_antara"=>$datas[0]->upaya_pedagang_antara,
			"upaya_langsung"=>$datas[0]->upaya_langsung,
			"upaya_brosur"=>$datas[0]->upaya_brosur,
			"upaya_web"=>$datas[0]->upaya_web,
			"upaya_email"=>$datas[0]->upaya_email,
			"upaya_lainnya"=>$datas[0]->upaya_lainnya,
			"ada_merek"=>$datas[0]->ada_merek,
			"paten_merek"=>$datas[0]->paten_merek,
			"paten_ind"=>$datas[0]->paten_ind,
			"paten_ln"=>$datas[0]->paten_ln,
			"pakai_merek_pelanggan"=>$datas[0]->pakai_merek_pelanggan,
			"mutu_reject"=>$datas[0]->mutu_reject,
			"mutu_qs"=>$datas[0]->mutu_qs,
			"mutu_rd"=>$datas[0]->mutu_rd,
			"mutu_limbah"=>$datas[0]->mutu_limbah,
			"mutu_iso9001"=>$datas[0]->mutu_iso9001,
			"mutu_iso14001"=>$datas[0]->mutu_iso14001,
			"mutu_ecolabelling"=>$datas[0]->mutu_ecolabelling,
			"masalah_ekspor"=>$datas[0]->masalah_ekspor,
			"badanusaha"=>$datas[0]->badanusaha,
			"uploadnpwp"=>$datas[0]->uploadnpwp,
			"uploadtdp"=>$datas[0]->uploadtdp,
			"uploadsiup"=>$datas[0]->uploadsiup,
			"agree"=>$datas[0]->agree,
			"type"=>$datas[0]->type,
			"access_token"=>$datas[0]->access_token,
			"id_user"=>$datas[0]->id_user,
			"id_role"=>$datas[0]->id_role,
			"password"=>$datas[0]->password,
			"username"=>$datas[0]->username,
			"id_template_reject"=>$datas[0]->id_template_reject,
			"keterangan_reject"=>$datas[0]->keterangan_reject,
			"status_verif"=>$datas[0]->status_verif,
			"role_name"=>$role_name);
			
			$res['meta'] = $meta;
			//$res = Array('data' =>$data);
			//$res['data'] = $data;
			//$res['data'][0]['role_name'] = $role_name;
			$res['data'] = $data;
			return $res;
            
			/*
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
        }
    }

    public function updateProfilImp(Request $request)
    {
        if ($request->id_profile == null) {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $id_profile = $request->id_profile;
            $id_user = $request->id_user;
            if (empty($request->file('foto_profil'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('foto_profil')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Importir/" . $id_user;
                $request->file('foto_profil')->move($destinationPath, $file);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'foto_profil' => $file
                    ]);
//                $updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $id_user . "' ");
                DB::table('itdp_profil_imp')
                    ->where('id', $id_profile)
                    ->update([
                        'logo' => $file
                    ]);
//                $updatetab22 = DB::select("update itdp_profil_imp set logo='" . $file . "' where id='" . $id_profile . "'");
            }

            //UPDATE TAB 1
            if ($request->password == null) {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        //'username' => $request->username,
                        'email' => $request->email,
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "',  where id='" . $id_user . "' ");
            } else {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        //'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password)
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "' ,  email='" . $request->email . "' where id='" . $id_user . "' ");

            }
            //UPDATE TAB 2
            DB::table('itdp_profil_imp')
                ->where('id', $id_profile)
                ->update([
                    'company' => $request->company,
                    'addres' => $request->addres,
                    'city' => $request->city,
                    'id_mst_country' => $request->country,
                    'postcode' => $request->postcode,
                    'fax' => $request->fax,
                    'website' => $request->website,
                    'phone' => $request->phone,
                ]);
//            $updatetab2 = DB::select("update itdp_profil_imp set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "'
//		, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' , status='" . $request->staim . "'
//		where id='" . $id_profile . "'");

//            if ($request->status == 2) {
//                if ($request->id_template_reject == 1) {
//                    DB::table('itdp_company_users')
//                        ->where('id', $id_user)
//                        ->update([
//                            'id_template_reject' => $request->id_template_reject,
//                            'keterangan_reject' => $request->keterangan_reject
//                        ]);
////                    $updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "', keterangan_reject='" . $request->txtreject . "'  where id='" . $id_user . "' ");
//
//                } else {
//                    DB::table('itdp_company_users')
//                        ->where('id', $id_user)
//                        ->update([
//                            'id_template_reject' => $request->id_template_reject,
//                        ]);
////                    $updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "'  where id='" . $id_user . "' ");
//
//                }
//            }
			$datas = DB::table('itdp_profil_imp')
						->select('itdp_profil_imp.*','itdp_company_users.agree','itdp_company_users.type','itdp_company_users.remember_token as access_token',
						'itdp_company_users.id as id_user','itdp_company_users.id_role','itdp_company_users.password','itdp_company_users.username',
						'itdp_company_users.id_template_reject'
						,'itdp_company_users.keterangan_reject','itdp_company_users.status as status_verif')
						->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                        ->where('itdp_profil_imp.id', '=', $id_profile)
                        ->get();
			
			$meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'Success'
			];
			
			$role_name = $datas[0]->id_role == 2 ? "Eksportir" : "Importir";
		
			
			
			$data = array("id"=>$datas[0]->id,
			"company"=>$datas[0]->company,
			"addres"=>$datas[0]->addres,
			"city"=>$datas[0]->city,
			"id_mst_country"=>$datas[0]->id_mst_country,
			"postcode"=>$datas[0]->postcode,
			"phone"=>$datas[0]->phone,
			"fax"=>$datas[0]->fax,
			"email"=>$datas[0]->email,
			"website"=>$datas[0]->website,
			"upduserid"=>$datas[0]->upduserid,
			"created"=>$datas[0]->created,
			"modified"=>$datas[0]->modified,
			"id_mst_data_source"=>$datas[0]->id_mst_data_source,
			"status"=>$datas[0]->status,
			"logo"=>$datas[0]->logo,
			"id_mst_province"=>$datas[0]->id_mst_province,
			"badanusaha"=>$datas[0]->badanusaha,
			"agree"=>$datas[0]->agree,
			"type"=>$datas[0]->type,
			"access_token"=>$datas[0]->access_token,
			"id_user"=>$datas[0]->id_user,
			"id_role"=>$datas[0]->id_role,
			"password"=>$datas[0]->password,
			"username"=>$datas[0]->username,
			"id_template_reject"=>$datas[0]->id_template_reject,
			"keterangan_reject"=>$datas[0]->keterangan_reject,
			"status_verif"=>$datas[0]->status_verif,
			"role_name"=>$role_name);
			
			$res['meta'] = $meta;
			//$res = Array('data' =>$data);
			//$res['data'] = $data;
			//$res['data'][0]['role_name'] = $role_name;
			$res['data'] = $data;
			return $res;
            
			/*
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
        }
    }

    public function findProfileImp(Request $request)
    {
        $dataProfil = DB::table('itdp_profil_imp')
            ->leftJoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_profil_imp.id', '=', $request->id_profil)
            ->get();

        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findImageimp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_profil_imp.id', '=', $request->id_profil)
            ->limit(1)
            ->get();
        $id_user = DB::table('itdp_company_users')->where('id_profil', $request->id_profil)->first()->id;
        if (count($dataProfil) > 0) {
            foreach ($dataProfil as $rat) {
                $idaFoto = $rat->foto_profil;
            }

//        $path = asset('image/fotoprofil/' . $idFoto);
//        $path2 = base64_encode(file_get_contents($path));
//            $path = ($idaFoto) ? url('image/fotoprofil/' . $idaFoto) : url('image/nia3.png');
            $path = ($idaFoto) ? url('uploads/Profile/Importir/' . $id_user . '/' . $idaFoto) : url('image/nia3.png');
//            $destination= 'uploads\Profile\Importir\\'.$id_user;
//            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
}
