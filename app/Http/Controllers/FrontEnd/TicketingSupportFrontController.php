<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;
use Mail;

class TicketingSupportFrontController extends Controller
{

    public function __construct()
    {
//         $this->middleware('auth');
    }

    public function index()
    {

        $pageTitle = 'Ticketing Support';
//        dd(Auth::guard('eksmp')->user());
        $help = Auth::guard('eksmp')->user()->id_helpdesk;

        return view('ticketingsupport.index', compact('pageTitle', 'help'));
    }

    public function create()
    {

//        dd(Auth::guard('eksmp')->user());
        if(Auth::guard('eksmp')->user()) {
            if(Auth::guard('eksmp')->user()->id_role == 3){
//                dd('a');
                $company = db::table('itdp_profil_imp')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
                $name = $company->company;
                $email = $company->email;
            }else if(Auth::guard('eksmp')->user()->id_role == 2){
//                dd('b');
                $company = db::table('itdp_profil_eks')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
                $name = $company->company;
                $email = $company->email;
            }
        }else{
            $name = "";
            $email = "";
        }
        $department = $this->getDep();
        $help = Auth::guard('eksmp')->user()->id_helpdesk;

        $pageTitle = "Ticketing Customer Support";
        $topMenu = "support";
        return view('frontend.ticketing.create', compact('name','email','pageTitle','topMenu','department','help'));
    }

    public function manage($id){

        $pageTitle = "Ticketing Customer Support";
        $topMenu = "support";

        $url = config("constants.HELPDESK_API_URL").'ticketanswer/'.$id;
        $ch = curl_init();
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($hasil != null) {
            $JSONdata = json_decode($hasil, true);
            $ticket = $JSONdata["data"]["ticket"];
            $answer = $JSONdata["data"]["answer"];
        }else{
            $ticket = array();
            $answer = array();
        }

        return view('frontend.ticketing.manage', compact('pageTitle', 'topMenu', 'ticket', 'answer'));
    }

    public function changestatustiket(Request $request){

        $id = $request->id;
        $status = $request->status;

        $url = config("constants.HELPDESK_API_URL").'ticket/update-status/'.$id.'/'.$status;
        $ch = curl_init();
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $JSONData = json_decode($hasil, true);

        return $JSONData;

    }

