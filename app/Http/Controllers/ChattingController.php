<?php

namespace App\Http\Controllers;

use App\Group;
use App\Models\CscChattingCompanyAdmin;
use App\Models\ItdpAdminUser;
use App\Models\ItdpCompanyUser;
use App\Models\Notif;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Pusher\Pusher;
use DB;

class ChattingController extends Controller
{
    public function chat(Request $request, $id_admin, $id_eks_imp)
    {
        $id_admin = decrypt($id_admin);
        $id_eks_imp = decrypt($id_eks_imp);

        if (env('PUSHER_APP_KEY') == null) {
            throw new \Exception("Can't read environment configuration", 1);
        }
        if (Auth::user() != '') {
            // only admin and perwadag
            if (Auth::user()->id_group == 1 || Auth::user()->id_group == 4) {
            } else {
                return redirect('/login');
            }
        } else if (Auth::guard('eksmp')->user() != '') {
            // only supplier and buyer
            if (Auth::guard('eksmp')->user()->id_role == 2 || Auth::guard('eksmp')->user()->id_role == 3) {
            } else {
                return redirect('/login');
            }
        } else {
            return redirect('/login');
        }
        if (isset($_GET['id_notif'])) {
            $id_notif = decrypt($_GET['id_notif']);
            $status_notif = DB::table('notif')->where('id_notif', $id_notif)->update(['status_baca' => 1]);
        }
        $admin_user = ItdpAdminUser::with('group', 'profile_perwadag_ln', 'profile_perwadag_ln.country_name')->whereId($id_admin)->first();
        $company_user = ItdpCompanyUser::with('profile_buyer', 'profile', 'profile.contact_person')->whereId($id_eks_imp)->first();
        $company_group_name = ($company_user->id_role == 2) ? "Supplier" : "Buyer";
        $admin_group = ($company_user->id_role == 2) ? $company_user->id_role : $admin_user->id_group;


        $data['data'] = CscChattingCompanyAdmin::with('admin_user', 'company_user.profile', 'company_user.profile_buyer')->where('id_admin', $id_admin)->where('id_eks_imp', $id_eks_imp)->orderBy('id', 'asc')->get();
        $data['pageTitle'] = "Chat " . $admin_user->group->group_name . " and " . $company_group_name;
        $data['company_group_name'] = $company_group_name;
        $data['admin_group_name'] = $admin_user->group->group_name;
        $data['company_user'] = $company_user;
        $data['admin_user'] = $admin_user;
        $data['id_admin'] = $id_admin;
        $data['id_eks_imp'] = $id_eks_imp;
        $data['admin_group'] = $admin_group;
        return view('chatting.index', $data);
    }

