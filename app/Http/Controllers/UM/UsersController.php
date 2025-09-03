<?php

namespace App\Http\Controllers\UM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\User;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $pageTitle = 'Users Administrator';
        //  $user = User::join('group','group.id_group','=','users.id_group')->orderBy('id', 'DESC')->get();
        $user = DB::select('select a.*,a.created_at as ca,b.* from itdp_admin_users a , "group" b where a.id_group!=2 and a.id_group!=3 and a.id_group = b.id_group order by a.id DESC');
        $url = '/user_save';
        // $group = Group::all();
        $nb = "group";
        $data = DB::select("select a.* from itdp_company_users a order by a.id desc ");
        $group = DB::select("select * from public.group where id_group!='2' and id_group!='3' order by id_group asc");
        return view('UM.user.index', compact('pageTitle', 'user', 'url', 'group', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getem($id)
    {
        // echo $id;die();
        $cek = DB::select("select * from vms.users where email='" . $id . "'");
        $itung = count($cek);
        if ($itung == 0) {
            echo "0";
        } else {
            echo "1";
        }
    }
    public function create()
    {
        //
    }

    public function createUserHelpdesk($username, $email, $password, $name)
    {

        $data["username"] = str_replace(' ', '', $username);
        $data["email"]    = $email;
        $data["password"] = $password;
        $data["name"]     = $name;

        $url = config("constants.HELPDESK_API_URL") . "operator";
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
        $JSONdata = json_decode($hasil, true);
        return $JSONdata;
    }

    public function editUserHelpdesk($id, $username, $email, $password, $name)
    {

        $data["username"] = str_replace(' ', '', $username);
        $data["email"]    = $email;
        $data["password"] = $password;
        $data["name"]     = $name;
        $data["id"]       = $id;

        $url = config("constants.HELPDESK_API_URL") . "operator/edit";
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
        $JSONdata = json_decode($hasil, true);
        return $JSONdata;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // DB::beginTransaction();

        // try {
        $this->validate($request, [
            'password' => 'required|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'required'
        ]);
        date_default_timezone_set('Asia/Jakarta');
        if ($request->id_group == 1) {
            $ins = $this->createUserHelpdesk($request->name, $request->email, $request->password, $request->name);
            if ($ins["meta"]["code"] == 200) {
                $id_helpdesk = $ins["meta"]["details"];
                $mess = "Akun tersimpan di Support Helpdesk";
            } else {
                $id_helpdesk = null;
                $mess = $ins["meta"]["message"];
            }
        } else {

            $id_helpdesk = null;
        }

        $insert = DB::table('itdp_admin_users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'password_real' => "-",
            'type' => "DJPEN",
            'created_at' => date('Y-m-d H:i:s'),
            'id_group' => $request->id_group,
            'id_helpdesk' => $id_helpdesk
        ]);

        if ($insert) {
            // DB::commit();
            if ($request->id_group == 3) {
                Session::flash('success', 'Register');
                if ($request->id_group == 1)
                    Session::flash($ins["meta"]["code"] == 200 ? 'success_support' : 'failed_support', $mess);
                return redirect('/users');
            } else {
                if ($request->id_group == 1)
                    Session::flash($ins["meta"]["code"] == 200 ? 'success_support' : 'failed_support', $mess);
                // dd($insert);
                return redirect('/users');
            }
        } else {
            Session::flash('failed', 'Menambah Data');
            if ($request->id_group == 1)
                Session::flash($ins["meta"]["code"] == 200 ? 'success_support' : 'failed_support', $mess);
            return redirect('/users');
        }
        // } catch (\Exception $th) {
        //     DB::rollback();
        //     return $th->getMessage();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Users Administrator';
        $user = User::join('group', 'group.id_group', '=', 'itdp_admin_users.id_group')->where('itdp_admin_users.id_group', '1')->get();
        $url = '/user_update/' . $id;
        $res = User::find($id);
        $group = Group::all();
        return view('UM.user.index', compact('pageTitle', 'user', 'url', 'group', 'res'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (empty($request->password) || $request->password == null || $request->password == "") {
            $update = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        } else {
            $this->validate($request, [
                'password' => 'same:password_confirm',
                'password_confirm' => 'required'
            ]);
            $update = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'password_real' => $request->password,
                'id_group' => $request->id_group
            ]);
        }

        $upd["meta"]["code"] = '';
        $upd["meta"]["message"] = '';
        if ($request->id_helpdesk) {
            $upd = $this->editUserHelpdesk($request->id_helpdesk, $request->name, $request->email, $request->password, $request->name);
            if ($upd["meta"]["code"] == 200)
                $mess = 'Akun terupdate di support helpdesk';
            else
                $mess = $upd["meta"]["message"];
        } else {
            $mess = $upd["meta"]["message"];
        }

        if ($update) {
            Session::flash('success', 'Mengubah Data');
            Session::flash($upd["meta"]["code"] == 200 ? 'success_support' : 'failed_support', $mess);
            return redirect('/users');
        } else {
            Session::flash($upd["meta"]["code"] == 200 ? 'success_support' : 'failed_support', $mess);
            Session::flash('failed', 'Mengubah Data');
            return redirect('/users');
        }
    }

    public function destroyHelpdesk($id)
    {

        $url = config("constants.HELPDESK_API_URL") . "operator/delete/" . $id;
        $ch = curl_init($url);
        $username = config("constants.HELPDESK_API_USERNAME");
        $password = config("constants.HELPDESK_API_PASSWORD");
        // curl connection
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $hasil = curl_exec($ch);
        $error = curl_error($ch);
        $JSONdata = json_decode($hasil, true);
        return $JSONdata;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idhelp = DB::table('itdp_admin_users')->where('id', $id)->first()->id_helpdesk;
        if ($idhelp)
            $deletehelpdesk = $this->destroyHelpdesk($idhelp);

        $hapususer = DB::select("delete from itdp_admin_users where id='" . $id . "'");

        return redirect()->back();
    }
}
