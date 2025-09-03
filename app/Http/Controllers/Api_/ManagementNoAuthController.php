<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ContactUs;
use Mail;

class ManagementNoAuthController extends Controller
{

    public function contactUs(Request $request)
    {
        $fullName = $request->full_name;
        $email = $request->email;
        $subjek = $request->subject;
        $message = $request->message;
        $dateNow = date("Y-m-d h:i:s a");
        if ($fullName != null && $email != null && $subjek != null && $message != null) {
            // dd($fullName.",".$email.",".$email.",".$subjek.",".$message.",".$dateNow);
            $contactUs = new ContactUs;
            $contactUs->fullname = $fullName;
            $contactUs->email = $email;
            $contactUs->subyek = $subjek;
            $contactUs->message = $message;
            $contactUs->status = 0;
            $contactUs->date_created = $dateNow;
            $isSuccess = $contactUs->save();

            if ($isSuccess) {
                $res['message'] = "Success";
                return response($res);
            } else {
                $res['message'] = "Failed";
                return response($res);
            }
        } else {
            $res['message'] = "Failed";
            return response($res);
        }

    }

    public function getCountry()
    {
        $dataTraining = DB::table('mst_country')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
	
	public function getBadanusaha()
    {
        $dataTraining = DB::table('eks_business_entity')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getProvince()
    {
        $dataTraining = DB::table('mst_province')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getDataTracking()
    {
        $dataTraining = DB::table('api_tracking')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
//        $username = $request->username;
        $chek = DB::table('itdp_company_users')
            ->where('email', '=', $email)
//            ->orWhere('username', '=', $username)
            ->get();
        $hasil = count($chek);
//        dd($hasil);
        if ($hasil == 0) {
//            dd("mantapgan");
            $meta = [
                'code' => 200,
                'message' => 'OK',
                'status' => 'success'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 208,
                'message' => 'Email Already Used',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function RegisterExp(Request $request)
    {
        $company = $request->company;
        $email = $request->email;
		if(empty($request->username) || $request->username == null){
		$username = "";
		}else{
        $username = $request->username;
		}
        $phone = $request->phone;
        $fax = $request->fax;
        $website = $request->website;
        $badanusaha = $request->badanUsaha;
        $password = $request->password;
        $postcode = $request->postcode;
        $address = $request->address;
        $dateNow = date("Y-m-d H:m:s");
        $id_province = $request->id_province;
        $city = $request->city;
//        if ($company != null && $email != null && $username != null && $phone != null && $password != null && $postcode != null && $address != null && $id_province != null && $city != null) {

//            $chek = DB::table('itdp_company_users')
//                ->where('email', '=', $email)
//                ->orWhere('username', '=', $username)
//                ->get();
//            $hasil = count($chek);
//            dd($hasil);
//            if ($hasil == 0) {
        $insert = DB::table('itdp_profil_eks')
            ->insertGetId([
                "company" => $company,
                "addres" => $address,
                "badanusaha" => $badanusaha,
                "postcode" => $postcode,
                "phone" => $phone,
                "fax" => $fax,
                "email" => $email,
                "website" => $website,
                "created" => $dateNow,
                "status" => '1',
                "id_mst_province" => $id_province,
                "city" => $city
            ]);
        $insert2 = DB::table('itdp_company_users')
            ->insertGetId([
                "id_profil" => $insert,
                "type" => 'Dalam Negeri',
                "username" => $username,
                "password" => bcrypt($password),
                "email" => $email,
                "created_at" => $dateNow,
                "status" => '0',
                "id_role" => '2',
            ]);
        // notif
        $id_terkait = "2/" . $insert2;
        $ket = "User baru Eksportir dengan nama " . $company;
        $insert3 = DB::table('notif')
            ->insert([
                "to_role" => '1',
                "dari_nama" => $company,
                "dari_id" => $insert,
                "untuk_nama" => 'Super Admin',
                "untuk_id" => '1',
                "keterangan" => $ket,
                "url_terkait" => 'profil',
                "id_terkait" => $id_terkait,
                "waktu" => Date('Y-m-d H:m:s'),
                "status_baca" => '0',
            ]);

        $data = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'company' => '' , 'password' => $password, 'email' => $email];

        Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
            $mail->to($data['email'], $data['username']);
            $mail->subject('Notifikasi Aktifasi Akun');

        });
        $data2 = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'company' => '' , 'password' => $password, 'email' => 'safaririch12@gmail.com'];

        Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Notifikasi Aktifasi Akun');

        });
        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'OK'
        ];
        $data = '';
        $res['meta'] = $meta;
        $res['data'] = $data;
        return response($res);
//            } else {
//                $meta = [
//                    'code' => 208,
//                    'message' => 'Username Or Email Already Used',
//                    'status' => 'Failed'
//                ];
//                $data = '0';
//                $res['meta'] = $meta;
//                $res['data'] = $data;
//                return response($res);
//            }
//        } else {
//            $meta = [
//                'code' => 400,
//                'message' => 'All Data Must Be Filled In',
//                'status' => 'Failed'
//            ];
//            $data = '';
//            $res['meta'] = $meta;
//            $res['data'] = $data;
//            return response($res);
//        }

    }

    public function RegisterImp(Request $request)
    {
        $company = $request->company;
        $email = $request->email;
        $username = $request->username;
        $phone = $request->phone;
        $fax = $request->fax;
        $website = $request->website;
        $password = $request->password;
        $postcode = $request->postcode;
        $address = $request->address;
        $id_country = $request->id_country;
        $city = $request->city;
        $dateNow = date("Y-m-d H:m:s");
//        if ($company != null && $email != null && $username != null && $phone != null && $fax != null && $website != null && $password != null && $postcode != null && $address != null && $id_country != null && $city != null) {

//            $chek = DB::table('itdp_company_users')
//                ->where('email', '=', $email)
//                ->orWhere('username', '=', $username)
//                ->get();
//            $hasil = count($chek);
//            dd($hasil);
//            if ($hasil == 0) {
        $insert = DB::table('itdp_profil_imp')
            ->insertGetId([
                "company" => $company,
                "addres" => $address,
                "postcode" => $postcode,
                "phone" => $phone,
                "fax" => $fax,
                "email" => $email,
                "website" => $website,
                "created" => $dateNow,
                "status" => '1',
                "id_mst_country" => $id_country,
                "city" => $city
            ]);
        $insert2 = DB::table('itdp_company_users')
            ->insertGetId([
                "id_profil" => $insert,
                "type" => 'Luar Negeri',
                "username" => $username,
                "password" => bcrypt($password),
                "email" => $email,
				"created_at" => $dateNow,
                "status" => '0',
                "id_role" => '3',
            ]);
        // notif
        $id_terkait = "2/" . $insert2;
        $ket = "User baru Importir dengan nama " . $company;
        $insert3 = DB::table('notif')
            ->insert([
                "to_role" => '1',
                "dari_nama" => $company,
                "dari_id" => $insert,
                "untuk_nama" => 'Super Admin',
                "untuk_id" => '1',
                "keterangan" => $ket,
                "url_terkait" => 'profil',
                "id_terkait" => $id_terkait,
                "waktu" => Date('Y-m-d H:m:s'),
                "status_baca" => '0',
            ]);

        $data = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'company' => '' , 'password' => $password, 'email' => $email];

        Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
            $mail->to($data['email'], $data['username']);
            $mail->subject('Notifikasi Aktifasi Akun');

        });
        $data2 = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'company' => '' , 'password' => $password, 'email' => 'safaririch12@gmail.com'];

        Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Notifikasi Aktifasi Akun');

        });
        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'OK'
        ];
        $data = '';
        $res['meta'] = $meta;
        $res['data'] = $data;
        return response($res);
