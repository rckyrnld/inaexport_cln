<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\EventDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Mail;
use App\Exports\EventParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Lang;

class EventController extends Controller
{
    public function index()
    {
        $pageTitle = "Event";
        if (Auth::guard('eksmp')->user()) {
            $id_user = strval(Auth::guard('eksmp')->user()->id);
            // $e_detail = DB::select("SELECT DISTINCT b.id_terkait, a.* FROM event_detail as a LEFT JOIN notif as b on b.id_terkait=a.id::VARCHAR WHERE b.untuk_id='$id_user' and b.url_terkait='event/show/read' ORDER BY a.id desc ");
            $e_detail = DB::table('event_detail as a')->select('a.*')
                ->leftjoin('notif as b', function ($join) {
                    $join->on(DB::raw('a.id::varchar'), '=', 'b.id_terkait');
                })
                ->leftjoin('event_company_add as c', 'a.id', '=', 'c.id_event_detail')
                ->where('b.untuk_id', $id_user)->where(function ($query) {
                    $query->where('b.url_terkait', 'event/show_detail');
                })
                ->orwhere('c.id_itdp_profil_eks', $id_user)
                //->orderby('a.id','desc')
                //->orderby('a.start_date','desc')
                ->select('*', DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->orderby('abs_beda_tanggal')
                ->get();
            $q = '';
            return view('Event.index_eksportir', compact('pageTitle', 'e_detail', 'id_user', 'q'));
        } else {
            $q = '';
            if (Auth::user()->id_group == 4) {
                $id_user = Auth::user()->id;
                $e_detail = EventDetail::with('participants')->where('created_by', $id_user)->orderby('start_date', 'desc')->paginate(12);
            } else {
                $e_detail = EventDetail::with('participants')->orderby('start_date', 'desc')->paginate(12);
            }
            //$e_detail = DB::table('event_detail')->orderby('id', 'desc')->paginate(6);

            return view('Event.index', compact('pageTitle', 'e_detail', 'q'))->with('success');
        }
    }

    public function create()
    {
        $lang = Lang::getLocale();
        $url_store = '/event/store';
        $pageTitle = 'Add Event';
        $page = 'add';
        if ($lang == "en") {
            $lang_e_organizer = "name_en";
            $lang_e_place = "name_en";
            $lang_e_comodity = "comodity_en";
        } else if ($lang == "in") {
            $lang_e_organizer = "name_in";
            $lang_e_place = "name_in";
            $lang_e_comodity = "comodity_in";
        } else {
            $lang_e_organizer = "name_chn";
            $lang_e_place = "name_chn";
            $lang_e_comodity = "comodity_en";
        }
        $e_organizer = DB::table('event_organizer')->orderby($lang_e_organizer, 'asc')->get();
        $e_palce = DB::table('event_place')->orderby($lang_e_place, 'asc')->get();
        $e_comodity = DB::table('event_comodity')->orderby($lang_e_comodity, 'asc')->get();
        $country = DB::table('mst_country')->orderby('country', 'asc')->get();
        // $prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

        return view('Event.create', compact('pageTitle', 'url_store', 'page', 'e_organizer', 'e_palce', 'e_comodity', 'country'));
    }



    public function store(Request $req)
    {
        //admin
        $datenow = date("Y-m-d H:i:s");
        $id_user = Auth::user()->id;
        $array = array();

        $nama_file1 = NULL;
        $nama_file2 = NULL;
        $nama_file3 = NULL;
        $nama_file4 = NULL;

        $id = DB::table('event_detail')->max('id') + 1;

        $destination = 'uploads\Event\Image\\' . $id;
        if ($req->hasFile('image_1')) {
            $file1 = $req->file('image_1');
            $nama_file1 = time() . '_' . $req->eventname_en . '_' . $req->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        if ($req->hasFile('image_2')) {
            $file2 = $req->file('image_2');
            $nama_file2 = time() . '_' . $req->eventname_en . '_' . $req->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        }

        if ($req->hasFile('image_3')) {
            $file3 = $req->file('image_3');
            $nama_file3 = time() . '_' . $req->eventname_en . '_' . $req->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        }

        if ($req->hasFile('image_4')) {
            $file4 = $req->file('image_4');
            $nama_file4 = time() . '_' . $req->eventname_en . '_' . $req->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        }

        if ($req->eventorgnzr_en == '|adding_eo|') {
            $id_eo = DB::table('event_organizer')->max('id') + 1;
            DB::table('event_organizer')->insert([
                'id' => $id_eo,
                'name_en' => $req->eo_en,
                'name_in' => $req->eo_in,
                'name_chn' => $req->eo_chn
            ]);
        } else {
            $id_eo = $req->eventorgnzr_en;
        }

        if ($req->eventplace_en == '|adding_place|') {
            $id_place = DB::table('event_place')->max('id') + 1;
            DB::table('event_place')->insert([
                'id' => $id_place,
                'name_en' => $req->plc_en,
                'name_in' => $req->plc_in,
                'name_chn' => $req->plc_chn
            ]);
        } else {
            $id_place = $req->eventplace_en;
        }

        $data = DB::table('event_detail')->insert([
            'id' => $id,
            'start_date'    => $req->s_date,
            'end_date'    => $req->e_date,
            'event_name_en'    => $req->eventname_en,
            'event_name_in'    => $req->eventname_in,
            'event_name_chn'    => $req->eventname_chn,
            'event_type_en'    => $req->eventype_en,
            'event_type_in'    => $req->eventype_in,
            'event_type_chn'    => $req->eventype_chn,
            'id_event_organizer'    => $id_eo,
            // 'event_organizer_text_en'	=> $req->eot_en,
            // 'even_organizer_text_in'	=> $req->eot_in,
            // 'even_organizer_text_chn'	=> $req->eot_chn,
            'id_event_place'    => $id_place,
            'event_place_text_en'    => $req->ept_en,
            'event_place_text_in'    => $req->ept_in,
            'event_place_text_chn'    => $req->ept_chn,
            'image_1'    => $nama_file1,
            'image_2'    => $nama_file2,
            'image_3'    => $nama_file3,
            'image_4'    => $nama_file4,
            'website'    => $req->website,
            'jenis_en'    => $req->jenis_en,
            'jenis_in'    => $req->jenis_in,
            'jenis_chn'    => $req->jenis_chn,
            'event_comodity'    => $req->eventcomodity,
            'event_scope_en'    => $req->es_en,
            'event_scope_in'    => $req->es_in,
            'event_scope_chn'    => $req->es_chn,
            'id_prod_cat'    => 0,
            'country'   => $req->country,
            // 'id_articles'	=> $req->,
            'id_prod_sub1_kat'    => 0,
            'id_prod_sub2_kat'    => 0,
            'status_en'    => $req->status,
            // 'reg_date' => $req->registration_date,
            // 'status_in'	=> $req->,
            // 'status_chn'	=> $req->,
            'created_at' => $datenow,
            'created_by' => $id_user,
            'open' => $req->open,
            'limit' => ($req->open) ? $req->limit : null,
            'description' => $req->desc,
            'status_bc' => 1
        ]);

        $cp = DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->first();
        if ($cp) {
            DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->update([
                'name' => $req->cp_name,
                'email' => $req->cp_email,
                'phone' => $req->cp_phone,
            ]);
        } else {
            $idp = DB::table('contact_person')->max('id') + 1;
            DB::table('contact_person')->insert([
                'id' => $idp,
                'name' => $req->cp_name,
                'email' => $req->cp_email,
                'phone' => $req->cp_phone,
                'type' => 'event',
                'id_type' => $id,
            ]);
        }

        for ($i = 0; $i < count($req->id_prod_cat); $i++) {
            $var = $req->id_prod_cat[$i];
            $idn = DB::table('event_detail_kategori')->max('id');
            if ($idn) {
                $idn = $idn + 1;
            } else {
                $idn = 1;
            }

            DB::table('event_detail_kategori')->insert([
                'id' => $idn,
                'id_event_detail'    => $id,
                'id_prod_cat'    => $req->id_prod_cat[$i],
                'created_at' => $datenow
            ]);

            $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
                ->where(function ($query) use ($var) {
                    $query->where('id_csc_product', $var)
                        ->orWhere('id_csc_product_level1', $var)
                        ->orWhere('id_csc_product_level2', $var);
                })
                ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
            foreach ($perusahaan as $key) {
                if (!in_array($key->id_itdp_company_user, $array)) {
                    array_push($array, $key->id_itdp_company_user);
                }
            }

            sort($array);
        }


        return redirect('event')->with('success', 'Success Add Data!');
    }

    public function bcevent(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        $eventnya = db::table('event_detail')->where('id', $req->idet)->first();
        $kategoriprodcat = array();

        $kategori = db::select("Select * from event_detail_kategori where id_event_detail = '" . $req->idet . "'");

        //bikin array yang isinya id category dari event terserbut
        for ($i = 0; $i < count($kategori); $i++) {
            array_push($kategoriprodcat, $kategori[$i]->id_prod_cat);
        }

        $array = array();
        //untuk liat all category dipilih gak
        if (in_Array("0", $kategoriprodcat)) {
            $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
                ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
            foreach ($perusahaan as $key) {
                if (!in_array($key->id_itdp_company_user, $array)) {
                    array_push($array, $key->id_itdp_company_user);
                }
            }
        } else {
            for ($i = 0; $i < count($kategori); $i++) {
                $var = $kategori[$i]->id_prod_cat;

                $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
                    ->where(function ($query) use ($var) {
                        $query->where('id_csc_product', $var)
                            ->orWhere('id_csc_product_level1', $var)
                            ->orWhere('id_csc_product_level2', $var);
                    })
                    ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
                foreach ($perusahaan as $key) {
                    if (!in_array($key->id_itdp_company_user, $array)) {
                        array_push($array, $key->id_itdp_company_user);
                    }
                }
            }
        }
        sort($array);
        for ($user = 0; $user < count($array); $user++) {
            //            $pengirim = DB::table('itdp_admin_users')->where('id',$id_user)->first();
            $account_penerima = DB::table('itdp_company_users')->where('id', $array[$user])->first();
            if ($account_penerima) {
                $profile_penerima = DB::table('itdp_profil_eks')->where('id', $account_penerima->id_profil)->first();
                if ($profile_penerima) {
                    $notif = DB::table('notif')->insert([
                        'dari_nama' => "Super Admin",
                        'dari_id' => "1",
                        'untuk_nama' => $profile_penerima->company,
                        'untuk_id' => $array[$user],
                        'keterangan' => 'New Event from Super Admin with Title  "' . $eventnya->event_name_en . '"',
                        'url_terkait' => 'event/show_detail',
                        'status_baca' => 0,
                        'waktu' => date('Y-m-d H:i:s'),
                        'id_terkait' => $req->idet,
                        'to_role' => 2
                    ]);
                }

                $data = [
                    'email' => $profile_penerima->email,
                    'company' => $profile_penerima->company,
                    'pengirim' => "Super Admin",
                    'bu' => $profile_penerima->badanusaha,
                ];

                Mail::send('Event.mail.emailaddevent', $data, function ($mail) use ($data) {
                    $mail->to($data['email']);
                    $mail->subject('Event Baru');
                });
            }
        }
        $udpate = DB::select("update event_detail set status_bc='1' where id='" . $req->idet . "'");
        return redirect('event')->with('success', 'Success Broadcast Event');
        /*
		for ($i=0; $i < count($req->id_prod_cat) ; $i++) { 
        	$var=$req->id_prod_cat[$i];
        	$idn=DB::table('event_detail_kategori')->max('id');
        	if($idn){ $idn = $idn+1; } else { $idn = 1; }

	        DB::table('event_detail_kategori')->insert([
	        	'id' => $idn,
	        	'id_event_detail'	=> $id,
				'id_prod_cat'	=> $req->id_prod_cat[$i],
	        	'created_at' => $datenow
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

	        sort($array);
	        for ($user=0; $user < count($array) ; $user++) {
	        	$pengirim = DB::table('itdp_admin_users')->where('id',$id_user)->first();
	        	$account_penerima = DB::table('itdp_company_users')->where('id',$array[$user])->first();
				if(count($account_penerima) != 0){
	        	$profile_penerima = DB::table('itdp_profil_eks')->where('id',$account_penerima->id_profil)->first();
                if($profile_penerima){
    	        	$notif = DB::table('notif')->insert([
    		            'dari_nama' => $pengirim->name,
    		            'dari_id' => $pengirim->id,
    		            'untuk_nama' => $profile_penerima->company,
    		            'untuk_id' => $array[$user],
    		            'keterangan' => 'New Event from '.$pengirim->name.' with Title  "'.$req->eventname_en.'"',
    		            'url_terkait' => 'event/show/read',
    		            'status_baca' => 0,
    		            'waktu' => date('Y-m-d H:i:s'),
    		            'id_terkait' => $id,
    		            'to_role' => 2
    		        ]);
                }

                $data = [
                    'email' => $profile_penerima->email,
                    'company' =>$profile_penerima->company,
                    'pengirim' => $pengirim->name,
                ];

                Mail::send('Event.mail.emailaddevent', $data, function ($mail) use ($data) {
                    $mail->to($data['email']);
                    $mail->subject('Event Baru');
                });
				}
				
	        }

        }
		*/
    }

    public function edit($id)
    {
        $url_update = '/event/update/' . $id;
        $pageTitle = 'Edit Event';
        $page = 'edit';
        $e_detail = DB::table('event_detail')->where('id', $id)->first();
        $cp = DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->first();
        $ex = explode(' ', $e_detail->start_date);
        $sd = $ex[0];
        $ex2 = explode(' ', $e_detail->end_date);
        $se = $ex2[0];
        $ex3 = explode(' ', $e_detail->limit);
        $limit = $ex3[0];

        $lang = Lang::getLocale();
        if ($lang == "en") {
            $lang_e_organizer = "name_en";
            $lang_e_place = "name_en";
            $lang_e_comodity = "comodity_en";
        } else if ($lang == "in") {
            $lang_e_organizer = "name_in";
            $lang_e_place = "name_in";
            $lang_e_comodity = "comodity_in";
        } else {
            $lang_e_organizer = "name_chn";
            $lang_e_place = "name_chn";
            $lang_e_comodity = "comodity_en";
        }

        $e_organizer = DB::table('event_organizer')->orderby($lang_e_organizer, 'asc')->get();
        $e_palce = DB::table('event_place')->orderby($lang_e_place, 'asc')->get();
        $e_comodity = DB::table('event_comodity')->orderby($lang_e_comodity, 'asc')->get();
        $country = DB::table('mst_country')->orderby('country', 'asc')->get();
        // $prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

        return view('Event.create', compact('pageTitle', 'url_update', 'page', 'e_detail', 'e_organizer', 'e_palce', 'e_comodity', 'sd', 'se', 'cp', 'country', 'limit'));
    }

    public function update($id, Request $req)
    {
        //admin
        $id_user = Auth::user()->id;
        $array = array();
        $datenow = date("Y-m-d H:i:s");

        $dtawal = DB::table('event_detail')->where('id', $id)->first();

        $destination = 'uploads\Event\Image\\' . $id;
        if ($req->hasFile('image_1')) {
            $file1 = $req->file('image_1');
            $nama_file1 = time() . '_' . $req->eventname_en . '_' . $req->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        } else {
            $nama_file1 = $dtawal->image_1;
        }

        if ($req->hasFile('image_2')) {
            $file2 = $req->file('image_2');
            $nama_file2 = time() . '_' . $req->eventname_en . '_' . $req->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        } else {
            $nama_file2 = $dtawal->image_2;
        }

        if ($req->hasFile('image_3')) {
            $file3 = $req->file('image_3');
            $nama_file3 = time() . '_' . $req->eventname_en . '_' . $req->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        } else {
            $nama_file3 = $dtawal->image_3;
        }

        if ($req->hasFile('image_4')) {
            $file4 = $req->file('image_4');
            $nama_file4 = time() . '_' . $req->eventname_en . '_' . $req->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        } else {
            $nama_file4 = $dtawal->image_4;
        }

        if ($req->eventorgnzr_en == '|adding_eo|') {
            $id_eo = DB::table('event_organizer')->max('id') + 1;
            DB::table('event_organizer')->insert([
                'id' => $id_eo,
                'name_en' => $req->eo_en,
                'name_in' => $req->eo_in,
                'name_chn' => $req->eo_chn
            ]);
        } else {
            $id_eo = $req->eventorgnzr_en;
        }

        if ($req->eventplace_en == '|adding_place|') {
            $id_place = DB::table('event_place')->max('id') + 1;
            DB::table('event_place')->insert([
                'id' => $id_place,
                'name_en' => $req->plc_en,
                'name_in' => $req->plc_in,
                'name_chn' => $req->plc_chn
            ]);
        } else {
            $id_place = $req->eventplace_en;
        }

        DB::table('event_detail')->where('id', $id)->update([
            'start_date'    => $req->s_date,
            'end_date'    => $req->e_date,
            'event_name_en'    => $req->eventname_en,
            'event_name_in'    => $req->eventname_in,
            'event_name_chn'    => $req->eventname_chn,
            'event_type_en'    => $req->eventype_en,
            'event_type_in'    => $req->eventype_in,
            'event_type_chn'    => $req->eventype_chn,
            'id_event_organizer'    => $id_eo,
            'event_organizer_text_en'    => $req->eot_en,
            'even_organizer_text_in'    => $req->eot_in,
            'even_organizer_text_chn'    => $req->eot_chn,
            'id_event_place'    => $id_place,
            'event_place_text_en'    => $req->ept_en,
            'event_place_text_in'    => $req->ept_in,
            'event_place_text_chn'    => $req->ept_chn,
            'image_1'    => $nama_file1,
            'image_2'    => $nama_file2,
            'image_3'    => $nama_file3,
            'image_4'    => $nama_file4,
            'website'    => $req->website,
            'jenis_en'    => $req->jenis_en,
            'jenis_in'    => $req->jenis_in,
            'jenis_chn'    => $req->jenis_chn,
            'event_comodity'    => $req->eventcomodity,
            'event_scope_en'    => $req->es_en,
            'event_scope_in'    => $req->es_in,
            'event_scope_chn'    => $req->es_chn,
            'id_prod_cat'    => 0,
            'country'   => $req->country,
            'status_en'    => $req->status,
            'reg_date' => $req->registration_date,
            'updated_at' => $datenow,
            'open' => $req->open,
            'limit' => ($req->open) ? $req->limit : null,
            'description' => $req->desc,
        ]);

        $cp = DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->first();
        if ($cp) {
            DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->update([
                'name' => $req->cp_name,
                'email' => $req->cp_email,
                'phone' => $req->cp_phone,
            ]);
        } else {
            $idp = DB::table('contact_person')->max('id') + 1;
            DB::table('contact_person')->insert([
                'id' => $idp,
                'name' => $req->cp_name,
                'email' => $req->cp_email,
                'phone' => $req->cp_phone,
                'type' => 'event',
                'id_type' => $id,
            ]);
        }


        DB::table('event_detail_kategori')->where('id_event_detail', $id)->delete();
        for ($i = 0; $i < count($req->id_prod_cat); $i++) {
            $idn = DB::table('event_detail_kategori')->max('id');
            if ($idn) {
                $idn = $idn + 1;
            } else {
                $idn = 1;
            }

            DB::table('event_detail_kategori')->insert([
                'id' => $idn,
                'id_event_detail'    => $id,
                'id_prod_cat'    => $req->id_prod_cat[$i],
                'created_at' => $datenow
            ]);
        }
        return redirect('event')->with('success', 'Success Update Data!');
    }

    public function delete($id)
    {
        DB::table('event_detail')->where('id', $id)->delete();
        DB::table('event_detail_kategori')->where('id_event_detail', $id)->delete();
        return redirect('event')->with('error', 'Success Delete Data');
    }

    public function show($id)
    {
        $pageTitle = 'Show Event';
        $page = 'show';
        $e_detail = DB::table('event_detail')->where('id', $id)->first();
        $cp = DB::table('contact_person')->where('type', 'event')->where('id_type', $id)->first();
        $ex = explode(' ', $e_detail->start_date);
        $sd = $ex[0];
        $ex2 = explode(' ', $e_detail->end_date);
        $se = $ex2[0];

        $e_organizer = DB::table('event_organizer')->orderby('id', 'asc')->get();
        $e_palce = DB::table('event_place')->orderby('id', 'asc')->get();
        $e_comodity = DB::table('event_comodity')->orderby('id', 'asc')->get();
        $prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

        return view('Event.create', compact('pageTitle', 'page', 'e_detail', 'e_organizer', 'e_palce', 'e_comodity', 'prod_cat', 'sd', 'se', 'cp'));
    }

    public function show_company($id)
    {
        $pageTitle = 'Show Event';
        $list = DB::table('notif')->where('url_terkait', 'event/show/read')->Where('id_terkait', $id)->where('status', '!=', null)->distinct()->get(['id_terkait', 'untuk_id', 'untuk_nama', 'waktu']);
        $listnono = DB::table('event_company_add')->where('id_event_detail', $id)->get();
        return view('Event.show_company', compact('pageTitle', 'list', 'listnono'));
    }

    public function show_detail($id)
    {
        if (Auth::user()) {
            if (Auth::user()->id_group == 1) {
                $pageTitle = 'Show Event';
                $detail = DB::table('event_detail')->where('id', $id)->first();
                return view('Event.show_detail', compact('pageTitle', 'detail'));
            } else {
                return redirect('/home');
            }
        } else if (Auth::guard('eksmp')->user()) {
            $pageTitle = 'Show Event';
            $detail = DB::table('event_detail')->where('id', $id)->first();
            $id_user = strval(Auth::guard('eksmp')->user()->id);
            return view('Event.show_detail', compact('pageTitle', 'detail', 'id_user'));
        } else {
            return redirect('/login');
        }
    }

    public function search(Request $req)
    {
        $pageTitle = "Event";
        $id_user = '0';
        if (Auth::guard('eksmp')->user() != '') {
            $id_user = strval(Auth::guard('eksmp')->user()->id);
        }
        $q = $req->q;
        if ($q != "") {
            $e_detail = EventDetail::with('participants')->where('event_name_en', 'ILIKE', '%' . $q . '%')->orWhere('created_by', $id_user)->orderby('id', 'asc')->paginate(12)->setPath('');
            $pagination = $e_detail->appends(array('q' => $req->q));
            $e_detail->appends($req->only('q'));
            if (count($e_detail) > 0) {
                return view('Event.index', compact('pageTitle', 'e_detail', 'q'));
            } else {
                return view('Event.index', compact('pageTitle', 'e_detail', 'q'))->withMessage('No Details found. Try to search again !');
            }
        } else {
            return redirect('/event');
        }
    }

    public function search_eksportir(Request $req)
    {
        $pageTitle = "Event";
        $eq = $req->eq;
        if ($eq != "") {
            $e_detail = EventDetail::with('participants')->where('event_name_en', 'ILIKE', '%' . $eq . '%')->orderby('id', 'asc')->paginate(12)->setPath('');
            $pagination = $e_detail->appends(array('eq' => $req->eq));
            $e_detail->appends($req->only('eq'));
            if (count($e_detail) > 0) {
                return view('Event.index_eksportir', compact('pageTitle', 'e_detail'));
            } else {
                return view('Event.index_eksportir', compact('pageTitle', 'e_detail'))->withMessage('No Details found. Try to search again !');
            }
        } else {
            return redirect('/event');
        }
    }

    public function getParticipants(Request $request)
    {
        $dataEvent = EventDetail::with('participants', 'participants.supplier', 'participants.buyer', 'participants.supplier.profile', 'participants.buyer.profile_buyer')->whereId($request->event_id)->first();
        $data = [];
        foreach ($dataEvent->participants as $key => $value) {
            $data[$key]['no'] = $key + 1;
            if ($value->supplier != '') {
                $data[$key]['company'] = $value->supplier->profile->company;
                $data[$key]['id_profile'] = $value->supplier->id_profil;
                $data[$key]['id'] = $value->supplier->id;
                $data[$key]['type'] = 'Supplier';
                $data[$key]['email'] = $value->supplier->email;
                $data[$key]['phone'] = $value->supplier->profile->phone;
                $data[$key]['contact_person'] = '';
                $data[$key]['created_at'] = date('d M Y H:i:s', strtotime($value->created_at));
                if (count($value->supplier->profile->contact_person) > 0) {
                    $array_cp = array_column($value->supplier->profile->contact_person->toArray(), 'name');
                    $data[$key]['contact_person'] = implode(', ', $array_cp);
                }
            } elseif ($value->buyer != '') {
                $data[$key]['company'] = $value->buyer->profile_buyer->company;
                $data[$key]['id_profile'] = $value->buyer->id_profil;
                $data[$key]['id'] = $value->buyer->id;
                $data[$key]['type'] = 'Buyer';
                $data[$key]['email'] = $value->buyer->email;
                $data[$key]['phone'] = $value->buyer->profile_buyer->phone;
                $data[$key]['created_at'] = date('d M Y H:i:s', strtotime($value->created_at));
                $data[$key]['contact_person'] = '';
            } else if ($value->supplier == '' && $value->buyer == '') {
                $data[$key]['company'] = '';
                $data[$key]['id_profile'] = '';
                $data[$key]['id'] = '';
                $data[$key]['type'] = '';
                $data[$key]['email'] = '';
                $data[$key]['phone'] = '';
                $data[$key]['created_at'] = date('d M Y H:i:s', strtotime(now()));
                $data[$key]['contact_person'] = '';
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ], 200);
    }

    public function getEventOrg(Request $req)
    {
        $id = $req->id;
        $data = DB::table('event_organizer')->where('id', $id)->first();
        echo json_encode($data);
    }
    public function getEventPlace(Request $req)
    {
        $id = $req->id;
        $data = DB::table('event_place')->where('id', $id)->first();
        echo json_encode($data);
    }

    public function updatestatjoin(Request $req)
    {
        $id = $req->id;
        $id_user = Auth::guard('eksmp')->user()->id;
        DB::table('notif')->where('untuk_id', $id_user)->where('id_terkait', $id)->update([
            'status' => 1
        ]);
        return redirect('/event');
    }

    public function updatestatver(Request $req)
    {
        $id = $req->id;
        $untuk_id = $req->untuk_id;
        DB::table('notif')->where('untuk_id', $untuk_id)->where('id_terkait', $id)->update([
            'status' => 2
        ]);
        return redirect('/event/show_company/' . $id);
    }

    public function store_company(Request $req)
    {
        $datenow = date("Y-m-d H:i:s");
        $id_user = Auth::guard('eksmp')->user()->id;
        DB::table('event_company_add')->insert([
            'id_itdp_profil_eks'    => $id_user,
            'id_event_detail'        => $req->id_event,
            'status'                => 1,
            'waktu'                    => $datenow
        ]);
        return redirect('/front_end/event');
    }

    public function updatestatcompany(Request $req)
    {
        $id_user = $req->id_itdp_profil_eks;
        $id = $req->id;

        DB::table('event_company_add')->where('id_itdp_profil_eks', $id_user)->where('id_event_detail', $id)->update([
            'status' => 2
        ]);
        return redirect('/event/show_company/' . $id);
    }

    public function comodity(Request $request)
    {
        $comodity = DB::table('event_comodity')
            ->select('id', 'comodity_en')
            ->orderby('comodity_en', 'asc');
        if (isset($request->q)) {
            $comodity->where('comodity_en', 'ILIKE', '%' . $request->q . '%');
        } else if (isset($request->code)) {
            $comodity->where('id', $request->code);
        } else {
            $comodity->limit(10);
        }
        return response()->json($comodity->get());
    }

    public function getDataInterest($id)
    {
        $interest = DB::table('event_interest')->where('id_event', $id)->orderby('created_at', 'desc')->get();

        return \Yajra\DataTables\DataTables::of($interest)
            ->addIndexColumn()
            ->addColumn('company', function ($var) {
                return '<div align="left">' . getProfileCompany($var->id_profile) . '</div>';
            })
            ->addColumn('interest', function ($data) {
                return date('d F Y', strtotime($data->created_at)) . ' ( ' . date('H:i', strtotime($data->created_at)) . ' )';
            })
            ->rawColumns(['company'])
            ->make(true);
    }


    public function export_participants(Request $request)
    {
        return Excel::download(new EventParticipantsExport($request->event_id), 'Event_participants_' . mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $request->event_name) . '.xlsx');
    }
}
