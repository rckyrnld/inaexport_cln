<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Lang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class InquiryWakilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        changeStatusInquiry();
    }

    public function index()
    {
        $pageTitle = "Inquiry";
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                return view('inquiry.perwakilan.index', compact('pageTitle'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function getData()
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_br')
                ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
                ->where('type', 'perwakilan')
                ->orderBy('csc_inquiry_br.created_at', 'DESC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('category', function ($mjl) {
                    $category = "-";
                    if($mjl->type == 'perwakilan'){
                        $category = getProductCategoryInquiry($mjl->id);
                        if($category != ''){
                            $category = '<div style="width: 100%" align="left">'.$category.'</div>';
                        } else {
                            $category = '-';
                        }
                    } else {
                        if($mjl->id_csc_prod_cat != NULL){
                            if($mjl->id_csc_prod_cat_level1 != NULL){
                                if($mjl->id_csc_prod_cat_level2 != NULL){
                                    $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level2)->first();
                                    $category = $catprod->nama_kategori_en;
                                }else{
                                    $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level1)->first();
                                    $category = $catprod->nama_kategori_en;
                                }
                            }else{
                                $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat)->first();
                                $category = $catprod->nama_kategori_en;
                            }
                            
                        }
                    }
                    return $category;
                })
                ->addColumn('status', function ($mjl) {
                    $statnya = "-";
                    if($mjl->status != NULL){
                        if($mjl->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $mjl->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
                    }

                    return $statnya;
                })
                ->addColumn('duration', function ($mjl) {
                    $durationnya = "-";
                    if($mjl->duration != "None"){
                        $durationnya = "Valid for ".$mjl->duration;
                    }else{
                        $durationnya = $mjl->duration;
                    }

                    return $durationnya;
                })
                ->addColumn('subject', function ($mjl) {
                    $subyek = "-";
                    if($mjl->subyek_en != NULL){
                        $subyek = $mjl->subyek_en;
                    }

                    return $subyek;
                })
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->date != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->date));
                    }

                    return $datenya;
                })
                ->addColumn('kos', function ($mjl) {
                    $kosnya = "-";
                    if($mjl->jenis_perihal_en != NULL){
                        $kosnya = $mjl->jenis_perihal_en;
                    }

                    return $kosnya;
                })
                ->addColumn('msg', function ($mjl) {
                    $msgnya = "-";
                    if($mjl->messages_en != NULL){
                        $num_char = 70;
                        $text = $mjl->messages_en;
                        if(strlen($text) > 70){
                            $cut_text = substr($text, 0, $num_char);
                            if ($text{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                $cut_text = substr($text, 0, $new_pos);
                            }
                            $msgnya = $cut_text . '...';
                        }else{
                            $msgnya = $text;
                        }
                    }

                    return $msgnya;
                })
                ->addColumn('origin', function ($mjl) {
                    $orginnya = "-";
                    if($mjl->type != NULL){
                        $orginnya = $mjl->type;
                    }

                    return $orginnya;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    if($mjl->status == 0){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/view').'/'.$mjl->id.'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="'.url('/inquiry_perwakilan/delete').'/'.$mjl->id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure?\')" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </center>';
                    }else if($mjl->status == 1){
                        // return '
                        //     <center>
                        //     <button type="button" class="btn btn-warning" style="color: white;" onclick="broadcastInquiry(\''.$mjl->subyek_en.'|'.$mjl->id.'\')" title="Broadcast"><i class="fa fa-bullhorn" aria-hidden="true"></i> </button>
                        //     <a href="'.url('/inquiry_perwakilan/edit').'/'.$mjl->id.'" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        //     </center>';
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/edit').'/'.$mjl->id.'" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </center>';
                    }else if($mjl->status == 2 || $mjl->status == 5){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/view').'/'.$mjl->id.'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/view').'/'.$mjl->id.'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="'.url('/inquiry_perwakilan/delete').'/'.$mjl->id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure?\')" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </center>';
                    }else{
                        return '
                            <center>
                            <button type="button" class="btn btn-sm btn-danger">'.Lang::get('button-name.noact').'</button>
                            </center>';
                    }
                })
                ->rawColumns(['action', 'msg', 'category'])
                ->make(true);
        }
    }

    public function create()
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $pageTitle = "Inquiry";
                $mode = "add";
                $url = "/inquiry_perwakilan/store";
                $data = NULL;

                //get country id
                $wakil = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                if ($wakil->id_admin_dn == 0) {
                    $lndn = DB::table('itdp_admin_ln')->where('id', $wakil->id_admin_ln)->first();
                }else{
                    $lndn = DB::table('itdp_admin_dn')->where('id', $wakil->id_admin_dn)->first();
                }
                $id_country = $lndn->id_country;
                
                return view('inquiry.perwakilan.form', compact('pageTitle', 'mode', 'url', 'id_country', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $type = "perwakilan";

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
                    'id_pembuat' => $id_user,
                    'type' => $type,
                    'id_mst_country' => $request->id_country,
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

                return redirect('/inquiry_perwakilan')->with('success','Success Add Data');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function edit($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $pageTitle = "Inquiry";
                $mode = "edit";
                $url = "/inquiry_perwakilan/update/".$id;
                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
                $id_country = $data->id_mst_country;
                
                return view('inquiry.perwakilan.form', compact('pageTitle', 'mode', 'url', 'id_country', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function update($id, Request $request)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $type = "perwakilan";
                $datenow = date("Y-m-d H:i:s");

                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

                $destination= 'uploads\Inquiry\\'.$data->id;
                if($request->hasFile('file')){ 
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                    Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
                }else{
                    $nama_file1 = $data->file;
                }

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

                $save = DB::table('csc_inquiry_br')->where('id', $id)->update([
                    'id_pembuat' => $id_user,
                    'type' => $type,
                    'id_mst_country' => $request->id_country,
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
                    'file' => $nama_file1,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $duration,
                    'updated_at' => $datenow,
                ]);

                return redirect('/inquiry_perwakilan')->with('success','Success Update Data');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function broadcasting(Request $request)
    {
       //broadcast inquiry dari perwakilan
        date_default_timezone_set('Asia/Jakarta');
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $id_inquiry = $request->idnya;
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

//                dd();
                
                sort($array);
                $users = [];
                for ($k=0; $k <count($array) ; $k++) { 
                    $untuk = DB::table('itdp_company_users')->where('id', $array[$k])->first();
//                    dd($untuk);
                    if($untuk != NULL){
                        $company = DB::table('itdp_profil_eks')->where('id', $untuk->id_profil)->first();
                        $save = DB::table('csc_inquiry_broadcast')->insert([
                            'id_inquiry' => $id_inquiry,
                            'id_itdp_company_users' => $array[$k],
                            'status' => 1,
                            'created_at' => $datenow,
                        ]);

                        $notif = DB::table('notif')->insert([
                            'dari_nama' => getPerwakilanName($id_user),
                            'dari_id' => $id_user,
                            'untuk_nama' => getCompanyName($array[$k]),
                            'untuk_id' => $array[$k],
                            'keterangan' => 'New Inquiry By '.getPerwakilanName($id_user).' with Subject  "'.$inquiry->subyek_en.'"',
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

                        array_push($users, $untuk->email);
                    }
                }




                //Tinggal Ganti Email1 dengan email kemendag

//                $data = [
//                    'type' => "eksportir",
//                    'company' => "Eksporter",
//                    'dari' => "representative"
//                ];
//
//                Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data, $users) {
//                    $mail->subject('Inquiry Information');
//                    $mail->to($users);
//                });
//
//                //Notif ke Admin
//                $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
//                $users_admin = [];
//                array_push($users_admin, env('MAIL_USERNAME','no-reply@inaexport.id'));
//                foreach ($admin as $adm) {
//                    array_push($users_admin, $adm->email);
//                }


//                //Notif ke Admin
//                $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
//                $users_admin = [];
//                array_push($users_admin, "kementerianperdagangan.max@gmail.com");
//                foreach ($admin as $adm) {
//                    array_push($users_admin, $adm->email);
//                }
//
//                //Notif email ke admin
//                $dataadmin = [
//                    'pembuat' => getPerwakilanName($id_user),
//                    'dari' => "Perwakilan"
//                ];
//
//                Mail::send('inquiry.mail.SendToAdmin', $dataadmin, function ($mail) use ($dataadmin, $users_admin) {
//                    $mail->subject('Inquiry Information');
//                    $mail->to($users_admin);
//                });

                return redirect('/inquiry_perwakilan')->with('success','Success Broadcast Data');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function view($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
                $pageTitle = "Inquiry";
                $mode = "view";
                $url = "/inquiry_perwakilan/update/".$id;
                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
                $id_country = $data->id_mst_country;
                
                return view('inquiry.perwakilan.view', compact('pageTitle', 'mode', 'url', 'id_country', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function delete($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();

            //delete chatting
            $del1 = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'perwakilan')
                ->delete();

            //delete broadcasting
            $del2 = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->delete();

            //delete broadcasting
            $del3 = DB::table('csc_inquiry_br')->where('id', $id)->delete();
            
            return redirect('/inquiry_perwakilan/')->with('error','Success Delete Data');
        }else{
            return redirect('/home');
        }
    }

    public function getDataCompany($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_broadcast')
                ->where('id_inquiry', '=', $id)
                ->orderBy('id_itdp_company_users', 'ASC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('company', function ($mjl) {
                    $company = "-";
                    if($mjl->id_itdp_company_users != NULL){
                        $company = getCompanyName($mjl->id_itdp_company_users);
                    }
                    return '<div align="left">'.$company.'</div>';
                })
                ->addColumn('status', function ($mjl) {
                    $statnya = "-";
                    if($mjl->status != NULL){
                        if($mjl->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $mjl->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
                    }

                    if($mjl->status == 1){
                        $statnya = 'pending';
                    }

                    return $statnya;
                })
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->date != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->date));
                    }

                    return $datenya;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    if($mjl->status == 0){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/verifikasi').'/'.$mjl->id.'" class="btn btn-sm btn-success">'.Lang::get('button-name.verified').'</a>
                            </center>';
                    }else if($mjl->status == 1){
                        return '';
                    }else if($mjl->status == 2){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/chatting').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white;"><i class="fa fa-comments-o" aria-hidden="true"></i> '.Lang::get('button-name.chat').' <span class="badge badge-danger">'.$this->getCountChat($mjl->id_inquiry, $id_user, $mjl->id).'</span></a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/view_detail').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            <a href="'.url('/inquiry_perwakilan/delete_detail').'/'.$mjl->id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure?\')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </center>';
                    }else if($mjl->status == 5){
                        return '
                            <center>
                            <a href="'.url('/inquiry_perwakilan/view_detail').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            </center>';
                    }else{
                        return '
                            <center>
                            <button type="button" class="btn btn-sm btn-danger">'.Lang::get('button-name.noact').'</button>
                            </center>';
                    }
                })
                ->rawColumns(['action', 'msg', 'company'])
                ->make(true);
        }
    }

    function getCountChat($id, $receiver, $id_broadcast)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $id_broadcast)->where('type', 'perwakilan')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function verifikasi($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 4){
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
                }

                return redirect('/inquiry_perwakilan/view/'.$data->id_inquiry);
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function chatting($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            // $cekfile = DB::table('csc_chatting_inquiry')
            //     ->where('id_inquiry', $data->id_inquiry)
            //     ->where('type', 'perwakilan')
            //     ->where('sender', $data->id_itdp_company_users)
            //     ->where('receive', $inquiry->id_pembuat)
            //     ->whereNull('messages')
            //     ->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('sender', $data->id_itdp_company_users)
                ->where('receive', $inquiry->id_pembuat)
                ->where('id_broadcast_inquiry', $id)
                ->update([
                    'status' => 1,
                ]);
            
            return view('inquiry.perwakilan.chatting', compact('pageTitle','inquiry', 'messages', 'id_user','data','id'));
        }else{
            return redirect('/home');
        }
    }
	
	public function refreshchatinq2($id)
    {
			$id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();
		return view('buying-request.refresh5',compact('id','messages','id_user'));
	}
	

    public function sendChat(Request $request)
    {
        //notif ke eksportir saat admin atau perwakilan send chat tulisan
		date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $id_broadcast = $request->idbroadcast;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id_inquiry' => $id,
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'perwakilan',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if($save){
            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getPerwakilanName($sender),
                'dari_id' => $sender,
                'untuk_nama' => getCompanyName($receiver),
                'untuk_id' => $receiver,
                'keterangan' => 'New Message from '.getPerwakilanName($sender).' about Inquiry '.$data->subyek_en,
                'url_terkait' => 'inquiry/chatting',
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => 2,
                'id_terkait' => $id
            ]);

            $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->username;
            //Tinggal Ganti Email1 dengan email kemendag
            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => "perwakilan",
                'sender' => getPerwakilanName($sender),
                'receiver' => getCompanyName($receiver),
                'subjek' => $data->subyek_en,
                'id' => $id,
                'bu' => getExBadan($receiver),
            ];

            Mail::send('inquiry.mail.sendChat', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Chatting Information');
            });
            return 1;
        }else{
            return 0;
        }
    }

    public function fileChat(Request $request)
    {
        //Notif ke eksportir saat admin/perwakilan kirim bukti bayar
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->id_inquiry;
        $id_broadcast = $request->id_broadcast;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $msg = $request->msgfile;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        $save = DB::table('csc_chatting_inquiry')->insertGetId([
            'id_inquiry' => $id,
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'perwakilan',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        //upload file
        $nama_file1 = NULL;
        $destination= 'uploads\ChatFileInquiry\\'.$save;
        if($request->hasFile('upload_file')){ 
            $file1 = $request->file('upload_file');
            $nama_file1 = time().'_'.$request->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $savefile = DB::table('csc_chatting_inquiry')->where('id', $save)->update([
            'file' => $nama_file1,
        ]);

        //Notif sistem
        $notif = DB::table('notif')->insert([
            'dari_nama' => getPerwakilanName($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyName($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Payment Information from '.getPerwakilanName($sender).' about Inquiry '.$data->subyek_en,
            'url_terkait' => 'inquiry/chatting',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => 2,
            'id_terkait' => $id
        ]);

        $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
        $email = $users->email;
        $username = $users->username;
        if($users){
            $company = DB::table('itdp_profil_eks')->where('id', $users->id_profil)->first();
            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => "perwakilan",
                'sender' => getPerwakilanName($sender),
                'receiver' => getCompanyName($receiver),
                'subjek' => $data->subyek_en,
                'id' => $id,
                'bu' => $company->badanusaha,
            ];

            Mail::send('inquiry.mail.sendProve', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Payment Information');
            });
        }
        //Tinggal Ganti Email1 dengan email kemendag


        return redirect('/inquiry_perwakilan/chatting/'.$id_broadcast);
        
    }

    public function view_detail($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            $comsg = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('sender', $data->id_itdp_company_users)
                ->where('receive', $inquiry->id_pembuat)
                ->where('id_broadcast_inquiry', $id)
                ->update([
                    'status' => 1,
                ]);
            
            return view('inquiry.perwakilan.viewdetail', compact('pageTitle','inquiry', 'messages', 'id_user','data', 'comsg'));
        }else{
            return redirect('/home');
        }
    }

    public function delete_detail($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();

            //delete chatting
            $del1 = DB::table('csc_chatting_inquiry')->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'perwakilan')
                ->where('id_broadcast_inquiry', $id)
                ->delete();

            $del2 = DB::table('csc_inquiry_broadcast')->where('id', $id)->delete();
            
            return redirect('/inquiry_perwakilan/view/'.$inquiry->id);
        }else{
            return redirect('/home');
        }
    }
    
    function setValue($value)
    {
        $value = str_replace('.', '', $value);

        return (int)$value;
    }
}
