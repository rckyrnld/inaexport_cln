<?php

namespace App\Http\Controllers\Api\Auth\User;

use App\Http\Models\Api\UserApi;
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
        auth()->shouldUse('api_user');
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

    protected function respondWithToken($token, $email, $password) //: JsonResponse
    {
        $datas = '';

        $insertToken = DB::select("update itdp_company_users set remember_token='" . $token . "' where email='" . $email . "'");
        if ($insertToken) {
            $company = DB::Table('itdp_company_users')
                ->where('email', '=', $email)->get();
            //        dd($company);
            $incoterm = '';
            if ($company[0]->id_role == 3) {
                $datas = DB::Table('itdp_profil_imp')
                    ->where('id', '=', $company[0]->id_profil)
                    ->get();
                $incoterm = "";
            } else {
                $datas = DB::Table('itdp_profil_eks')
                    ->select('itdp_profil_eks.*', 'mst_incoterm.incoterm')
                    ->leftjoin('mst_incoterm', 'mst_incoterm.id', '=', 'itdp_profil_eks.id_incoterm')
                    ->where('itdp_profil_eks.id', '=', $company[0]->id_profil)
                    ->get();

                $incoterm = $datas[0]->incoterm;
            }
        }

        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'OK'
        ];
        if (empty($company[0]->agree) || $company[0]->agree == null) {
            $datas[0]->agree = 0;
        } else {
            $datas[0]->agree = 1;
        }
        $datas[0]->type = $company[0]->type;
        $datas[0]->access_token = $token;
        $datas[0]->id_user = $company[0]->id;
        $datas[0]->role_name = ($company[0]->id_role == 3 ? "Importir" : "Eksportir");
        $datas[0]->id_role = $company[0]->id_role;
        $datas[0]->password = $password;
        $datas[0]->username = $company[0]->username;
        $datas[0]->id_template_reject = ($company[0]->id_template_reject == null ? "" : $company[0]->id_template_reject);
        $datas[0]->keterangan_reject = $company[0]->keterangan_reject;
        $datas[0]->status_verif = $company[0]->status;
        $datas[0]->badanusaha = $datas[0]->badanusaha;
        $datas[0]->incoterm = $incoterm;
        //    $data = [
        //        'access_token' => $token,
        //        'token_type' => 'Bearer',
        //        'expires_in' => auth()->factory()->getTTL() * 60,
        //        'user_id' => auth()->user()->id,
        //        'role' => auth()->user()->id_role,
        //        'id_profil' => auth()->user()->id_profil,
        //        'name' => auth()->user()->username,
        //        'email' => auth()->user()->email,
        //        'type' => 'user' //api_user guard
        //    ];
        $data = $datas[0];
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;

        //    return response()->json([
        //        'access_token' => $token,
        //        'token_type' => 'Bearer',
        //        'expires_in' => auth()->factory()->getTTL() * 60,
        //        'user_id' => auth()->user()->id,
        //        'role' => auth()->user()->id_role,
        //        'id_profil' => auth()->user()->id_profil,
        //        'name' => auth()->user()->username,
        //        'email' => auth()->user()->email,
        //        'type' => 'user' //api_user guard
        //    ]);
    }
}
