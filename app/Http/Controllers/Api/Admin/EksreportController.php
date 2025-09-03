<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mail;


class EksreportController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }

    public function searchcompany(Request $request)
    {
        $name = $request->search;
        $offset = $request->offset;
        $data = DB::table('itdp_profil_eks')
            ->where('itdp_profil_eks.company', 'like', '%' . $name . '%')
            ->orderBy('itdp_profil_eks.company', 'asc')
            ->limit(10)
            ->offset($offset)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
        }

        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
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
    }

    public function searchproduct(Request $request)
    {
        $id_profil = $request->id_profil;
        $search = $request->search;
        $offset = $request->offset;
        $data = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('itdp_company_users.id_profil', $id_profil)
            ->where('csc_product_single.prodname_en', 'like', '%' . $search . '%')
            ->orwhere('csc_product_single.prodname_in', 'like', '%' . $search . '%')
            ->orwhere('csc_product_single.prodname_chn', 'like', '%' . $search . '%')
            ->orderBy('csc_product_single.prodname_en', 'ASC')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["prodname_en"] = $data[$i]->prodname_en;
            $jsonResult[$i]["code_en"] = $data[$i]->code_en;
            $jsonResult[$i]["color_en"] = $data[$i]->color_en;
            $jsonResult[$i]["size_en"] = $data[$i]->size_en;
            $jsonResult[$i]["raw_material_en"] = $data[$i]->raw_material_en;
            $jsonResult[$i]["capacity"] = $data[$i]->capacity;
            $jsonResult[$i]["price_usd"] = $data[$i]->price_usd;
            $jsonResult[$i]["image_1"] = $path = ($data[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $id_profil . '/' . $data[$i]->image_1) : url('image/nia-01-01.jpg');
            $jsonResult[$i]["image_2"] = $path = ($data[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $id_profil . '/' . $data[$i]->image_2) : url('image/nia-01-01.jpg');
            $jsonResult[$i]["image_3"] = $path = ($data[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $id_profil . '/' . $data[$i]->image_3) : url('image/nia-01-01.jpg');
            $jsonResult[$i]["image_4"] = $path = ($data[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $id_profil . '/' . $data[$i]->image_4) : url('image/nia-01-01.jpg');
            $jsonResult[$i]["keterangan"] = $data[$i]->keterangan;
            $jsonResult[$i]["product_description_en"] = $data[$i]->product_description_en;
            if ($data[$i]->status == 1) {
                if ($data[$i]->show == 1) {
                    $jsonResult[$i]["status"] = "Publish - Not Verified";
                } else {
                    $jsonResult[$i]["status"] = "Unpublish - Not Verified";
                }
            } else if ($data[$i]->status == 2) {
                if ($data[$i]->show == 1) {
                    $jsonResult[$i]["status"] = "Publish - Verified";
                } else {
                    $jsonResult[$i]["status"] = "Unpublish - Verified";
                }
            } else if ($data[$i]->status == 3) {
                if ($data[$i]->show == 1) {
                    $jsonResult[$i]["status"] = "Publish - Verification Rejected";
                } else {
                    $jsonResult[$i]["status"] = "Unpublish - Verification Rejected";
                }
            } else if ($data[$i]->status == 9) {
                $jsonResult[$i]["status"] = "Deleted";
            } else {
                $jsonResult[$i]["status"] = "Hide";
            }
        }

        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
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
    }
}