    public function addticket(Request $request)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $company = db::table('itdp_profil_imp')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
            $name = $company->company;
        }else if(Auth::guard('eksmp')->user()->id_role == 2){
            $company = db::table('itdp_profil_eks')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
            $name = $company->company;
        }

        $data["depid"] = $request->depid;
        $data["operatorid"] = 1;
        $data["clientid"] = Auth::guard('eksmp')->user()->id_helpdesk;
        $data["name"] = $name;
        $data["email"] = Auth::guard('eksmp')->user()->email;
        $data["priorityid"] = $request->priorityid;
        $data["toptionid"] = $request->toptionid;
        $data["subject"] = $request->subject;
        $data["content"] = $request->contents;
        $data["ip"] = "";
        $data["referrer"] = "";
        $data["notes"] = "";
        $data["private"] = $request->private;
        $data["status"] = 1;
        $data["attachments"] = !empty($_FILES['file']['name']) ? 1 : 0;
        $data["mergeid"] = 0;
        $data["mergeopid"] = 0;
        $data["mergetime"] = 0;
        $data["initiated"] = time();
        $data["ended"] = 0;
        $data["updated"] = time();
        $data["duedate"] = date('Y-m-d');
        $data["reminder"] = 0;
        if(!empty($_FILES['file']['name']))
            $data["file"] = !empty($_FILES['file']['name']) ? curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']) : null;

        $url = config("constants.HELPDESK_API_URL")."ticket";
        $ch = curl_init($url);
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        // curl connection
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

        $hasil = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($hasil != null) {
            $JSONdata = json_decode($hasil, true);
            $message["meta"] = $JSONdata['meta'];
            return redirect()->route('front.ticket.index');
        } else {
            $JSONdata = json_decode($hasil, true);
            $message["meta"] = $JSONdata['meta'];
            return redirect()->route('front.ticket.index');
        }
    }

    public function addanswer(Request $request){

        $clientid = Auth::guard('eksmp')->user()->id_helpdesk;
        $data1["contents"] = $request->contents;
        $data1["clientid"] = $clientid;
        $data1["ticketid"] = $request->ticketid;
        $data1["private"]  = 0;

        $data2["content"]  = !empty($_FILES['file']['name']) ? curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']) : null;
        $data2["clientid"] = $clientid;
        $data2["ticketid"] = $request->ticketid;
        $data2["private"]  = 0;

        if(!empty($request->contents) && !empty($_FILES['file']['name'])){

            $create1 = $this->createanswer($data1);
            $create2 = $this->createanswer($data2);
        }

        if(!empty($request->contents) && empty($_FILES['file']['name'])){
            $create1 = $this->createanswer($data1);
        }

        if(empty($request->contents) && !empty($_FILES['file']['name'])){
            $create2 = $this->createanswer($data2);
        }

        return redirect()->back();
    }

    public function createanswer($data){

        $url = config("constants.HELPDESK_API_URL")."ticketanswer";
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $JSONdata = json_decode($hasil, true);
        return $JSONdata;

    }

    public function getTicket(Request $request){

        $page = $request->page;
        $search = $request->search;
        $orderby = $request->orderby;
        $sort = $request->sort;
        $clientid = Auth::guard('eksmp')->user()->id_helpdesk;

        $url = config("constants.HELPDESK_API_URL").'ticket?page='.$page.'&clientid='.$clientid.'&search='.$search.'&order='.$orderby.'&sort='.$sort;
        $ch = curl_init();
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($hasil != null) {
            $JSONdata = json_decode($hasil, true);
            $message["data"] = $JSONdata['data'];
            $message["meta"] = $JSONdata['meta'];
            return $message;
        }else
            return json_decode($hasil, true);
    }

    public function getDep(){

        $url = config("constants.HELPDESK_API_URL").'department';
        $ch = curl_init();
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($hasil != null) {
            $JSONdata = json_decode($hasil, true);
            $message = $JSONdata['data'];
            return $message ? $message : [];
        }else
            return json_decode($hasil, true);
    }


    public function convertData($body_content) {
        $body_content = trim($body_content);
        $body_content = stripslashes($body_content);
        $body_content = htmlspecialchars($body_content);
        return $body_content;
    }



    public function store(Request $req)
    {
        if(Auth::guard('eksmp')->user()){
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');
            $id_user = Auth::guard('eksmp')->user()->id;
            $type = Auth::guard('eksmp')->user()->type;

            $store = TicketingSupportModel::create([
                'id_pembuat' => $id_user,
                'name' => $req->name,
                'type' => $type,
                'email' => $req->email,
                'subyek' => $req->subject,
                'main_messages' => $req->messages,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $id_ticketing = $store->id;
            //        dd($id_ticketing);
            //Tinggal Ganti Email1 dengan email kemendag
            //kementerianperdagangan.max@gmail.com
            //        dd(Auth::guard('eksmp')->user()->id_role = 3);

            if(Auth::guard('eksmp')->user()->id_role == 2){
                $data = [
                    'email' => $req->email,
                    'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                    'username' => $req->name,
                    'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                    'ticketing' => $id_ticketing,
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                ];

                $data2 = [
                    'email' => $req->email,
                    'email1' => Auth::guard('eksmp')->user()->email,
                    'username' => $req->name,
                    'ticketing' => $id_ticketing,
                    'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                ];



                $ket = "Ticketing was created by ".getExBadan(auth::guard('eksmp')->user()->id).getCompanyName(auth::guard('eksmp')->user()->id);
                //		$ket2 = "You was create ticketing";
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                ('1','".getcompanyname(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$id_ticketing."','".$date."','0')
                ");

                //		$insert4 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                //			('".Auth::guard('eksmp')->user()->id_role."','Super Admin','1','".Auth::guard('eksmp')->user()->username."','".Auth::guard('eksmp')->user()->id."','".$ket2."','front_end/ticketing_support/view','".$id_ticketing."','".Date('Y-m-d H:m:s')."','0')
                //		");


                //notif email for env email
                // Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                //     $mail->to($data['email1'], $data['username']);
                //     $mail->subject('Requesting Ticketing Support');
                // });

                //notif email for user
                // Mail::send('UM.user.sendticket2', $data2, function ($mail) use ($data2) {
                //     $mail->to($data2['email1'], $data2['username']);
                //     $mail->subject('You Requesting Ticketing Support');
                // });

                //notif email for all admin
                // $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
                // foreach($admin_all as $aa){
                //     $data = [
                //         'email' => $aa->email,
                //         'email1' => $aa->email,
                //         'username' => $aa->name,
                //         'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                //         'ticketing' => $id_ticketing,
                //         'main_messages' => $req->messages,
                //         'id' => $id_ticketing,
                //         'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                //     ];
                //     Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                //         $mail->to($data['email1'], $data['username']);
                //         $mail->subject('Requesting Ticketing Support');
                //     });
                // }
            }
            else if(Auth::guard('eksmp')->user()->id_role == 3){
                $data = [
                    'email' => $req->email,
                    'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                    'username' => $req->name,
                    'company' =>getCompanyNameImportir(Auth::guard('eksmp')->user()->id),
                    'ticketing' => $id_ticketing,
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                ];

                $data2 = [
                    'email' => $req->email,
                    'email1' => Auth::guard('eksmp')->user()->email,
                    'username' => $req->name,
                    'ticketing' => $id_ticketing,
                    'company' =>getCompanyNameImportir(Auth::guard('eksmp')->user()->id),
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                ];

                $ket = "Ticketing was created by ".getExBadanImportir(Auth::guard('eksmp')->user()->id)." ".getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
                //		$ket2 = "You was create ticketing";
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                ('1','".getCompanyNameImportir(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$id_ticketing."','".$date."','0')
                ");

                //		$insert4 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                //			('".Auth::guard('eksmp')->user()->id_role."','Super Admin','1','".Auth::guard('eksmp')->user()->username."','".Auth::guard('eksmp')->user()->id."','".$ket2."','front_end/ticketing_support/view','".$id_ticketing."','".Date('Y-m-d H:m:s')."','0')
                //		");


                //notif email for admin
                // Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                //     $mail->to($data['email1'], $data['username']);
                //     $mail->subject('Requesting Ticketing Support');
                // });

                //notif email for user
                // Mail::send('UM.user.sendticket2', $data2, function ($mail) use ($data2) {
                //     $mail->to($data2['email1'], $data2['username']);
                //     $mail->subject('You Requesting Ticketing Support');
                // });

                // $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
                // foreach($admin_all as $aa){
                //     $data = [
                //         'email' => $aa->email,
                //         'email1' => $aa->email,
                //         'username' => $aa->name,
                //         'company' =>getCompanyNameImportir(auth::guard('eksmp')->user()->id),
                //         'ticketing' => $id_ticketing,
                //         'main_messages' => $req->messages,
                //         'id' => $id_ticketing,
                //         'bu' => getExBadanImportir(auth::guard('eksmp')->user()->id),
                //     ];
                //     Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                //         $mail->to($data['email1'], $data['username']);
                //         $mail->subject('Requesting Ticketing Support');
                //     });
                // }

            }


            //dd();
            //        return redirect('/front_end/history');
            //log
            $insert = DB::select("
                insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
                ('".Auth::guard('eksmp')->user()->email."','".date('H:i:s')."','".date('Y-m-d')."','','".Auth::guard('eksmp')->user()->id_role."'
                ,'".Auth::guard('eksmp')->user()->id."','8','create ticketing')");

            //end log
            return redirect()->route('front.ticket.index');
        } else {
            return redirect('login');
        }
    }

    public function getData()
    {

        /*$tick = TicketingSupportModel::from('ticketing_support as ts')->orderby('ts.created_at', 'DESC')
                  ->get(); */
        $id = Auth::guard('eksmp')->user()->id;
        $tick = DB::select("select ROW_NUMBER() OVER (ORDER BY created_at DESC) AS Row, * from ticketing_support as ts WHERE ts.id_pembuat = '".$id."' order by created_at desc ");


        return \Yajra\DataTables\DataTables::of($tick)
            ->addColumn('name', function ($data) {
                return '<div align="left">' . $data->name . '</div>';

            })
            ->addColumn('subyek', function ($data) {
                return '<div align="left">' . $data->subyek . '</div>';

            })
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
                if ($data->status == 1 || $data->status == 2) {
//                    return '
//              <center>
//              <div class="btn-group">
//                <a href="' . route('front.ticket.vchat', $data->id) . '" class="btn btn-sm btn-warning">&nbsp;<i class="fa fa-envelope text-white"></i>&nbsp;Chat&nbsp;</a>&nbsp;&nbsp;
//								<a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-primary">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//                <!-- <a href="' . route('master.city.edit', $data->id) . '" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
//              </div>
//              </center>
//              ';
                    if(checkticketingcreator($data->id)){
                        return '
                            <center>
                            <div class="btn-group">
                                <!-- <a href="' . route('front.ticket.vchat', $data->id) . '" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Chat">&nbsp;<i class="fa fa-comment text-white"></i></a>&nbsp;&nbsp; -->
                                                <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                                <!-- <a href="' . route('master.city.edit', $data->id) . '" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; -->
                            </div>
                            </center>
                            ';
                    }else{
                        return '
                        <center>
                        <div class="btn-group">
                            <a href="' . route('front.ticket.vchat', $data->id) . '" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Chat">&nbsp;<i class="fa fa-comment text-white"></i></a>&nbsp;&nbsp;
                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                            <a onclick="return confirm(\'Are You Sure ?\')" href="'.route("ticket_support.delete.admin", $data->id).'" id="button" class="btn btn-sm btn-danger" title="Delete">&nbsp<i class="fa fa-trash text-white"></i></a>
                            <!-- <a href="' . route('master.city.edit', $data->id) . '" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
                        </div>
                        </center>
                        ';
                    }

                } else if ($data->status == 3) {
//                    return '
//              <center>
//              <div class="btn-group">
//								<a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
//								<a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Chat Ini ?\')" href="' . route('ticket_support.delete.admin', $data->id) . '" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
//								<!-- <a href="" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
//              </div>
//              </center>
//              ';
                    if(checkticketingcreator($data->id)){
                        return '
                        <center>
                        <div class="btn-group">
                                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white" data-toggle="tooltip" ></i></a>&nbsp;&nbsp;
                                            <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('ticket_support.delete.admin', $data->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
                                            <!-- <a href="" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
                        </div>
                        </center>
                        ';
                    }else{
                        return '
                        <center>
                        <div class="btn-group">
                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white" data-toggle="tooltip" ></i></a>&nbsp;&nbsp;
                            <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('ticket_support.delete.admin', $data->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
                            <a onclick="return confirm(\'Are You Sure ?\')" href="'.route("ticket_support.delete.admin", $data->id).'" id="button" class="btn btn-sm btn-danger" title="Delete">&nbsp<i class="fa fa-trash text-white"></i></a>
                            <!-- <a href="" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
                        </div>
                        </center>
                        ';
                    }

                }
            })
            ->rawColumns(['action', 'name', 'subyek'])
            ->make(true);
    }

    public function vchat($id)
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
            $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
                ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
                ->where('ts.id', $id)
                ->orderby('cts.messages_send', 'asc')
                ->get();

            $ticket = TicketingSupportModel::where('id', $id)->first();

            $pageTitle = 'Ticketing Support';
            $topMenu = "support";

            return view('frontend.ticketing.chatting', compact('ticket', 'messages', 'id_user', 'pageTitle', 'topMenu'));
        }else{
            return redirect('login');
        }

    }

    public function vchat_v2($id, $id_respondent)
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
            $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
                ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
                ->where('ts.id', $id)
                ->where('cts.sender_admin', $id_respondent)
                ->orWhere('cts.receiver_admin', $id_respondent)
                ->orderby('cts.messages_send', 'asc')
                ->get();

            $ticket = TicketingSupportModel::where('id', $id)->first();

            $respondent = User::select('id', 'name', 'email')->where('id', $id_respondent)->first();

            $pageTitle = 'Ticketing Support';
            $topMenu = "support";
            // dd($respondent);
            return view('frontend.ticketing.chatting_v2', compact('ticket', 'messages', 'id_user', 'pageTitle', 'topMenu', 'respondent'));
        }else{
            return redirect('login');
        }

    }

    public function sendchat(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
        foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
        $cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
        foreach($cari2 as $v2){
            $data1 = $v2->username;
            $data2 = $v2->email;
            $data3 = $v2->id_role;
            $data4 = $v2->id;
        }
        /* $data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
            ];
        */
        $data2 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id,
            'user' => 'Admin',
        ];
        /*
        Mail::send('UM.user.sendticketchat2', $data, function ($mail) use ($data) {

       $mail->to($data['email1'], $data['username']);
       $mail->subject('You Reply Chat on Ticketing Support');
       });

       */
        //Notif Untuk Admin
        Mail::send('UM.user.sendticketchat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('User Reply Your Chat On Ticketing Support');
        });
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $ket = getExBadanImportir($data4).getCompanyNameImportir($data4)." Reply Chat on Ticketing Request";
        }
        elseif (Auth::guard('eksmp')->user()->id_role == 2){
            $ket = getExBadan($data4).getCompanyName($data4)." Reply Chat on Ticketing Request";
        }

        $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('1','".$data1."','".$data4."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$req->id."','".$date."','0')
				");

        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('/front_end/ticketing_support/chatview/' . $req->id);
    }

    public function sendchat_v2(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'messages' => $req->messages,
            'messages_send' => $date,
            'receiver_admin' => $req->recipient
        ]);

        return redirect('/front_end/ticketing_support/response/'.$req->id.'/'.$req->recipient.'');
    }

    public function sendFilechat(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');

        $nama_file1 = NULL;
        $destination= 'uploads\ticketing\\';
        if($req->hasFile('upload_file2')){
            $file1 = $req->file('upload_file2');
            $nama_file1 = time().'_'.$req->file('upload_file2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
        foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
        $cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
        foreach($cari2 as $v2){
            $data1 = $v2->username;
            $data2 = $v2->email;
            $data3 = $v2->id_role;
            $data4 = $v2->id;
        }


        /* $data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
            ];
        */
        $data2 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id,
            'user' => 'User',
        ];
        /*
        Mail::send('UM.user.sendticketchat2', $data, function ($mail) use ($data) {

       $mail->to($data['email1'], $data['username']);
       $mail->subject('You Reply Chat on Ticketing Support');
       });
       */
        //Notif untuk admin
        Mail::send('UM.user.sendticketchat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('User Reply Your Chat On Ticketing Support');
        });
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $ket = getExBadanImportir($data4).getCompanyNameImportir($data4)." Reply Chat on Ticketing Request";
        }
        elseif (Auth::guard('eksmp')->user()->id_role == 2){
            $ket = getExBadan($data4).getCompanyName($data4)." Reply Chat on Ticketing Request";
        }
        $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                ('1','".$data1."','".$data4."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$req->id."','".Date('Y-m-d H:m:s')."','0')
                ");

        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'file' => $nama_file1,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('/front_end/ticketing_support/chatview/' . $req->id);
    }

    public function view($id)
    {
        $pageTitle = 'Ticketing Support';
        $topMenu = "support";

        $ticket = TicketingSupportModel::where('id', $id)->first();

        $respondents = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->select('admin.name', 'admin.email', 'sender_admin', 'id_ticketing_support')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->leftJoin('itdp_admin_users as admin', 'cts.sender_admin', '=', 'admin.id')
            ->where('ts.id', $id)
            ->whereNotNull('cts.sender_admin')
            // ->orderby('cts.messages_send', 'asc')
            ->groupBy('admin.name', 'admin.email', 'sender_admin', 'id_ticketing_support')
            ->get();

        // dd($respondents);

        return view('frontend.ticketing.view', compact('ticket', 'pageTitle', 'topMenu', 'respondents'));
    }

    public function destroy($id)
    {
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            Session::flash('error', 'Success Delete Data');
            return redirect('/front_end/history');
        } else {
            Session::flash('error', 'Failed Delete Data');
            return redirect('/front_end/history');
        }
    }

    public function convertmili($timestamp){

        date_default_timezone_set('Asia/Bangkok');
        if (is_numeric($timestamp)) {
            $unixtime = $timestamp;
        } else {
            $unixtime = strtotime($timestamp);
        }

        $date = 'd/m/Y';
        $time = 'H:i';
        $ret = !empty($timestamp) ? date(($date && $time ? $date.' ' : $date).$time, $unixtime) : "";

        echo $ret;
    }

}
