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
use App\Models\TransaksiInBR;

class InquiryEksController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:eksmp');
        changeStatusInquiry();
    }

    public function index()
    {
        $pageTitle = "Inquiry";
        if(Auth::guard('eksmp')->user()){
            //Read Notification
            $id_user = Auth::guard('eksmp')->user()->id;
            DB::table('notif')->where('url_terkait', 'inquiry')->where('untuk_id', $id_user)->where('to_role', 2)->update([
                'status_baca' => 1,
            ]);
            return view('inquiry.eksportir.index', compact('pageTitle'));
        }else{
            return redirect('/home');
        }
    }

    public function countData()
    {
        $jumlah = 0;
        
        if(Auth::guard('eksmp')->user()) {
            if(Auth::guard('eksmp')->user()->id_role == 2) {
                $jumlah = DB::table('csc_buying_request')
                    ->join('csc_buying_request_join', 'csc_buying_request_join.id_br', '=', 'csc_buying_request.id')
                    ->where('csc_buying_request_join.id_eks', Auth::guard('eksmp')->user()->id)
                    ->where('csc_buying_request_join.status_join', 0)
                    ->count();
            } elseif(Auth::guard('eksmp')->user()->id_role == 3) {
                $jumlah = DB::table('csc_buying_request')
                    ->join('csc_buying_request_join', 'csc_buying_request_join.id_br', '=', 'csc_buying_request.id')
                    ->where('csc_buying_request.id_pembuat', Auth::guard('eksmp')->user()->id)
                    ->where('csc_buying_request.by_role', Auth::guard('eksmp')->user()->id_role)
                    ->where('csc_buying_request_join.status_join', 1)
                    ->count();
            }
        } elseif(Auth::user()) {
            if(Auth::user()->id_group == 4) {
                $jumlah = DB::table('csc_buying_request')
                    ->join('csc_buying_request_join', 'csc_buying_request_join.id_br', '=', 'csc_buying_request.id')
                    ->where('csc_buying_request.id_pembuat', Auth::user()->id)
                    ->where('csc_buying_request.by_role', Auth::user()->id_group)
                    ->where('csc_buying_request_join.status_join', 1)
                    ->count();
            }
        }

        return $jumlah;
    }
    
    public function getData($jenis)
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
//            dd($id_user);
//            dd($jenis);

            if($jenis == 1){
                $user = [];
                $importer = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->join('itdp_company_users','itdp_company_users.id','csc_inquiry_br.id_pembuat')
                    ->join('itdp_profil_imp','itdp_company_users.id_profil','itdp_profil_imp.id')
                    ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product,itdp_company_users.status as creater_status,itdp_profil_imp.company as created_by')
                    ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                    ->where('csc_inquiry_br.status', 1)
                    // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('csc_inquiry_br.created_at', 'DESC')
                    ->get();
//                dd($importir);
                foreach ($importer as $key) {
                    array_push($user, $key);
                }
                $tipe_user = 'admin';
                $tipe_user2 = 'perwakilan';
//                dd($user);
                $perwakilan = DB::table('csc_inquiry_br as a')
                    ->join('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                    ->join('itdp_admin_users as c','a.id_pembuat','c.id')
                    ->selectRaw("a.id, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.status,(CASE WHEN a.type = 'admin' THEN 'Admin' ELSE 'Perwakilan' END) AS created_by, (CASE WHEN a.type = 'admin' THEN 2 ELSE 2 END) AS creater_status")
                    ->where('b.id_itdp_company_users', '=', $id_user)
                    ->where('b.status', 1)
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('b.created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
            }else{
                $user = [];
                $importer = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->join('itdp_company_users','itdp_company_users.id','csc_inquiry_br.id_pembuat')
                    ->join('itdp_profil_imp','itdp_company_users.id_profil','itdp_profil_imp.id')
                    ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product,itdp_company_users.status as creater_status,itdp_profil_imp.company as created_by')
                    // ->select('csc_inquiry_br.*', 'csc_product_single.id as id_product','itdp_profil_imp.*')
                    ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                    ->where('csc_inquiry_br.status', '!=', 1)
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('csc_inquiry_br.created_at', 'DESC')
                    ->get();
                foreach ($importer as $key) {
                    array_push($user, $key);
                }
                $tipe_user = 'admin';
                $tipe_user2 = 'perwakilan';
                $perwakilan = DB::table('csc_inquiry_br as a')
                    ->join('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                    ->join('itdp_admin_users as c','a.id_pembuat','c.id')
                    ->selectRaw("a.id, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.status,(CASE WHEN a.type = 'admin' THEN 'Admin' ELSE 'Perwakilan' END) AS created_by, (CASE WHEN a.type = 'admin' THEN 2 ELSE 2 END) AS creater_status")
                    ->where('b.id_itdp_company_users', '=', $id_user)
                    ->where('b.status', '!=', 1)
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('b.created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
            }

        //    dd($user);
            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('category', function ($mjl) {
                    $category = "-";
                    if($mjl->type == 'importir'){
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
                    } else {
                        $category = getProductCategoryInquiry($mjl->id);
                        $category = '<div style="height: 100%; width: 100%;" align="left">'.$category.'</div>';
                    }
                    return "<div align='left'>".$category."</div>";
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

//                    return $mjl->status;
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

                    return '<div align="left">'.$subyek.'</div>';
                })
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->date != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->date));
                    }

                    return $datenya;
                })
               /* ->addColumn('kos', function ($mjl) {
                    $kosnya = "-";
                    if($mjl->jenis_perihal_en != NULL){
                        $kosnya = $mjl->jenis_perihal_en;
                    }

                    return $kosnya;
                }) */
                ->addColumn('msg', function ($mjl) {
                    $msgnya = "-";
                    if($mjl->messages_en != NULL){
                        $num_char = 70;
                        $text = $mjl->messages_en;
                        if(strlen($text) > 70){
                            $cut_text = substr($text, 0, $num_char);
                            if ($text[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
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
                ->addColumn('created_by', function ($mjl) {
                    $created_by = "-";
                    if($mjl->created_by != NULL){
                        $created_by = $mjl->created_by;
                    }

                    return $created_by;
                })
                ->addColumn('creater_status', function ($mjl) {
                    // $creater_status = "Not Verified";
                    // if($mjl->creater_status != NULL){
                        if($mjl->creater_status == 1){
                            $creater_status = 'Verified';
                        }else if($mjl->creater_status == 0){
                            $creater_status = 'Not Verified';
                        }else if($mjl->creater_status == 2){
                            $creater_status = '-';
                        }
                        // ".$tipe_user."
                        
                    // }

                    return $creater_status;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    if($mjl->status == 0 || $mjl->status == 2){
                        return '
                            <center>
                            <a href="'.url('/inquiry/chatting').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white;" title="'.Lang::get('button-name.chat').'"><i class="fa fa-comments-o" aria-hidden="true"></i> <span class="badge badge-danger">'.$this->getCountChat($mjl->id, $id_user, $mjl->type).'</span></a>
                            </center>';
                    }else if($mjl->status == 1){
                        return '
                            <center>
                            <a href="'.url('/inquiry/joined').'/'.$mjl->id.'" class="btn btn-sm btn-success" style="" title="'.Lang::get('button-name.join').'"><i class="fa fa-plus"></i></a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4 || $mjl->status == 5){
                        return '
                            <center>
                            <a href="'.url('/inquiry/chatting').'/'.$mjl->id.'" class="btn btn-sm btn-info" title="'.Lang::get('button-name.view').'"><i class="fa fa-search" aria-hidden="true"></i> </a>
                            </center>';
                    }else{
                        return '
                            <center>
                            <button type="button" class="btn btn-sm btn-danger">'.Lang::get('button-name.noact').'</button>
                            </center>';
                    }
                })
                ->rawColumns(['action', 'msg', 'category','subject'])
                ->make(true);
        }
    }

    function getCountChat($id, $receiver, $type)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', $type)->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function joined($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            
            return view('inquiry.eksportir.joined', compact('pageTitle','inquiry', 'product'));
        }else{
            return redirect('/home');
        }
    }

    public function accept_chat($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $datenow = date('Y-m-d H:i:s');

            if($data->type == "admin"){
                $rolenya = 1;
            }else if($data->type == "perwakilan"){
                $rolenya = 4;
            }else if($data->type == "importir"){
                $rolenya = 3;
            }

            if($data->type == "importir"){
                $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                    'status' => 0,
                ]);
                $users = DB::table('itdp_company_users')->where('id', $data->id_pembuat)->first();
                $email = $users->email;
                $username = $users->username;

                //Notif sistem
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyNameImportir($data->id_pembuat),
                    'untuk_id' => $data->id_pembuat,
                    'keterangan' => 'Exporter '.getExBadan($id_user).getCompanyName($id_user).' has joined Inquiry '.$data->subyek_en,
                    'url_terkait' => 'front_end/history',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => $rolenya,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
                $data = [
                    'email' => $email,
                    'username' => $username,
                    'type' => "importir",
                    'company' => getCompanyNameImportir($data->id_pembuat),
                    'dari' => "Eksportir",
                    'bu' => getExBadanImportir($data->id_pembuat),
                ];

                Mail::send('inquiry.mail.sendToPembuat2', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Inquiry Information');
                });
            }else if($data->type == "perwakilan" || $data->type == "admin"){
                $inquiry = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->update([
                    'status' => 0,
                ]);

                $users = DB::table('itdp_admin_users')->where('id', $data->id_pembuat)->first();
                $email = $users->email;
                $username = $users->name;
                if($data->type == "perwakilan"){
                    $name = getPerwakilanName($data->id_pembuat);
                    $url_terkait = 'inquiry_perwakilan/view';
                }else{
                    $name = $users->name;
                    $url_terkait = 'inquiry_admin/view';
                }

                //Notif sistem
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => $name,
                    'untuk_id' => $data->id_pembuat,
                    'keterangan' => 'Exporter '.getExBadan($id_user).getCompanyName($id_user).' has joined Inquiry '.$data->subyek_en,
                    'url_terkait' => $url_terkait,
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'id_terkait' => $id,
                    'to_role' => $rolenya,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
                $data = [
                    'email' => $email,
                    'username' => $username,
                    'type' => "importir",
                    'company' => $name,
                    'dari' => "Eksportir"
                ];

                Mail::send('inquiry.mail.sendToPembuat', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Inquiry Information');
                });
            }
            
            return redirect('/inquiry');
        }else{
            return redirect('/home');
        }
    }

    public function chatting($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            if($inquiry->type == "importir"){
                $broadcast = NULL;
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }else if($inquiry->type == "perwakilan" || $inquiry->type == "admin"){
                $broadcast = DB::table('csc_inquiry_broadcast')->where('id_itdp_company_users', $id_user)->where('id_inquiry', $id)->first();
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('id_broadcast_inquiry', $broadcast->id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();    

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }
            
            return view('inquiry.eksportir.chatting', compact('pageTitle','inquiry', 'product', 'messages', 'id_user', 'cekfile', 'broadcast','id'));
        }else{
            return redirect('/home');
        }
    }
	
	public function refreshchatinq3($id)
    {
			$id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            if($inquiry->type == "importir"){
                $broadcast = NULL;
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }else if($inquiry->type == "perwakilan" || $inquiry->type == "admin"){
                $broadcast = DB::table('csc_inquiry_broadcast')->where('id_itdp_company_users', $id_user)->where('id_inquiry', $id)->first();
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('id_broadcast_inquiry', $broadcast->id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();    

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }
		return view('buying-request.refresh6',compact('id','messages','id_user','inquiry'));
	}

    public function sendChat(Request $request)
    {
        //notif ke admin atau eksportir saat eksportir send chat tulisan
		date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;
        $type = $request->typenya;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        if($type == "importir"){
            $save = DB::table('csc_chatting_inquiry')->insert([
                'id_inquiry' => $id,
                'sender' => $sender,
                'receive' => $receiver,
                'type' => $type,
                'messages' => $msg,
                'status' => 0,
                'created_at' => $datenow,
            ]);

            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($sender),
                'dari_id' => $sender,
                'untuk_nama' => getCompanyNameImportir($receiver),
                'untuk_id' => $receiver,
                'keterangan' => 'New Message from '.getExBadan($sender).getCompanyName($sender).' about Inquiry '.$data->subyek_en,
                'url_terkait' => 'front_end/chat_inquiry',
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => 3,
                'id_terkait' => $id
            ]);

            $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->username;
            //Tinggal Ganti Email1 dengan email kemendag
            $data = [
                'email' => $email,
                'username' => $username,
                'type' => $type,
                'sender' => getCompanyName($sender),
                'receiver' => getCompanyNameImportir($receiver),
                'subjek' => $data->subyek_en,
                'id' =>$id,
                'bu' => getExBadan($sender),
                'bur' => getExBadanImportir($receiver),
            ];

            Mail::send('inquiry.mail.sendChat3', $data, function ($mail) use ($data) {
                $mail->to($data['email'], $data['username']);
                $mail->subject('Inquiry Chatting Information');
            });
        }else if($type == "perwakilan" || $type == "admin"){
            $cek = Db::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $sender)->first();
            $save = DB::table('csc_chatting_inquiry')->insert([
                'id_inquiry' => $id,
                'id_broadcast_inquiry' => $cek->id,
                'sender' => $sender,
                'receive' => $receiver,
                'type' => $type,
                'messages' => $msg,
                'status' => 0,
                'created_at' => $datenow,
            ]);

            $untuk_nama = "";
            if($type == "admin"){
                $untuk_nama = getAdminName($receiver);
                $to_role = 1;
                $url_terkait = 'inquiry_admin/chatting';
            }else if($type == "perwakilan"){
                $untuk_nama = getPerwakilanName($receiver);
                $to_role = 4;
                $url_terkait = 'inquiry_perwakilan/chatting';
            }

            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($sender),
                'dari_id' => $sender,
                'untuk_nama' => $untuk_nama,
                'untuk_id' => $receiver,
                'keterangan' => 'New Message from '.getExBadan($sender)." ".getCompanyName($sender).' about Inquiry '.$data->subyek_en,
                'url_terkait' => $url_terkait,
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => $to_role,
                'id_terkait' => $cek->id
            ]);

            $users = DB::table('itdp_admin_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->name;
            //Tinggal Ganti Email1 dengan email kemendag
            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => $type,
                'sender' => getCompanyName($sender),
                'receiver' => $untuk_nama,
                'subjek' => $data->subyek_en,
                'id' =>$cek->id,
                'bu' => getExBadan($sender),
            ];

            Mail::send('inquiry.mail.sendChat2', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Chatting Information');
            });
        }

        if($save){
            return 1;
        }else{
            return 0;
        }
    }

    public function fileChat(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id_user = Auth::guard('eksmp')->user()->id;
        $id = $request->id_inquiry;
        $sender = $request->sender;
        $receiver = $request->receiver;

        $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();

        if($inquiry->type == "importir"){
            $save = DB::table('csc_chatting_inquiry')->insertGetId([
                'id_inquiry' => $id,
                'sender' => $sender,
                'receive' => $receiver,
                'type' => $inquiry->type,
                'status' => 0,
                'created_at' => $datenow,
            ]);

            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($sender),
                'dari_id' => $sender,
                'untuk_nama' => getCompanyNameImportir($receiver),
                'untuk_id' => $receiver,
                'keterangan' => 'Exporter '.getExBadan($sender) .getCompanyName($sender).' Respond Chat in Inquiry '.$inquiry->subyek_en,
                'url_terkait' => 'front_end/chat_inquiry',
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => 3,
                'id_terkait' => $id
            ]);

            $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->username;
            //Tinggal Ganti Email1 dengan email kemendag
            $data = [
                'email' => $email,
                'username' => $username,
                'type' => $inquiry->type,
                'bu'=>getExBadan($sender),
                'sender' => getCompanyName($sender),
                'bur'=>getExBadanImportir($receiver),
                'receiver' => getCompanyNameImportir($receiver),
                'subjek' => $inquiry->subyek_en,
                'id' => $id
            ];

            Mail::send('inquiry.mail.sendChat3', $data, function ($mail) use ($data) {
                $mail->to($data['email'], $data['username']);
                $mail->subject('Inquiry Chatting Information');
            });
        }else if($inquiry->type == "perwakilan" || $inquiry->type == "admin"){
            $cek = Db::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $sender)->first();
            $broadcast = DB::table('csc_inquiry_broadcast')->where('id_itdp_company_users', $id_user)->where('id_inquiry', $id)->first();
            $save = DB::table('csc_chatting_inquiry')->insertGetId([
                'id_inquiry' => $id,
                'id_broadcast_inquiry' => $broadcast->id,
                'sender' => $sender,
                'receive' => $receiver,
                'type' => $inquiry->type,
                'status' => 0,
                'created_at' => $datenow,
            ]);

            $untuk_nama = "";
            if($inquiry->type == "admin"){
                $untuk_nama = getAdminName($receiver);
                $to_role = 1;
                $url_terkait = 'inquiry_admin/chatting';
            }else if($inquiry->type == "perwakilan"){
                $untuk_nama = getPerwakilanName($receiver);
                $to_role = 4;
                $url_terkait = 'inquiry_perwakilan/chatting';
            }

            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($sender),
                'dari_id' => $sender,
                'untuk_nama' => $untuk_nama,
                'untuk_id' => $receiver,
                'keterangan' => 'Exporter '.getExBadan($sender) .getCompanyName($sender).' Respond Chat in Inquiry '.$inquiry->subyek_en,
                'url_terkait' => $url_terkait,
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => $to_role,
                'id_terkait' => $cek->id
            ]);

            $users = DB::table('itdp_admin_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->name;
            //Tinggal Ganti Email1 dengan email kemendag
            $data = [
                'email' => $email,
                'username' => $username,
                'type' => $inquiry->type,
                'sender' => getCompanyName($sender),
                'receiver' => $untuk_nama,
                'subjek' => $inquiry->subyek_en,
                'id' => $cek->id,
                'bu'=> getExBadan($sender)
            ];

            Mail::send('inquiry.mail.sendChat2', $data, function ($mail) use ($data) {
                $mail->to($data['email'], $data['username']);
                $mail->subject('Inquiry Chatting Information');
            });
        }

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

        return redirect('/inquiry/chatting/'.$id); 
        
    }

    public function dealing($id, $status)
    {
        date_default_timezone_set('Asia/Jakarta');
        //notif ke admin dan pembuat inquiry saat ekspoter melakukan dealing.
        $id_user = Auth::guard('eksmp')->user()->id;
        $datenow = date('Y-m-d H:i:s');
        if($status == 1){
            $stat = 3;
        }else{
            $stat = 4;
        }

        $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();

        if($inquiry->type == "perwakilan" || $inquiry->type == "admin"){
            if($stat == 3){
//                dd($inquiry);
                // $updatebr = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->update([
                //     'status' => 4,
                // ]);

                $updatebrm = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->update([
                    'status' => $stat,
                ]);

                $tot_broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->count();
                $deal_broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('status', 3)->count();

                if($tot_broad == $deal_broad){
                    $update = DB::table('csc_inquiry_br')->where('id', $id)->update([
                        'status' => $stat,
                    ]);
                }

                $broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->first();

                $untuk_nama = "";
                if($inquiry->type == "admin"){
                    $untuk_nama = getAdminName($inquiry->id_pembuat);
                    $to_role = 1;
                    $url_terkait = 'inquiry_admin/view_detail';
                }else if($inquiry->type == "perwakilan"){
                    $untuk_nama = getPerwakilanName($inquiry->id_pembuat);
                    $to_role = 4;
                    $url_terkait = 'inquiry_perwakilan/view_detail';

                    //Notif Admin
                    //Notif sistem
//                    $notif = DB::table('notif')->insert([
//                        'dari_nama' => getCompanyName($id_user),
//                        'dari_id' => $id_user,
//                        'untuk_nama' => "",
//                        'untuk_id' => 0,
//                        'keterangan' => 'Inquiry with subject '.$inquiry->subyek_en.' has been Deal by Exporter '.getCompanyName($id_user),
//                        'url_terkait' => $url_terkait,
//                        'status_baca' => 0,
//                        'waktu' => $datenow,
//                        'to_role' => 1,
//                        'id_terkait' => $broad->id
//                    ]);

//                    $users = DB::table('itdp_admin_users')->where('id', $inquiry->id_pembuat)->first();
//                    $email = $users->email;
//                    $username = $users->name;
//                    //Tinggal Ganti Email1 dengan email kemendag
//                    $data2 = [
//                        'email' => env('MAIL_USERNAME','admin@inaexport.id'),
//                        'username' => $username,
//                        'type' => $inquiry->type,
//                        'penerima' => "Admin",
//                        'company' => getCompanyName($id_user),
//                        'subjek' => $inquiry->subyek_en
//                    ];
//
//                    Mail::send('inquiry.mail.sendDeal', $data2, function ($mail) use ($data2) {
//                        $mail->to($data2['email'], $data2['username']);
//                        $mail->subject('Inquiry Deal Information');
//                    });


                }

                //Notif sistem
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => $untuk_nama,
                    'untuk_id' => $inquiry->id_pembuat,
                    'keterangan' => 'Inquiry with subject '.$inquiry->subyek_en.' has been Deal by Exporter '.getExBadan($id_user).getCompanyName($id_user),
                    'url_terkait' => $url_terkait,
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => $to_role,
                    'id_terkait' => $broad->id
                ]);

                $users = DB::table('itdp_admin_users')->where('id', $inquiry->id_pembuat)->first();
                $email = $users->email;
                $username = $users->name;
                $data2 = [
                    'email' => $email,
                    'username' => $username,
                    'type' => $inquiry->type,
                    'penerima' => $untuk_nama,
                    'company' => getCompanyName($id_user),
                    'subjek' => $inquiry->subyek_en,
                    'bu' => getExBadan($id_user),
                ];

                Mail::send('inquiry.mail.sendDeal', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Inquiry Deal Information');
                }); 
            }else{
                $updatebrm = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->update([
                    'status' => $stat,
                ]);

                $tot_broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->count();
                $cancel_broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('status', 4)->count();

                if($tot_broad == $cancel_broad){
                    $update = DB::table('csc_inquiry_br')->where('id', $id)->update([
                        'status' => $stat,
                    ]);
                }
            }

        }else if($inquiry->type == "importir"){
            $update = DB::table('csc_inquiry_br')->where('id', $id)->update([
                'status' => $stat,
            ]);

            if($stat == 3){
                //Notif sistem
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyNameImportir($inquiry->id_pembuat),
                    'untuk_id' => $inquiry->id_pembuat,
                    'keterangan' => 'Inquiry with subject '.$inquiry->subyek_en.' has been Deal by Exporter '.getExBadan($id_user).getCompanyName($id_user),
                    'url_terkait' => 'front_end/history',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => 3,
                ]);

                $users = DB::table('itdp_company_users')->where('id', $inquiry->id_pembuat)->first();
                $email = $users->email;
                $username = $users->username;
                $data2 = [
                    'email' => $email,
                    'username' => $username,
                    'type' => $inquiry->type,
                    'penerima' => getCompanyNameImportir($inquiry->id_pembuat),
                    'company' => getCompanyName($id_user),
                    'subjek' => $inquiry->subyek_en,
                    'bu' => getExBadanImportir($inquiry->id_pembuat),
                    'bur' => getExBadan($id_user),
                ];

                Mail::send('inquiry.mail.sendDeal2', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Inquiry Deal Information');
                });

