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

class ChattingAdminController extends Controller
{
    public function chat(Request $request, $id_admin, $id_other_admin)
    {
        $id_admin = decrypt($id_admin);
        $id_other_admin = decrypt($id_other_admin);

        if (env('PUSHER_APP_KEY') == null) {
            throw new \Exception("Can't read environment configuration", 1);
        }
        if (Auth::user() != '') {
            // only admin, perwadag and dinas
            if (Auth::user()->id_group == 1 || Auth::user()->id_group == 4) {
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
        $other_admin_user = ItdpAdminUser::with('group', 'profile_perwadag_ln', 'profile_perwadag_ln.country_name')->whereId($id_other_admin)->first();
        $other_admin_group_name = ($other_admin_user->id_group == 4) ? "Perwadag" : "Dinas";
        $admin_group = $admin_user->id_group;


        $data['data'] = CscChattingCompanyAdmin::with('admin_user', 'company_user.profile', 'company_user.profile_buyer')->where('id_admin', $id_admin)->where('id_eother_admin', $id_other_admin)->orderBy('id', 'asc')->get();
        $data['pageTitle'] = "Chat " . $admin_user->group->group_name . " and " . $other_admin_group_name;
        $data['other_admin_group_name'] = $other_admin_group_name;
        $data['admin_group_name'] = $admin_user->group->group_name;
        $data['other_admin_user'] = $other_admin_user;
        $data['admin_user'] = $admin_user;
        $data['id_admin'] = $id_admin;
        $data['admin_group'] = $admin_group;
        return view('chatting.admin', $data);
    }

    public function notification($id_admin, $id_other_admin)
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
        $channel = 'notify-channel-' . $id_admin . '-' . $id_other_admin;
        $pusher->trigger($channel, 'App\\Events\\Notify', $data);
    }

    public function refreshchat($id_admin, $id_other_admin)
    {
        $admin_user = ItdpAdminUser::with('group')->whereId($id_admin)->first();
        $other_admin_user = ItdpAdminUser::with('group', 'profile_perwadag_ln', 'profile_perwadag_ln.country_name')->whereId($id_other_admin)->first();
        $other_admin_group_name = ($other_admin_user->id_group == 4) ? "Perwadag" : "Dinas";
        $admin_group = $admin_user->id_group;

        $data['data'] = CscChattingCompanyAdmin::with('admin_user', 'company_user.profile', 'company_user.profile_buyer')->where('id_admin', $id_admin)->where('id_eother_admin', $id_other_admin)->orderBy('id', 'asc')->get();
        $data['pageTitle'] = "Chat " . $admin_user->group->group_name . " and " . $other_admin_group_name;
        $data['other_admin_group_name'] = $other_admin_group_name;
        $data['admin_group_name'] = $admin_user->group->group_name;
        $data['other_admin_user'] = $other_admin_user;
        $data['admin_user'] = $admin_user;
        $data['id_admin'] = $id_admin;
        $data['admin_group'] = $admin_group;

        return view('chatting.refresh', $data);
    }


    public function send_chat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        CscChattingCompanyAdmin::insert([
            'id_admin' => $request->id_admin,
            'id_other_admin' => $request->id_other_admin,
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

        $other_admin_user = ItdpAdminUser::whereId($request->id_other_admin)->first();
        $other_admin_id = $other_admin_user->id;
        $other_admin_email = $other_admin_user->email;
        $other_admin_name = $other_admin_user->name;


        //Send from Perwadag to Dinas
        if (Auth::user()->id_group == 4) {
            // Send from exportir to admin
            $keterangan = Auth::user()->name . "Respond Chat";
            // insert notif 
            Notif::insert([
                'to_role' => '5',
                'dari_nama' => Auth::user()->name,
                'dari_id' => Auth::user()->id,
                'untuk_nama' => $other_admin_name,
                'untuk_id' => $other_admin_id,
                'keterangan' => $keterangan,
                'url_terkait' => 'chat_admin_eks_imp/admin/',
                'id_terkait' => $admin_id . '/' . $other_admin_id,
                'waktu' => $date,
                'status_baca' => '0'
            ]);

            $data = [
                'email' => "",
                'email1' => $admin_email,
                'username' => $admin_name,
                'receiver' => $other_admin_name,
                'main_messages' => "",
                'bu' => "Perwadag",
                'id_admin' => $admin_id,
                'id_other_admin' => $other_admin_id,
            ];
            Mail::send('UM.user.sendchateksAdmin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['receiver']);
                $mail->subject('Perwadag Respond Chat');
            });
        } else if (Auth::user()->id_group == 5) {
            //Send from Dinas
            $keterangan = Auth::user()->name . "Respond Chat";
            // insert notif 
            Notif::insert([
                'to_role' => '4',
                'dari_nama' => Auth::user()->name,
                'dari_id' => Auth::user()->id,
                'untuk_nama' => $admin_name,
                'untuk_id' => $admin_id,
                'keterangan' => $keterangan,
                'url_terkait' => 'chat_admin_eks_imp/admin/',
                'id_terkait' => $admin_id . '/' . $other_admin_id,
                'waktu' => $date,
                'status_baca' => '0'
            ]);

            $data = [
                'email' => "",
                'email1' => $admin_email,
                'username' => $other_admin_name,
                'receiver' => $admin_name,
                'main_messages' => "",
                'bu' => "Perwadag",
                'id_admin' => $admin_id,
                'id_other_admin' => $other_admin_id,
            ];
            Mail::send('UM.user.sendchateksAdmin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['receiver']);
                $mail->subject('Dinas Respond Chat');
            });
        }
    }

