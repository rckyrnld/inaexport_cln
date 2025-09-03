<?php

namespace App\Http\Controllers;

use App\Eksmp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use Alert;

class LoginEIController extends Controller
{

    use AuthenticatesUsers;
    protected $guard = 'eksmp';
    protected $redirectTo = '/';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return auth()->guard('eksmp');
    }

    public function loginei(Request $request)
    {
        if (Auth::guard('eksmp')->attempt(['email' => $request->email2, 'password' => $request->password2])) {
            $caridata = DB::select("select * from itdp_company_users where email='" . $request->email2 . "'");
            foreach ($caridata as $dc) {
                $data1 = $dc->id_role;
                $data2 = $dc->id;
                $data3 = $dc->status;
            }
            //			dd($data3);
            //			if($data3 == "0"){
            //			    dd('tes');
            //                return '<script type="text/javascript">alert("hello!");</script>';
            //                return redirect()->back()->with('alert','hello');
            //                Alert::info('Info Message', 'Optional Title');

            //                dd('masuk 0');
            //                return redirect()->back()->with('alert', 'Updated!');
            //                return redirect()->route('/login')->with('jsAlert', 'testing');
            //                return view('frontend.');

            //                echo "<script>";
            //                echo "alert('hello');";
            //                echo "</script>";
            //                dd('masuk if');
            //                return redirect()->back()->with('alert', 'Updated!');
            //
            //            }else{
            //			    dd('masuk else');
            //            }

            date_default_timezone_set('Asia/Jakarta');
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP')) {
                $ipaddress = getenv('HTTP_CLIENT_IP');
            } else if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_X_FORWARDED')) {
                $ipaddress = getenv('HTTP_X_FORWARDED');
            } else if (getenv('HTTP_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            } else if (getenv('HTTP_FORWARDED')) {
                $ipaddress = getenv('HTTP_FORWARDED');
            } else if (getenv('REMOTE_ADDR')) {
                $ipaddress = getenv('REMOTE_ADDR');
            } else {
                $ipaddress = 'UNKNOWN';
            }


            //			 $tes = DB::table('log_user')->where('id_user',$data2)->get();
            //
            //            if(count($tes) < 1){
            //                $insertlogin = DB::select("insert into log_user (email,waktu,date,ip_address,id_role,id_user) values
            //                ('".$request->email2."','".Date('H:m:s')."','".Date('Y-m-d')."','".$ipaddress."','".$data1."','".$data2."')
            //                ");
            //
            //                if($data1 == 2){
            //                    return redirect()->intended('/profil')->with('warning', 'Please Fill Out Company Profile');
            //                }
            //                else if($data1 == 3){
            //                    return redirect()->intended('/profile')->with('warning', 'Please Fill Out Company Profile');
            //                }
            //            }else{
            //                $insertlogin = DB::select("insert into log_user (email,waktu,date,ip_address,id_role,id_user) values
            //                ('".$request->email2."','".Date('H:m:s')."','".Date('Y-m-d')."','".$ipaddress."','".$data1."','".$data2."')
            //                ");
            //                return redirect()->intended('/');
            //            }

            $insertlogin = DB::select("insert into log_user (email,waktu,date,ip_address,id_role,id_user) values 
                        ('" . $request->email2 . "','" . Date('H:m:s') . "','" . Date('Y-m-d') . "','" . $ipaddress . "','" . $data1 . "','" . $data2 . "')
                        ");

            if ($request->redirect != '' && decrypt($request->redirect) == 'business_matching') {
                return redirect()->intended('/front_end/event_zoom');
            } else if ($request->redirect != '' && decrypt($request->redirect) == 'market_information') {
                return redirect()->intended('/front_end/research-corner');
            } else if ($request->redirect != '' && decrypt($request->redirect) == 'trade_inquiry') {
                return redirect()->intended('/front_end/ourinqueris');
            } else if ($data1 == 2) {
                return redirect()->intended('/dashboard-seller')->with('warning', 'Harap update dan upload dokumen legal perusahaan');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return back()->withErrors(['email' => 'Email or password are wrong.']);
        }
    }

    public function checkstatus(Request $request)
    {
        $getstatus = DB::table('itdp_company_users')->where('email', $request->email2)->get();

        if (count($getstatus) < 1) {
            $baliknya = "notfound";
        } else {
            //            if($getstatus[0]->verified_at == null){
            //                $baliknya = "status0";
            //            }else{
            //                $baliknya = "statusoke";
            //            }
            if ($getstatus[0]->status == 2) {
                $baliknya = "status2";
            } else if (($getstatus[0]->status == 0 || $getstatus[0]->status == 3) && $getstatus[0]->type == "Luar Negeri") {
                $baliknya = "status0Exportir";
            } else if ($getstatus[0]->status == 0) {
                $baliknya = "statusoke";
                // $baliknya = "status0";
            } else {
                $baliknya = "statusoke";
            }
        }
        echo json_encode($baliknya);
    }

    //    public function changestatus(Request $request){
    //        DB::table('itdp_company_users')->where('email', $request->email)->update(['status'=>1]);
    //    }

    public function changestatus(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        //        $data = ;
        //        DB::table('itdp_company_users')->where('email', $request->email)->update(['status'=>1,'verified_at'=>$date]);
        DB::table('itdp_company_users')->where('email', $request->email)->update(['status' => 1, 'verified_at' => $date]);
        //        DB::table('itdp_company_users')->where('email', $request->email)->update(['verified_at'=>$date]);
    }
}