    public function notification($id_admin, $id_eks_imp)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'New message';
        $channel = 'notify-channel-' . $id_admin . '-' . $id_eks_imp;
        $pusher->trigger($channel, 'App\\Events\\Notify', $data);
    }

    public function refreshchat($id_admin, $id_eks_imp)
    {
        $admin_user = ItdpAdminUser::with('group')->whereId($id_admin)->first();
        $company_user = ItdpCompanyUser::with('profile_buyer', 'profile')->whereId($id_eks_imp)->first();
        $company_group_name = ($company_user->id_role == 2) ? "Supplier" : "Buyer";

        $data['data'] = CscChattingCompanyAdmin::where('id_admin', $id_admin)->where('id_eks_imp', $id_eks_imp)->orderBy('id', 'asc')->get();
        $data['pageTitle'] = "Chat " . $admin_user->group->group_name . " and " . $company_group_name;
        $data['company_group_name'] = $company_group_name;
        $data['company_user'] = $company_user;
        $data['id_admin'] = $id_admin;
        $data['id_eks_imp'] = $id_eks_imp;

        return view('chatting.refresh', $data);
    }


    public function send_chat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        CscChattingCompanyAdmin::insert([
            'id_admin' => $request->id_admin,
            'id_eks_imp' => $request->id_eks_imp,
            'id_pengirim' => $request->id_pengirim,
            'pesan' => $request->message,
            'email_pengirim' => $request->email_pengirim,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $admin_user = ItdpAdminUser::whereId($request->id_admin)->first();
        $admin_id = $admin_user->id;
        $admin_email = $admin_user->email;
        $admin_name = $admin_user->name;
        $admin_id_group = $admin_user->id_group;

        $company_user = ItdpCompanyUser::with('profile', 'profile_buyer')->whereId($request->id_eks_imp)->first();
        $company_id = $company_user->id;
        $company_email = $company_user->email;
        $company_name = ($company_user->profile != null) ? $company_user->profile->company :  $company_user->profile_buyer->company;
        $company_id_role = $company_user->id_role;

        if (empty(Auth::user()->name)) {
            //Send from Company to Admin
            if (Auth::guard('eksmp')->user()->id_role == 2) {
                // Send from exportir to admin
                $keterangan = "Supplier " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '1',
                    'dari_nama' => getCompanyName(Auth::guard('eksmp')->user()->id),
                    'dari_id' => Auth::guard('eksmp')->user()->id,
                    'untuk_nama' => getAdminName($admin_id),
                    'untuk_id' => $admin_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getAdminMail($admin_id),
                    'username' => $company_name,
                    'receiver' => $admin_name,
                    'main_messages' => "",
                    'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                    'id' => $admin_id,
                    'company_id' => $company_id,
                ];
                Mail::send('UM.user.sendchateks', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Supplier Respond Chat');
                });
            } else if (Auth::guard('eksmp')->user()->id_role == 3) {
                //Send from Buyer
                $keterangan = "Buyer " . getExBadanImportir(Auth::guard('eksmp')->user()->id) . getCompanyNameImportir(Auth::guard('eksmp')->user()->id)  . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => getCompanyName(Auth::guard('eksmp')->user()->id),
                    'dari_id' => Auth::guard('eksmp')->user()->id,
                    'untuk_nama' => getAdminName($admin_id),
                    'untuk_id' => $admin_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getAdminMail($admin_id),
                    'username' => $company_name,
                    'receiver' => $admin_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                    'bur' => getExBadan($company_id),
                ];
                Mail::send('UM.user.sendchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Buyer Respond Chat');
                });
            }
        } else {
            // Send from Admin to Company
            if (Auth::user()->id_group == 1) {
                //dari Admin to Company
                $keterangan = "Admin " . Auth::user()->name . " Respond Chat";
                $ket = Auth::user()->name . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => auth::user()->name,
                    'dari_id' => auth::user()->id,
                    'untuk_nama' => $company_name,
                    'untuk_id' => $company_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getUserMail($company_id),
                    'username' => $admin_name,
                    'receiver' => $company_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => "-",
                    'bur' => getExBadan($company_id),
                ];

                Mail::send('UM.user.sendchateks', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Admin Respond Chat');
                });
            } elseif (Auth::user()->id_group == 4) {
                $keterangan = "Representative " . Auth::user()->name . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => auth::user()->name,
                    'dari_id' => auth::user()->id,
                    'untuk_nama' => getNameCompany($company_id),
                    'untuk_id' => $company_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getUserMail($company_id),
                    'username' => $admin_name,
                    'receiver' => $company_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => "-",
                    'bur' => getExBadan($company_id),
                ];

                Mail::send('UM.user.sendchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Representative Respond Chat');
                });
            }
        }
    }

    public function uploadFile(Request $request, $id_admin, $id_eks_imp)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $file = $request->file('file_chat')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/ChatAdminCompanyFiles";
        $request->file('file_chat')->move($destinationPath, $file);

        CscChattingCompanyAdmin::insert([
            'id_admin' => $request->id_admin,
            'id_eks_imp' => $request->id_eks_imp,
            'id_pengirim' => $request->id_pengirim,
            'pesan' => $request->catatan,
            'email_pengirim' => $request->email_pengirim,
            'file' => $file,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $admin_user = ItdpAdminUser::whereId($request->id_admin)->first();
        $admin_id = $admin_user->id;
        $admin_email = $admin_user->email;
        $admin_name = $admin_user->name;
        $admin_id_group = $admin_user->id_group;

        $company_user = ItdpCompanyUser::with('profile', 'profile_buyer')->whereId($request->id_eks_imp)->first();
        $company_id = $company_user->id;
        $company_email = $company_user->email;
        $company_name = ($company_user->profile != null) ? $company_user->profile->company :  $company_user->profile_buyer->company;
        $company_id_role = $company_user->id_role;

        if (empty(Auth::user()->name)) {
            //Send from Company to Admin
            if (Auth::guard('eksmp')->user()->id_role == 2) {
                // Send from exportir to admin
                $keterangan = "Supplier " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '1',
                    'dari_nama' => getCompanyName(Auth::guard('eksmp')->user()->id),
                    'dari_id' => Auth::guard('eksmp')->user()->id,
                    'untuk_nama' => getAdminName($admin_id),
                    'untuk_id' => $admin_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getAdminMail($admin_id),
                    'username' => $company_name,
                    'receiver' => $admin_name,
                    'main_messages' => "",
                    'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                    'id' => $admin_id,
                    'company_id' => $company_id,
                ];
                Mail::send('UM.user.sendchateks', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Supplier Respond Chat');
                });
            } else if (Auth::guard('eksmp')->user()->id_role == 3) {
                //Send from Buyer
                $keterangan = "Buyer " . getExBadanImportir(Auth::guard('eksmp')->user()->id) . getCompanyNameImportir(Auth::guard('eksmp')->user()->id)  . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => getCompanyName(Auth::guard('eksmp')->user()->id),
                    'dari_id' => Auth::guard('eksmp')->user()->id,
                    'untuk_nama' => getAdminName($admin_id),
                    'untuk_id' => $admin_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getAdminMail($admin_id),
                    'username' => $company_name,
                    'receiver' => $admin_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                    'bur' => getExBadan($company_id),
                ];
                Mail::send('UM.user.sendchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Buyer Respond Chat');
                });
            }
        } else {
            // Send from Admin to Company
            if (Auth::user()->id_group == 1) {
                //dari Admin to Company
                $keterangan = "Admin " . Auth::user()->name . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => auth::user()->name,
                    'dari_id' => auth::user()->id,
                    'untuk_nama' => $company_name,
                    'untuk_id' => $company_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getUserMail($company_id),
                    'username' => $admin_name,
                    'receiver' => $company_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => "-",
                    'bur' => getExBadan($company_id),
                ];

                Mail::send('UM.user.sendchateks', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Admin Respond Chat');
                });
            } elseif (Auth::user()->id_group == 4) {
                $keterangan = "Representative " . Auth::user()->name . " Respond Chat";
                // insert notif 
                Notif::insert([
                    'to_role' => '2', // supplier
                    'dari_nama' => auth::user()->name,
                    'dari_id' => auth::user()->id,
                    'untuk_nama' => getNameCompany($company_id),
                    'untuk_id' => $company_id,
                    'keterangan' => $keterangan,
                    'url_terkait' => 'chat_admin_eks_imp',
                    'id_terkait' => $admin_id . '/' . $company_id,
                    'waktu' => $date,
                    'status_baca' => '0'
                ]);

                $data = [
                    'email' => "",
                    'email1' => getUserMail($company_id),
                    'username' => $admin_name,
                    'receiver' => $company_name,
                    'main_messages' => "",
                    'id' => $admin_id,
                    'company_id' => $company_id,
                    'bu' => "-",
                    'bur' => getExBadan($company_id),
                ];

                Mail::send('UM.user.sendchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['receiver']);
                    $mail->subject('Representative Respond Chat');
                });
            }
        }

        return redirect('chat_admin_eks_imp/' . encrypt($id_admin) . '/' . encrypt($id_eks_imp));
    }
}
