<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Lang;
use Mail;

class InquiryFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
        changeStatusInquiry();
    }

    public function index()
    {
        //
    }

    function getCountChat($id, $receiver)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function create($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $url = "/front_end/inquiry_act/".$id;
            $data = DB::table('csc_product_single')->where('id', $id)->first();
            $coinquiry = DB::table('csc_inquiry_br')
                ->where('type', 'importir')
                ->where('to', $id)
                ->where('status', 3)
                ->count();
            return view('frontend.inquiry.create_new', compact('data', 'url', 'id_user', 'coinquiry'));
        }else{
            return redirect('/');
        }
    }

    public function store($id, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $id_product = $request->id_product;
            $type = $request->type;

            $dtproduct = DB::table('csc_product_single')->where('id', $id_product)->first();

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
                'id_csc_prod_cat' => $dtproduct->id_csc_product,
                'id_csc_prod_cat_level1' => $dtproduct->id_csc_product_level1,
                'id_csc_prod_cat_level2' => $dtproduct->id_csc_product_level2,
                'jenis_perihal_en' => $jpen,
                'jenis_perihal_in' => $jpin,
                'jenis_perihal_chn' => $jpchn,
                'messages_en' => $request->messages,
                'messages_in' => $request->messages,
                'messages_chn' => $request->messages,
                'subyek_en' => $request->subject,
                'subyek_in' => $request->subject,
                'subyek_chn' => $request->subject,
                'to' => $id_product,
                'status' => 1,
                'date' => $datenow,
                'duration' => $duration,
                'created_at' => $datenow,
            ]);

            $nama_file1 = NULL;
            $destination= 'uploads\Inquiry\\'.$save;
            if($request->hasFile('filedo')){ 
                $file1 = $request->file('filedo');
                $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            }

            $savefile = DB::table('csc_inquiry_br')->where('id', $save)->update([
                'file' => $nama_file1,
            ]);

            if($save){
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyNameImportir($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($dtproduct->id_itdp_company_user),
                    'untuk_id' => $dtproduct->id_itdp_company_user,
                    'keterangan' => 'New Inquiry By '.getExBadanImportir($id_user).getCompanyNameImportir($id_user).' with Subject  "'.$request->subject.'"',
                    'url_terkait' => 'inquiry',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => 2,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
                $untuk = DB::table('itdp_company_users')->where('id', $dtproduct->id_itdp_company_user)->first();
//                dd($untuk->id_profil);
                if($untuk){
                    $company = DB::table('itdp_profil_eks')->where('id', $untuk->id_profil)->first();
                }
//                dd (getExBadanImportir($id_user));
                $data = [
                    'email' => $untuk->email,
                    'username' => $untuk->username,
                    'type' => "eksportir",
                    'company' => getCompanyName($dtproduct->id_itdp_company_user),
                    'dari' => getCompanyNameImportir($id_user),
                    'bu' => getExBadan($dtproduct->id_itdp_company_user),
                    'bur' => getExBadanImportir($id_user),
                ];

                Mail::send('inquiry.mail.sendToEksportir2', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Inquiry Information');
                });

//                $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
//                $users_admin = [];
//                array_push($users_admin, env('MAIL_USERNAME','no-reply@inaexport.id'));
//                foreach ($admin as $adm) {
//                    array_push($users_admin, $adm->email);
//                }
//
//                //Notif email ke admin
//                $dataadmin = [
//                    'pembuat' => getCompanyNameImportir($id_user),
//                    'dari' => "Importir"
//                ];
//
//                Mail::send('inquiry.mail.SendToAdmin', $dataadmin, function ($mail) use ($dataadmin, $users_admin) {
//                    $mail->subject('Inquiry Information');
//                    $mail->to($users_admin);
//                });
            }

            return redirect('/front_end/history');
        }else{
            return redirect('/');
        }

    }

    public function verifikasi_inquiry($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $datenow = date('Y-m-d H:i:s');
            $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

            if($data){
                    if($data->duration != "None"){
                        $durasi = 0;
                        $jn = explode(' ', $data->duration);
                        if($jn[1] == "week" || $jn[1] == "weeks"){
                            $durasi = (int)$jn[0] * 7;
                        }else if($jn[1] == "month" || $jn[1] == "months"){
                            $durasi = (int)$jn[0] * 30;
                        }

                        $date = strtotime("+".$durasi." days", strtotime($datenow));
                        $duedate = date('Y-m-d H:i:s', $date);

                        $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                            'status' => 2,
                            'due_date' => $duedate,
                        ]);
                    }else{
                        $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                            'status' => 2,
                        ]);
                    }
                }

            return redirect('/front_end/history');
        }else{
            return redirect('/');
        }
    }

    public function chatting($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'importir')
                ->orderBy('created_at', 'asc')
                ->get();
            
            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $id_user)->update([
                'status' => 1,
            ]);
            
            return view('frontend.inquiry.chatting', compact('inquiry', 'data', 'messages', 'id_user'));
            // return view('frontend.inquiry.chatting');
        }else{
            return redirect('/');
        }
    }

    public function sendChat(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id_inquiry' => $id,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if($save){
            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyNameImportir($sender),
                'dari_id' => $sender,
                'untuk_nama' => getCompanyName($receiver),
                'untuk_id' => $receiver,
                'keterangan' => 'New Message from '.getExBadanImportir($sender).getCompanyNameImportir($sender).' about Inquiry '.$data->subyek_en,
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
                'type' => 'importir',
                'sender' => getCompanyNameImportir($sender),
                'receiver' => getCompanyName($receiver),
                'subjek' => $data->subyek_en,
                'id' =>$id,
                'bu' => getExBadanImportir($sender),
                'bur' => getExBadan($receiver)
            ];

            Mail::send('inquiry.mail.sendChat3imp', $data2, function ($mail) use ($data2) {
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
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->id_inquiry2;
        $sender = $request->sender2;
        $receiver = $request->receiver2;
        $msg = $request->msgfile2;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();


        $save = DB::table('csc_chatting_inquiry')->insertGetId([
            'id_inquiry' => $id,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        //Upload File
        $nama_file1 = NULL;
        $destination= 'uploads\ChatFileInquiry\\'.$save;
        if($request->hasFile('upload_file2')){ 
            $file1 = $request->file('upload_file2');
            $nama_file1 = time().'_'.$request->file('upload_file2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $savefile = DB::table('csc_chatting_inquiry')->where('id', $save)->update([
            'file' => $nama_file1,
        ]);

        //Notif sistem
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyNameImportir($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyName($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Payment Information from '.getExBadanImportir($sender).getCompanyNameImportir($sender).' about Inquiry '.$data->subyek_en,
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
            'type' => 'importir',
            'sender' => getCompanyNameImportir($sender),
            'receiver' => getCompanyName($receiver),
            'subjek' => $data->subyek_en,
            'id' => $id,
            'bu' => getExBadanImportir($sender),
            'bur' => getExBadan($receiver)
        ];

        Mail::send('inquiry.mail.sendChat3imp', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Inquiry Payment Information');
        });

        return redirect('/front_end/chat_inquiry/'.$id); 
        
    }

    public function view($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();

            return view('frontend.inquiry.view', compact('inquiry', 'data', 'id_user'));
        }else{
            return redirect('/');
        }
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
