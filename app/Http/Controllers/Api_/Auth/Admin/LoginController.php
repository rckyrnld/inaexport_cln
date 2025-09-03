<?php

namespace App\Http\Controllers\Api\Auth\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }

    public function login(Request $request)
    {
        try {
            // dd( $request->only('email', 'password'));
            $credentials = $request->only('email', 'password');

            if (!$token = auth()->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ])) {
                return $this->respondFailed();
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token!'], 401);
        }

        return $this->respondWithToken($token, $request->email, $request->password);
    }

    protected function respondFailed()
    {
        $meta = [
            'code' => 100,
            'message' => 'Unauthorized',
            'status' => 'Failed'
        ];
        $data = "";
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
    }

    protected function respondWithToken($token, $email, $password)//: JsonResponse
    {

        $insertToken = DB::select("update itdp_admin_users set remember_token='" . $token . "' where email='" . $email . "'");
        if ($insertToken) {
            $company = DB::Table('itdp_admin_users')
                ->where('email', '=', $email)->get();
        }
        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'OK'
        ];
        $datas = array();
        for ($i = 0; $i < count($company); $i++) {
            $datas[$i]["id"] = $company[$i]->id;
            $datas[$i]["company"] = $company[$i]->name;
            $datas[$i]["email"] = $company[$i]->email;
            $datas[$i]["password"] = $company[$i]->password;
            $datas[$i]["id_role"] = $company[$i]->id_group;
            $datas[$i]["type"] = $company[$i]->type;
            $datas[$i]["access_token"] = $token;
        }
//        $datas[0]->id_user = $company[0]->id;
//        $datas[0]->role_name = ($company[0]->id_role == 3 ? "Importir" : "Eksportir");
//
//        $datas[0]->password = $password;
//        $datas[0]->username = $company[0]->username;
//        $datas[0]->id_template_reject = ($company[0]->id_template_reject == null ? "" : $company[0]->id_template_reject);
//        $datas[0]->keterangan_reject = $company[0]->keterangan_reject;

        $data = $datas;
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'Bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60,
//            'user_id' => auth()->user()->id,
//            'role' => auth()->user()->id_group,
//            'name' => auth()->user()->name,
//            'email' => auth()->user()->email,
//            'type' => 'admin' //api_user guard
//        ]);
    }
}