//                $data3 = [
//                    'email' => env('MAIL_USERNAME','no-reply@inaexport.id'),
//                    'username' => $username,
//                    'type' => $inquiry->type,
//                    'penerima' => 'Admin',
//                    'company' => getCompanyName($id_user),
//                    'subjek' => $inquiry->subyek_en
//                ];

                //notif untuk admin
//                $notif = DB::table('notif')->insert([
//                    'dari_nama' => getCompanyName($id_user),
//                    'dari_id' => $id_user,
//                    'untuk_nama' => 'Super Admin',
//                    'untuk_id' => 1,
//                    'keterangan' => 'Inquiry with subject '.$inquiry->subyek_en.' has been Deal by Exporter '.getCompanyName($id_user),
//                    'url_terkait' => 'inquiry_admin/view_importir',
//                    'status_baca' => 0,
//                    'waktu' => $datenow,
//                    'to_role' => 1,
//                    'id_terkait' => $id
//                ]);

//                Mail::send('inquiry.mail.sendDeal', $data2, function ($mail) use ($data2) {
//                    $mail->to($data2['email'], $data2['username']);
//                    $mail->subject('Inquiry Deal Information');
//                });


            }
        }

        if($stat == 3){
            if($inquiry->type == "admin"){
                $role = 1;
            }else if($inquiry->type == "perwakilan"){
                $role = 4;
            }else if($inquiry->type == "importir"){
                $role = 3;
            }
            $insert = TransaksiInBR::create([
                "id_pembuat" => $inquiry->id_pembuat,
                "by_role" => $role,
                "id_eksportir" => $id_user,
                "id_terkait" => $id,
                "origin" => 1,
                "created_at" => $datenow,
                "status_transaksi" => 0,
            ]);
            return redirect('/input_transaksi/'.$insert->id_transaksi);
        }else{
            return redirect('/inquiry');
        }
    }

    public function view($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            if($inquiry->type == "importir"){
                $broadcast = NULL;
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }else if($inquiry->type == "perwakilan" || $inquiry->type == "admin"){
                $broadcast = DB::table('csc_inquiry_broadcast')->where('id_itdp_company_users', $id_user)->where('id_inquiry', $id)->first();
                $messages = DB::table('csc_chatting_inquiry')
                    ->where('id_inquiry', $id)
                    ->where('id_broadcast_inquiry', $broadcast->id)
                    ->where('type', $inquiry->type)
                    ->orderBy('created_at', 'asc')
                    ->get();    

                $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNotNull('file')->count();

                //Read Chat
                $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $broadcast->id)->where('type', $inquiry->type)->where('receive', $id_user)->update([
                    'status' => 1,
                ]);
            }
            
            return view('inquiry.eksportir.chatting', compact('pageTitle','inquiry', 'product', 'messages', 'id_user', 'cekfile', 'broadcast'));
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
