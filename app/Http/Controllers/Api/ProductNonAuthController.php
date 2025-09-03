<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ProductNonAuthController extends Controller
{

    // use AuthenticatesUsers;  
    // public function __construct()
    // {
    //    auth()->shouldUse('api_user');
    // }


    public function browseProduct(Request $request)
    {
        $offset = $request->offset;
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            //            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product.nama_kategori_en',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en'
            )
            ->orderBy('csc_product_single.id', 'desc')
            ->limit(10)
            ->offset($offset)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            if (empty($dataProduk[$i]->hot) || $dataProduk[$i]->hot == null || $dataProduk[$i]->hot == "") {
                $nhot = false;
            } else {
                $nhot = true;
            }
            $nnew = false;
            if (date('Y', strtotime($dataProduk[$i]->created_at)) == date('Y')) {
                if (date('m', strtotime($dataProduk[$i]->created_at)) == date('m')) {
                    $nnew = true;
                }
            }
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $jsonResult[$i]["created_at"] = $dataProduk[$i]->created_at;
            $jsonResult[$i]["is_hot"] = $nhot;
            $jsonResult[$i]["is_new"] = $nnew;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;

            $list_k = array();
            $list_k["code_en"] = $dataProduk[$i]->code_en;
            $list_k["color_en"] = $dataProduk[$i]->color_en;
            $list_k["size_en"] = $dataProduk[$i]->size_en;
            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
            $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["product_information"] = $list_k;
        }

        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findProduct(Request $request)
    {
        $offset = $request->offset;
        $id = $request->id_kategori;
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.id_csc_product', $id)
            ->orwhere('csc_product_single.id_csc_product_level1', $id)
            ->orwhere('csc_product_single.id_csc_product_level2', $id)
            //            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product.nama_kategori_en',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en'
            )
            ->orderBy('csc_product_single.id', 'desc')
            ->limit(10)
            ->offset($offset)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;

            $list_k = array();
            $list_k["code_en"] = $dataProduk[$i]->code_en;
            $list_k["color_en"] = $dataProduk[$i]->color_en;
            $list_k["size_en"] = $dataProduk[$i]->size_en;
            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
            $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["product_information"] = $list_k;
        }

        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function browseProductByKategori(Request $request)
    {
        // echo $request->id_kategori;die();
        // $id_kategori = $request->input('id_kategori');;
        // dd($request->id_kategori);
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.id_csc_product', $request->id_kategori)
            ->select(
                'csc_product_single.id',
                'csc_product_single.prodname_en',
                'csc_product_single.image_1',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type'
            )
            ->orderBy('csc_product_single.prodname_en', 'asc')
            ->get();
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function browseProductDetailBynameAndKategori(Request $request)
    {
        //        dd("haha");
        $queryaaa = $request->parameter;
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where(function ($query) use ($queryaaa) {
                $query->where('csc_product_single.prodname_en', 'ilike', '%' . $queryaaa . '%');
                $query->Orwhere('csc_product.nama_kategori_en', 'ilike', '%' . $queryaaa . '%');
            })
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product.nama_kategori_en',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en',
                'csc_product_single.created_at',
                'csc_product_single.hot'
            )
            ->get();

        //        dd($dataProduk);
        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            if (empty($dataProduk[$i]->hot) || $dataProduk[$i]->hot == null || $dataProduk[$i]->hot == "") {
                $nhot = false;
            } else {
                $nhot = true;
            }
            $nnew = false;
            if (date('Y', strtotime($dataProduk[$i]->created_at)) == date('Y')) {
                if (date('m', strtotime($dataProduk[$i]->created_at)) == date('m')) {
                    $nnew = true;
                }
            }
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            //            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product)->first()->nama_kategori_en;
            //            $jsonResult[$i]["csc_product_level1_desc"] = ($dataProduk[$i]->id_csc_product_level1) ? DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product_level1)->first()->nama_kategori_en : null;
            //            $jsonResult[$i]["csc_product_level2_desc"] = ($dataProduk[$i]->id_csc_product_level2) ? DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product_level2)->first()->nama_kategori_en : null;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            ////            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            ////            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            ////            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $jsonResult[$i]["created_at"] = $dataProduk[$i]->created_at;
            $jsonResult[$i]["is_hot"] = $nhot;
            $jsonResult[$i]["is_new"] = $nnew;
            $jsonResult[$i]["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            ////            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;
        }
        //        dd($jsonResult);
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = array();
            //            array_push($data, array(
            //                'name_product' => $dataProduk,
            //                'kategori' => $dataKategori
            //            ));
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function browseProductBynameAndKategori(Request $request)
    {
        $queryaaa = $request->parameter;
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where(function ($query) use ($queryaaa) {
                $query->where('csc_product_single.prodname_en', 'like', '%' . $queryaaa . '%');
            })
            ->select('csc_product_single.prodname_en')
            ->get();

        $dataKategori = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where(function ($query) use ($queryaaa) {
                $query->where('csc_product.nama_kategori_en', 'like', '%' . $queryaaa . '%');
            })
            ->select('csc_product.nama_kategori_en')
            ->get();
        //        dd($dataKategori);
        //        $jsonResult = array();
        //        for ($i = 0; $i < count($dataProduk); $i++) {
        //            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
        //            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product)->first()->nama_kategori_en;
        //            $jsonResult[$i]["csc_product_level1_desc"] = ($dataProduk[$i]->id_csc_product_level1) ? DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product_level1)->first()->nama_kategori_en : null;
        //            $jsonResult[$i]["csc_product_level2_desc"] = ($dataProduk[$i]->id_csc_product_level2) ? DB::table('csc_product')->where('id', $dataProduk[$i]->id_csc_product_level2)->first()->nama_kategori_en : null;
        ////            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
        ////            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
        //            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
        ////            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
        ////            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
        ////            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
        ////            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
        ////            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
        ////            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
        ////            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
        ////            $id_role = $dataProduk[$i]->id_role;
        ////            $id_profil = $dataProduk[$i]->id_profil;
        ////            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
        ////            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;
        //        }
        if (count($dataProduk || $dataKategori) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = array();
            array_push($data, array(
                'name_product' => $dataProduk,
                'kategori' => $dataKategori
            ));
            //            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function suggestProductname()
    {
        //        $queryaaa = $request->parameter;
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            //            ->where(function ($query) use ($queryaaa) {
            //                $query->where('csc_product_single.prodname_en', 'like', '%' . $queryaaa . '%');
            //            })
            ->select('csc_product_single.prodname_en')
            //            ->limit(1)
            ->get();
        //       dd($dataProduk);
        foreach ($dataProduk as $data) {
            $prod_name[] = $data->prodname_en;
        }
        //        dd($prod_name);
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findKategori()
    {
        $result = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        if (count($result) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $result;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $result;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function detailProduk(Request $request)
    {
        $dataProduka = DB::table('csc_product_single')
            //            ->select('id', 'id_itdp_profil_eks','prodname_en','id_csc_product','id_csc_product_level1','id_csc_product_level2')
            ->where('id', '=', $request->id)
            ->first();
        $dataProduka->company_name = DB::table('itdp_profil_eks')->where('id', $dataProduka->id_itdp_profil_eks)->first()->company;
        $dataProduka->csc_product_desc = DB::table('csc_product')->where('id', $dataProduka->id_csc_product)->first()->nama_kategori_en;
        $dataProduka->csc_product_level1_desc = ($dataProduka->id_csc_product_level1) ? DB::table('csc_product')->where('id', $dataProduka->id_csc_product_level1)->first()->nama_kategori_en : null;
        $dataProduka->csc_product_level2_desc = ($dataProduka->id_csc_product_level2) ? DB::table('csc_product')->where('id', $dataProduka->id_csc_product_level2)->first()->nama_kategori_en : null;
        $dataProduka->link_image_1 = $path = ($dataProduka->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_1) : url('image/nia3.png');
        $dataProduka->link_image_2 = $path = ($dataProduka->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_2) : url('image/nia3.png');
        $dataProduka->link_image_3 = $path = ($dataProduka->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_3) : url('image/nia3.png');
        $dataProduka->link_image_4 = $path = ($dataProduka->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_4) : url('image/nia3.png');
        $dataProduka->name_mst_hscodes = ($dataProduka->id_mst_hscodes) ? DB::table('mst_hscodes')->where('id', $dataProduka->id_mst_hscodes)->first()->desc_eng : "";
        $dataProduka->product_description_en = ($dataProduka->product_description_en) ? strip_tags($dataProduka->product_description_en) : null;

        $datas = DB::Table('itdp_profil_eks')
                    ->select('itdp_profil_eks.*', 'mst_incoterm.incoterm')
                    ->leftjoin('mst_incoterm', 'mst_incoterm.id', '=', 'itdp_profil_eks.id_incoterm')
                    ->where('itdp_profil_eks.id', '=', $dataProduka->id_itdp_profil_eks)
                    ->get();
            //    dd($datas);
        //            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;
        //            $list_k = array();
        //            $list_k["code_en"] = $dataProduk[$i]->code_en;
        //            $list_k["color_en"] = $dataProduk[$i]->color_en;
        //            $list_k["size_en"] = $dataProduk[$i]->size_en;
        //            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
        //            $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
        //            $jsonResult[$i]["product_information"] = $list_k;

        //        }
        //        dd($dataProduka);
        if (isset($dataProduka)) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataProduka;
            $res['meta'] = $meta;
            $res['data'] = $data;
            $res['data_eks'] = $datas;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getImageProduk($id, $image)
    {
        $path = public_path() . '/uploads/Eksportir_Product/Image/' . $id . '/' . $image;
        if (is_file($path)) {
            return response()->download($path);
        } else {
            return response()->download(public_path() . '/image/nia3.png');
        }
    }

    public function responseView($pathToFile, $filename)
    {

        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept, Authorization, X-Requested-With, Application, Origin, Authorization, APIKey, Timestamp, AccessToken',
            'Content-Disposition' => 'filename=' . $filename,
            'Pragma' => 'public',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => $this->getContentType($pathToFile),
            'Content-Length' => filesize($pathToFile)
        ];

        $response = new BinaryFileResponse($pathToFile, 200, $headers);
        return $response;
    }

    public function getRandomProduct()
    {
        //        $dataProduk = DB::table('itdp_company_users')
        //            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
        //            ->where('itdp_company_users.status', '=', 1)
        //            ->where('csc_product_single.status', 2)
        //            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
        //                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type')
        //            ->inRandomOrder()
        //            ->limit(6)
        //            ->get();
        //        $dataProduk = DB::table('itdp_company_users')
        //            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
        //            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
        //            ->where('itdp_company_users.status', '=', 1)
        //            ->where('csc_product_single.status', 2)
        ////            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
        //            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
        //                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type', 'csc_product_single.price_usd', 'csc_product.nama_kategori_en')
        //            ->inRandomOrder()
        //            ->limit(6)
        //            ->get();
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            // ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->orderby('csc_product_single.hot', 'asc')
            //            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'csc_product_single.id_itdp_company_user',
                'csc_product_single.capacity',
                'csc_product_single.minimum_order',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product.nama_kategori_en',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en'
            )

            // ->inRandomOrder()
            ->limit(6)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            if (empty($dataProduk[$i]->hot) || $dataProduk[$i]->hot == null || $dataProduk[$i]->hot == "") {
                $nhot = false;
            } else {
                $nhot = true;
            }

            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["id_itdp_company_user"] = $dataProduk[$i]->id_itdp_company_user;
            $jsonResult[$i]["capacity"] = $dataProduk[$i]->capacity;
            $jsonResult[$i]["minimum_order"] = $dataProduk[$i]->minimum_order;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $jsonResult[$i]["is_hot"] = $nhot;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;

            $list_k = array();
            $list_k["code_en"] = $dataProduk[$i]->code_en;
            $list_k["color_en"] = $dataProduk[$i]->color_en;
            $list_k["size_en"] = $dataProduk[$i]->size_en;
            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
            $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["product_information"] = $list_k;
        }
        //        dd($dataProduk);
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $getJSON = array();
            //            foreach ($dataProduk as $item) {
            //                array_push($getJSON, array(
            //                    "id" => $item->id,
            //                    "prodname_en" => $item->prodname_en,
            //                    "id_csc_product" => $item->id_csc_product,
            //                    "type" => $item->type,
            //                    "image_1" => $path = ($item->image_1) ? url('uploads/Eksportir_Product/Image/' . $item->id . '/' . $item->image_1) : url('image/nia3.png'),
            //                    "nama_kategori_en" => $item->nama_kategori_en,
            //                    "price_usd" => $item->price_usd
            //                ));
            //            }
            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            //            $data = data;
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getKategorina()
    {

        $dataProduk = DB::table('csc_product')
            ->where('csc_product.level_1', 0)
            ->where('csc_product.level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["logo"] = $path = ($dataProduk[$i]->logo) ? url('uploads/Product/Icon/' . $dataProduk[$i]->logo) : url('image/nia3.png');
        }
        //        dd($dataProduk);
        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getSubKategorina(Request $request)
    {
        $id = $request->level_1;
        $dataProduk = DB::table('csc_product')
            ->where('csc_product.level_1', $id)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["logo"] = $path = ($dataProduk[$i]->logo) ? url('uploads/Product/Icon/' . $dataProduk[$i]->logo) : url('image/nia3.png');
        }
        //        dd($dataProduk);
        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getSubKategorina2(Request $request)
    {
        $id = $request->level_2;
        $dataProduk = DB::table('csc_product')
            ->where('csc_product.level_1', $id)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["logo"] = $path = ($dataProduk[$i]->logo) ? url('uploads/Product/Icon/' . $dataProduk[$i]->logo) : url('image/nia3.png');
        }
        //        dd($dataProduk);
        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getprodukBaru()
    {
        //        $dataProduk = DB::table('itdp_company_users')
        //            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
        //            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
        //            ->where('itdp_company_users.status', '=', 1)
        //            ->where('csc_product_single.status', 2)
        ////            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
        //            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
        //                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type', 'csc_product_single.price_usd', 'csc_product.nama_kategori_en')
        //            ->orderBy('csc_product_single.created_at', 'ASC')
        //            ->limit(6)
        //            ->get();
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            //            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product.nama_kategori_en',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en'
            )
            ->orderBy('csc_product_single.id', 'desc')
            ->limit(6)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;

            $list_k = array();
            $list_k["code_en"] = $dataProduk[$i]->code_en;
            $list_k["color_en"] = $dataProduk[$i]->color_en;
            $list_k["size_en"] = $dataProduk[$i]->size_en;
            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
            $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["product_information"] = $list_k;
        }
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $getJSON = array();
            //            foreach ($dataProduk as $item) {
            //                array_push($getJSON, array(
            //                    "id" => $item->id,
            //                    "prodname_en" => $item->prodname_en,
            //                    "id_csc_product" => $item->id_csc_product,
            //                    "type" => $item->type,
            //                    "image_1" => $path = ($item->image_1) ? url('uploads/Eksportir_Product/Image/' . $item->id . '/' . $item->image_1) : url('image/nia3.png'),
            //                    "nama_kategori_en" => $item->nama_kategori_en,
            //                    "price_usd" => $item->price_usd
            //                ));
            //            }
            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            //            $data = data;
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function populerCategories()
    {
        $tambahan[0] = array(
            "id" => 0,
            "level_1" => 0,
            "level_2" => 0,
            "nama_kategori_en" => "All Categories",
            "nama_kategori_in" => "Semua Kategori",
            "nama_kategori_chn" => "农业",
            "created_at" => null,
            "updated_at" => null,
            "type" => "-",
            "logo" =>  url('uploads/Product/Icon/allkat.png')
        );

        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(6)
            ->get();
        /*$categoryutama[0] = 
		([
		 "id": 0,
        "level_1": 0,
        "level_2": 0,
        "nama_kategori_en": "All Categories",
        "nama_kategori_in": "Semua Kategori",
        "nama_kategori_chn": "农业",
        "created_at": null,
        "updated_at": null,
        "type": "-",
        "logo": "http://localhost:7777/itdp2/public/uploads/Product/Icon/1575873599_icon-Agriculture_00-homepage-slicing_17.png"	
		]);*/
        $i = 0;

        foreach ($categoryutama as $value) {
            $tambahan[] = array(
                "id" => $value->id,
                "level_1" => $value->level_1,
                "level_2" => $value->level_2,
                "nama_kategori_en" => $value->nama_kategori_en,
                "nama_kategori_in" => $value->nama_kategori_in,
                "nama_kategori_chn" => $value->nama_kategori_chn,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                "type" => $value->type,
                "logo" => url('uploads/Product/Icon/' . $value->logo)
            );
            $categoryutama[$i]->logo = url('uploads/Product/Icon/' . $value->logo);
            $i++;
        }

        if (count($categoryutama) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $res['meta'] = $meta;
            $res['data'] = $tambahan;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $categoryutama;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function productByCategories(Request $request)
    {
        $offset = $request->offset;
        $categories = DB::table('csc_product')
            ->select('id')
            ->where('id', $request->id_csc)
            ->orWhere('level_1', $request->id_csc)
            ->orWhere('level_2', $request->id_csc)
            ->get();

        foreach ($categories as $nilai) {
            $id_csc[] = $nilai->id;
        }

        $dataProduk = DB::table('csc_product_single')
            ->select(
                'csc_product_single.id',
                'itdp_company_users.id_profil',
                'itdp_company_users.id_role',
                'csc_product_single.*',
                'csc_product_single.image_1',
                'csc_product_single.product_description_en',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'csc_product_single.id_itdp_company_user',
                'csc_product_single.capacity',
                'csc_product_single.minimum_order',
                'itdp_company_users.type',
                'csc_product_single.price_usd',
                'csc_product_single.code_en',
                'csc_product_single.color_en',
                'csc_product_single.size_en',
                'csc_product_single.raw_material_en'
            )
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->whereIn('id_csc_product', $id_csc)
            ->orWhereIn('id_csc_product_level1', $id_csc)
            ->orWhereIn('id_csc_product_level2', $id_csc)
            ->limit(10)
            ->offset($offset)
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            if (empty($dataProduk[$i]->hot) || $dataProduk[$i]->hot == null || $dataProduk[$i]->hot == "") {
                $nhot = false;
            } else {
                $nhot = true;
            }
            $nnew = false;
            if (date('Y', strtotime($dataProduk[$i]->created_at)) == date('Y')) {
                if (date('m', strtotime($dataProduk[$i]->created_at)) == date('m')) {
                    $nnew = true;
                }
            }
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["id_profil"] = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["id_role"] = $dataProduk[$i]->id_role;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["id_itdp_company_user"] = $dataProduk[$i]->id_itdp_company_user;
            $jsonResult[$i]["capacity"] = $dataProduk[$i]->capacity;
            $jsonResult[$i]["minimum_order"] = $dataProduk[$i]->minimum_order;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;
            $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
            $jsonResult[$i]["created_at"] = $dataProduk[$i]->created_at;
            $jsonResult[$i]["is_hot"] = $nhot;
            $jsonResult[$i]["is_new"] = $nnew;
            $id_role = $dataProduk[$i]->id_role;
            $id_profil = $dataProduk[$i]->id_profil;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;

            $list_k = array();
            $list_k["code_en"] = $dataProduk[$i]->code_en;
            $list_k["color_en"] = $dataProduk[$i]->color_en;
            $list_k["size_en"] = $dataProduk[$i]->size_en;
            $list_k["raw_material_en"] = $dataProduk[$i]->raw_material_en;
            // $list_k["nama_kategori_en"] = $dataProduk[$i]->nama_kategori_en;
            $jsonResult[$i]["product_information"] = $list_k;
        }

        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getslide()
    {
        $dataProduk = DB::table('mst_slide')
            ->where('mst_slide.publish', '=', 1)
            ->orderBy('mst_slide.id', 'desc')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["keterangan"] = $dataProduk[$i]->keterangan;
            $jsonResult[$i]["file_img"] = $path = ($dataProduk[$i]->file_img) ? url('uploads/slider/' . $dataProduk[$i]->file_img) : url('image/nia3.png');
            $jsonResult[$i]["created_at"] = $dataProduk[$i]->created_at;
        }

        if (count($dataProduk) > 0) {
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
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
}
