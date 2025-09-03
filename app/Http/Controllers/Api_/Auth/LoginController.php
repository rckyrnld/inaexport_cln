<?php

namespace App\Http\Api\Auth;

use App\Http\Api\Models\UserApi;
use App\Http\Api\Models\AdminApi;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

// use Tymon\JWTAuth\Facades\JWTAuth;
// use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    use Helpers;

    //  public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('guest:userApi')->except('logout');        
    //     $this->middleware('guest:adminApi')->except('logout');

    // }

    public function login(Request $request)
    {
        $idRole = $request->id_role;
        $token = null;
        $isTrue = false;
        if ($idRole != null) {

            if ($idRole == "1" || $idRole == "4") {
                if (Auth::guard('adminApi')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user = Auth::guard('adminApi')->user();
                    $token = JWTAuth::fromUser($user);
                    $insertToken = DB::select("update itdp_admin_users set remember_token='" . $token . "' where id=" . $user->id);
                    $isTrue = $insertToken;
                }
            } else {
                if (Auth::guard('userApi')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user = Auth::guard('userApi')->user();
                    $token = JWTAuth::fromUser($user);
                    $insertToken = DB::select("update itdp_company_users set remember_token='" . $token . "' where id=" . $user->id);
                    $isTrue = $insertToken;
                }
            }
// dd($user);
            if ($isTrue) {

                $datas = "";
                if ($idRole == 3) {
                    $datas = DB::Table('itdp_profil_imp')
                        ->where('id', '=', $user->id_profil)
                        ->get();
                } else {
                    $datas = DB::table('itdp_profil_eks')
                        ->where('id', '=', $user->id_profil)
                        ->get();
                }
                return $this->sendLoginResponse($request, $datas);
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        } else {
            // dd("masuk sini");
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function sendLoginResponse(Request $request, $datas)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($datas);
    }

    public function authenticated($datas)
    {
        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'Success'
        ];
        $data = $datas;
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
    }

    public function sendFailedLoginResponse()
    {
        $meta = [
            'code' => 401,
            'message' => 'Unauthorized',
            'status' => 'Failed'
        ];
        $data = [''];
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
    }

    public function logout()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:userApi')->except('logout');
        $this->middleware('guest:adminApi')->except('logout');


    }
}