//            } else {
//                $meta = [
//                    'code' => 208,
//                    'message' => 'Username Or Email Already Used',
//                    'status' => 'Failed'
//                ];
//                $data = '0';
//                $res['meta'] = $meta;
//                $res['data'] = $data;
//                return response($res);
//            }
//        } else {
//            $meta = [
//                'code' => 400,
//                'message' => 'All Data Must Be Filled In',
//                'status' => 'Failed'
//            ];
//            $data = '0';
//            $res['meta'] = $meta;
//            $res['data'] = $data;
//            return response($res);
//        }

    }

    public function getResearchchor()
    {
        $research = DB::table('csc_broadcast_research_corner as a')->rightJoin('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
            ->orderby('a.created_at', 'desc')
            ->select('b.*', 'a.id_research_corner', 'a.created_at')
//            ->limit(10)
            ->get();
        if (count($research) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getEvent()
    {
        $research = DB::table('event_detail')
            ->leftJoin('contact_person', 'event_detail.id', '=', 'contact_person.id_type')
            ->select('event_detail.*','contact_person.name','contact_person.email','contact_person.phone')
            ->orderby('event_detail.id', 'desc')
            ->get();
//        dd($research);
        if (count($research) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];

            $getJSON = array();
            foreach ($research as $item) {
                array_push($getJSON, array(
                    "id" => $item->id,
                    "start_date" => $item->start_date,
                    "end_date" => $item->end_date,
                    "event_name_en" => $item->event_name_en,
                    "event_name_in" => $item->event_name_in,
                    "event_name_chn" => $item->event_name_chn,
                    "event_type_en" => $item->event_type_en,
                    "event_type_in" => $item->event_type_in,
                    "event_type_chn" => $item->event_type_chn,
                    "id_event_organizer" => $item->id_event_organizer,
                    "event_organizer_text_en" => $item->event_organizer_text_en,
                    "even_organizer_text_in" => $item->even_organizer_text_in,
                    "even_organizer_text_chn" => $item->even_organizer_text_chn,
                    "id_event_place" => $item->id_event_place,
                    "event_place_text_en" => $item->event_place_text_en,
                    "event_place_text_in" => $item->event_place_text_in,
                    "event_place_text_chn" => $item->event_place_text_chn,
                    "image_1" => $path = ($item->image_1) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_1) : url('image/nia3.png'),
                    "website" => $item->website,
                    "jenis_en" => $item->jenis_en,
                    "jenis_in" => $item->jenis_in,
                    "jenis_chn" => $item->jenis_chn,
                    "event_comodity" => $item->event_comodity,
                    "event_scope_en" => $item->event_scope_en,
                    "event_scope_in" => $item->event_scope_in,
                    "event_scope_chn" => $item->event_scope_chn,
                    "id_prod_cat" => $item->id_prod_cat,
                    "id_articles" => $item->id_articles,
                    "id_prod_sub1_kat" => $item->id_prod_sub1_kat,
                    "id_prod_sub2_kat" => $item->id_prod_sub2_kat,
                    "status_en" => $item->status_en,
                    "status_in" => $item->status_in,
                    "status_chn" => $item->status_chn,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "image_2" => $path = ($item->image_2) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_2) : url('image/nia3.png'),
                    "image_3" => $path = ($item->image_3) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_3) : url('image/nia3.png'),
                    "image_4" => $path = ($item->image_4) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_4) : url('image/nia3.png'),
                    "name" => $item->name,
                    "email" => $item->email,
                    "phone" => $item->phone,
//                    "type" => $item->type,
//                    "id_type" => $item->id_type
                ));
            }

            $res['meta'] = $meta;
            $res['data'] = $getJSON;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $research;
            return response($res);
        }
    }

    public function getKategori()
    {
        $dataTraining = DB::table('csc_product')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getKategoriFilter(Request $req)
    {
        $query = DB::table('csc_product')->orderby('nama_kategori_en','asc');
        if($req->filter != null){
            $query->where('nama_kategori_en', 'ILIKE', '%'.$req->filter.'%');
        }
        $product = $query->get();
        
        return response($product);
    }

    public function getCountryFilter(Request $req)
    {
        $query = DB::table('mst_country')->orderby('country','asc');
        if($req->filter != null){
            $query->where('country', 'ILIKE', '%'.$req->filter.'%');
        }
        $country = $query->get();
        
        return response($country);
    }

    public function getSub(Request $request)
    {
        $level = $request->level;
        if ($level == 1) {
            $catprod = DB::table('csc_product')->where('level_1', $request->idparent)->orderBy('nama_kategori_en', 'ASC')->get();
            if (count($catprod) > 0) {
                $meta = [
                    'code' => '200',
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = $catprod;
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => '204',
                    'message' => 'Data Not Found',
                    'status' => 'No Content'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
        } else {
            $catprod = DB::table('csc_product')->where('level_2', $request->idparent)->where('level_1', $request->idsub)->orderBy('nama_kategori_en', 'ASC')->get();
            if (count($catprod) > 0) {
                $meta = [
                    'code' => '200',
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = $catprod;
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => '204',
                    'message' => 'Data Not Found',
                    'status' => 'No Content'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
        }
    }

    public function getHscode()
    {
        $research = DB::table('mst_hscodes')
            //->select('id','desc_ind','desc_eng')
            ->get();
		
		for ($i = 0; $i < count($research); $i++) {
           
            $jsonResult[$i]["id"] = $research[$i]->id;
            $jsonResult[$i]["desc_eng"] = $research[$i]->fullhs." - ".$research[$i]->desc_eng;
            $jsonResult[$i]["desc_ind"] = $research[$i]->fullhs." - ".$research[$i]->desc_ind;
			
		
		}
        if (count($research) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
	
	public function getHscode_paging(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
        $research = DB::table('mst_hscodes')
            ->select('id','desc_ind','desc_eng')
			->paginate($limit);
            //->get(); 
			
		$research2 = DB::table('mst_hscodes')
            ->select('id','desc_ind','desc_eng')
			->get();
			
        if (count($research) > 0) {
            /*$meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);*/
			$countall = count($research2);
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
                'results' => $research
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getHscodeFilter(Request $req)
    {
        $query = DB::table('mst_hscodes')->select('id','desc_ind','desc_eng');
        if($req->filter != null){
            $query->where('desc_eng', 'ILIKE', '%'.$req->filter.'%');
        }
        $research = $query->get();
        
        return response($research);
    }

    public function getResearchc(Request $request)
    {
        $research = DB::table('csc_broadcast_research_corner as a')->rightJoin('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
            ->orderby('b.id', 'desc')
            ->select('b.*', 'a.id_research_corner', 'a.created_at')
            ->limit(10)
            ->offset($request->offset)
            ->get();

        $i = 0;
        foreach ($research as $data) {
            if ($data->cover != null) {
                $research[$i]->cover = url('uploads/Market Research/Cover/'.$data->cover);
            }
            $i++;
        }

        if (count($research) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
	
	public function getallcategory()
    {
        $research = DB::table('csc_product')
            ->orderby('nama_kategori_en', 'asc')
//            ->limit(10)
            ->get();
        if (count($research) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $research;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
	
}