    public function uploadFile(Request $request, $id_admin, $id_other_admin)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $file = $request->file('file_chat')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/ChatAdminCompanyFiles";
        $request->file('file_chat')->move($destinationPath, $file);

        CscChattingCompanyAdmin::insert([
            'id_admin' => $request->id_admin,
            'id_other_admin' => $request->id_other_admin,
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

        $other_admin_user = ItdpAdminUser::whereId($request->id_other_admin)->first();
        $other_admin_id = $other_admin_user->id;
        $other_admin_email = $other_admin_user->email;
        $other_admin_name = $other_admin_user->name;


        //Send from Perwadag to Dinas
        if (Auth::user()->id_group == 4) {
            // Send from exportir to admin
            $keterangan = Auth::user()->name . "Respond Chat";
            // insert notif 
            Notif::insert([
                'to_role' => '5',
                'dari_nama' => Auth::user()->name,
                'dari_id' => Auth::user()->id,
                'untuk_nama' => $other_admin_name,
                'untuk_id' => $other_admin_id,
                'keterangan' => $keterangan,
                'url_terkait' => 'chat_admin_eks_imp/admin/',
                'id_terkait' => $admin_id . '/' . $other_admin_id,
                'waktu' => $date,
                'status_baca' => '0'
            ]);

            $data = [
                'email' => "",
                'email1' => $admin_email,
                'username' => $admin_name,
                'receiver' => $other_admin_name,
                'main_messages' => "",
                'bu' => "Perwadag",
                'id_admin' => $admin_id,
                'id_other_admin' => $other_admin_id,
            ];
            Mail::send('UM.user.sendchateksAdmin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['receiver']);
                $mail->subject('Perwadag Respond Chat');
            });
        } else if (Auth::user()->id_group == 5) {
            //Send from Dinas
            $keterangan = Auth::user()->name . "Respond Chat";
            // insert notif 
            Notif::insert([
                'to_role' => '4',
                'dari_nama' => Auth::user()->name,
                'dari_id' => Auth::user()->id,
                'untuk_nama' => $admin_name,
                'untuk_id' => $admin_id,
                'keterangan' => $keterangan,
                'url_terkait' => 'chat_admin_eks_imp/admin/',
                'id_terkait' => $admin_id . '/' . $other_admin_id,
                'waktu' => $date,
                'status_baca' => '0'
            ]);

            $data = [
                'email' => "",
                'email1' => $admin_email,
                'username' => $other_admin_name,
                'receiver' => $admin_name,
                'main_messages' => "",
                'bu' => "Perwadag",
                'id_admin' => $admin_id,
                'id_other_admin' => $other_admin_id,
            ];
            Mail::send('UM.user.sendchateksAdmin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['receiver']);
                $mail->subject('Dinas Respond Chat');
            });
        }

        return redirect('chat_admin_eks_imp/' . encrypt($id_admin) . '/' . encrypt($id_other_admin));
    }
}
