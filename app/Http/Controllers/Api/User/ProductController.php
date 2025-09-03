<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\CscProductSingle;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Mail;

class ProductController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function findProductById(Request $request)
    {
        // dd($this->middleware('api.auth'));
        // dd(Auth::guard('userApi')->user());
        //  if(Auth::guard('userApi')->user()){
        $dataProduk = DB::table('csc_product_single')
            ->where('id_itdp_company_user', '=', $request->id_user)
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        $jsonResult = array();
        $data = $dataProduk;
        // for ($i = 0; $i < count($dataProduk); $i++) {
        //     $jsonResult[$i]["id"] = $dataProduk[$i]->id;
        //     $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
        //     $jsonResult[$i]["id_csc_product_level1"] = $dataProduk[$i]->id_csc_product_level1;
        //     $jsonResult[$i]["id_csc_product_level2"] = $dataProduk[$i]->id_csc_product_level2;
        //     $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
        //     $jsonResult[$i]["prodname_in"] = $dataProduk[$i]->prodname_in;
        //     $jsonResult[$i]["prodname_chn"] = $dataProduk[$i]->prodname_chn;
        //     $jsonResult[$i]["code_en"] = $dataProduk[$i]->code_en;
        //     $jsonResult[$i]["code_in"] = $dataProduk[$i]->code_in;
        //     $jsonResult[$i]["code_chn"] = $dataProduk[$i]->code_chn;
        //     $jsonResult[$i]["color_en"] = $dataProduk[$i]->color_en;
        //     $jsonResult[$i]["color_in"] = $dataProduk[$i]->color_in;
        //     $jsonResult[$i]["color_chn"] = $dataProduk[$i]->color_chn;
        //     $jsonResult[$i]["size_en"] = $dataProduk[$i]->size_en;
        //     $jsonResult[$i]["size_in"] = $dataProduk[$i]->size_in;
        //     $jsonResult[$i]["size_chn"] = $dataProduk[$i]->size_chn;
        //     $jsonResult[$i]["raw_material_en"] = $dataProduk[$i]->raw_material_en;
        //     $jsonResult[$i]["raw_material_in"] = $dataProduk[$i]->raw_material_in;
        //     $jsonResult[$i]["raw_material_chn"] = $dataProduk[$i]->raw_material_chn;
        //     $jsonResult[$i]["capacity"] = $dataProduk[$i]->capacity;
        //     $jsonResult[$i]["price_usd"] = $dataProduk[$i]->price_usd;
        //     $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
        //     $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
        //     $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
        //     $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
        //     $jsonResult[$i]["id_itdp_profil_eks"] = $dataProduk[$i]->id_itdp_profil_eks;
        //     $jsonResult[$i]["id_itdp_company_user"] = $dataProduk[$i]->id_itdp_company_user;
        //     $jsonResult[$i]["minimum_order"] = $dataProduk[$i]->minimum_order;
        //     $jsonResult[$i]["product_description_en"] = $dataProduk[$i]->product_description_en;
        //     $jsonResult[$i]["product_description_in"] = $dataProduk[$i]->product_description_in;
        //     $jsonResult[$i]["product_description_chn"] = $dataProduk[$i]->product_description_chn;
        //     $jsonResult[$i]["status"] = $dataProduk[$i]->status;
        //     $jsonResult[$i]["size_en"] = $dataProduk[$i]->size_en;
        //     $jsonResult[$i]["created_at"] = $dataProduk[$i]->created_at;
        //     $jsonResult[$i]["updated_at"] = $dataProduk[$i]->updated_at;
        //     $jsonResult[$i]["keterangan"] = $dataProduk[$i]->keterangan;
        //     $jsonResult[$i]["id_mst_hscodes"] = $dataProduk[$i]->id_mst_hscodes;
        // }
        // if (count($dataProduk) > 0) {
        //     $meta = [
        //         'code' => '200',
        //         'message' => 'Success',
        //         'status' => 'OK'
        //     ];
        //     $data = $jsonResult;
        //     $res['meta'] = $meta;
        //     $res['data'] = $data;
        //     return response($res);
        // } else {
        //     $meta = [
        //         'code' => '204',
        //         'message' => 'Data Not Found',
        //         'status' => 'No Content'
        //     ];
        //     $data = '';
        //     $res['meta'] = $meta;
        //     $res['data'] = $data;
        //     return response($res);
        // }
        if ($data) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function browseProduct(Request $request)
    {
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.id_itdp_company_user', '=', $request->id_user)
            ->select(
                'csc_product_single.id',
                'csc_product_single.prodname_en',
                'csc_product_single.image_1',
                'csc_product_single.image_2',
                'csc_product_single.image_3',
                'csc_product_single.image_4',
                'csc_product_single.id_csc_product',
                'itdp_company_users.type'
            )
            ->orderBy('csc_product_single.prodname_en', 'asc')
            ->get();
        //        dd($dataProduk);
        $jsonResult = array();
        for ($i = 0; $i < count($dataProduk); $i++) {
            $jsonResult[$i]["id"] = $dataProduk[$i]->id;
            $jsonResult[$i]["prodname_en"] = $dataProduk[$i]->prodname_en;
            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($dataProduk[$i]->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($dataProduk[$i]->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($dataProduk[$i]->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_4) : url('image/nia3.png');
            $jsonResult[$i]["id_csc_product"] = $dataProduk[$i]->id_csc_product;
            $jsonResult[$i]["type"] = $dataProduk[$i]->type;

            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/nia3.png');
        }
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function insertProduct(Request $request)
    {

        if ($request->id_role != "1" || $request->id_role != "4" || $request->id_role != "3") {
            $id_user = $request->id;
            $id_profil = $request->id_profil;
            $datenow = date("Y-m-d H:i:s");

            $idn = DB::table('csc_product_single')->max('id');
            $idnew = $idn + 1;

            $nama_file1 = NULL;
            $nama_file2 = NULL;
            $nama_file3 = NULL;
            $nama_file4 = NULL;

            $destination = 'uploads\Eksportir_Product\Image\\' . $idnew;
            if ($request->hasFile('image_1')) {
                $file1 = $request->file('image_1');
                $nama_file1 = time() . '_' . $request->prodname_en . '_' . $request->file('image_1')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            }

            if ($request->hasFile('image_2')) {
                $file2 = $request->file('image_2');
                $nama_file2 = time() . '_' . $request->prodname_en . '_' . $request->file('image_2')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
            }

            if ($request->hasFile('image_3')) {
                $file3 = $request->file('image_3');
                $nama_file3 = time() . '_' . $request->prodname_en . '_' . $request->file('image_3')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
            }

            if ($request->hasFile('image_4')) {
                $file4 = $request->file('image_4');
                $nama_file4 = time() . '_' . $request->prodname_en . '_' . $request->file('image_4')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
            }
            $insertRecord = CscProductSingle::insertGetId([
                //                'id' => $idnew,
                'id_csc_product' => $request->id_csc_product,
                'id_csc_product_level1' => $request->id_csc_product_level1,
                'id_csc_product_level2' => $request->id_csc_product_level2,
                'prodname_en' => $request->prodname_en,
                'prodname_in' => $request->prodname_in,
                'prodname_chn' => $request->prodname_chn,
                'code_en' => $request->code,
                'code_in' => $request->code,
                'code_chn' => $request->code_,
                'color_en' => $request->color_en,
                'color_in' => $request->color_in,
                'color_chn' => $request->color_chn,
                'size_en' => $request->size_en,
                'size_in' => $request->size_in,
                'size_chn' => $request->size_chn,
                'raw_material_en' => $request->raw_material_en,
                'raw_material_in' => $request->raw_material_in,
                'raw_material_chn' => $request->raw_material_chn,
                'capacity' => $request->capacity,
                'price_usd' => $this->setValue($request->price_usd),
                'image_1' => $nama_file1,
                'image_2' => $nama_file2,
                'image_3' => $nama_file3,
                'image_4' => $nama_file4,
                'id_itdp_profil_eks' => $id_profil,
                'id_itdp_company_user' => $id_user,
                'minimum_order' => $request->minimum_order,
                'product_description_en' => $request->product_description_en,
                'product_description_in' => $request->product_description_in,
                'product_description_chn' => $request->product_description_chn,
                'id_mst_hscodes' => ($request->id_hscode == '0') ? null : $request->id_hscode,
                'status' => $request->status,
                'created_at' => $datenow,
            ]);
            // if($insertRecord && $request->status == "1"){
            //     $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
            //     $users_email = [];
            //     foreach ($admin as $adm) {
            //         $notif = DB::table('notif')->insert([
            //             'dari_nama' => getCompanyName($id_user),
            //             'dari_id' => $id_user,
            //             'untuk_nama' => $adm->name,
            //             'untuk_id' => $adm->id,
            //             'keterangan' => 'New Product Published By '.getCompanyName($id_user).' with Title  "'.$request->prodname_en.'"',
            //             'url_terkait' => 'eksportir/verifikasi_product',
            //             'status_baca' => 0,
            //             'waktu' => $datenow,
            //             'id_terkait' => $insertRecord,
            //             'to_role' => 1,
            //         ]);

            //         array_push($users_email, $adm->email);
            //     }

            //     //Tinggal Ganti Email1 dengan email kemendag
            //     $data = [
            //         'company' => getCompanyName($id_user),
            //         'dari' => "Eksportir"
            //     ];

            //     Mail::send('eksportir.eksproduct.sendToAdmin', $data, function ($mail) use ($data, $users_email) {
            //         $mail->subject('Product Information');
            //         $mail->to($users_email);
            //     });
            // }
            if ($insertRecord) {
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => "Admin",
                    'untuk_id' => 1,
                    'keterangan' => 'New Product Published By ' . getCompanyName($id_user) . ' with Title  "' . $request->prodname_en . '"',
                    'url_terkait' => 'eksportir/verifikasi_product',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'id_terkait' => $insertRecord,
                    'to_role' => 1,
                ]);
                $meta = [
                    'code' => '200',
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => '204',
                    'message' => 'Data Not Found',
                    'status' => 'No Content'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function updateProduct(Request $request)
    {
        if ($request->id_role != "1" || $request->id_role != "4") {
            $id_user = $request->id;
            $id_profil = $request->id_profil;
            $datenow = date("Y-m-d H:i:s");

            $dtawal = DB::table('csc_product_single')->where('id', $request->id_product)->first();

            $destination = 'uploads\Eksportir_Product\Image\\' . $request->id_product;
            if ($request->hasFile('image_1')) {
                $file1 = $request->file('image_1');
                $nama_file1 = time() . '_' . $request->prodname_en . '_' . $request->file('image_1')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            } else {
                $nama_file1 = $dtawal->image_1;
            }

            if ($request->hasFile('image_2')) {
                $file2 = $request->file('image_2');
                $nama_file2 = time() . '_' . $request->prodname_en . '_' . $request->file('image_2')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
            } else {
                $nama_file2 = $dtawal->image_2;
            }

            if ($request->hasFile('image_3')) {
                $file3 = $request->file('image_3');
                $nama_file3 = time() . '_' . $request->prodname_en . '_' . $request->file('image_3')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
            } else {
                $nama_file3 = $dtawal->image_3;
            }

            if ($request->hasFile('image_4')) {
                $file4 = $request->file('image_4');
                $nama_file4 = time() . '_' . $request->prodname_en . '_' . $request->file('image_4')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
            } else {
                $nama_file4 = $dtawal->image_4;
            }


            $insertRecord = CscProductSingle::where('id', $request->id_product)->update([
                'id_csc_product' => $request->id_csc_product,
                'id_csc_product_level1' => $request->id_csc_product_level1,
                'id_csc_product_level2' => $request->id_csc_product_level2,
                'prodname_en' => $request->prodname_en,
                'prodname_in' => $request->prodname_in,
                'prodname_chn' => $request->prodname_chn,
                'code_en' => $request->code,
                'code_in' => $request->code,
                'code_chn' => $request->code_,
                'color_en' => $request->color_en,
                'color_in' => $request->color_in,
                'color_chn' => $request->color_chn,
                'size_en' => $request->size_en,
                'size_in' => $request->size_in,
                'size_chn' => $request->size_chn,
                'raw_material_en' => $request->raw_material_en,
                'raw_material_in' => $request->raw_material_in,
                'raw_material_chn' => $request->raw_material_chn,
                'capacity' => $request->capacity,
                'price_usd' => $this->setValue($request->price_usd),
                'image_1' => $nama_file1,
                'image_2' => $nama_file2,
                'image_3' => $nama_file3,
                'image_4' => $nama_file4,
                'minimum_order' => $request->minimum_order,
                'product_description_en' => $request->product_description_en,
                'product_description_in' => $request->product_description_in,
                'product_description_chn' => $request->product_description_chn,
                'status' => $request->status,
                'id_mst_hscodes' => $request->id_hscode,
                'updated_at' => $datenow,
            ]);
            if ($insertRecord) {
                $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => 400,
                    'message' => 'All Data Must Be Filled In',
                    'status' => 'Failed'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
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

    public function deleteProduct(Request $request)
    {
        if ($request->id_role != "1" || $request->id_role != "4") {
            $deleteRecord = DB::table('csc_product_single')->where('id', $request->id_product)
                ->delete();
            if ($deleteRecord) {
                $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => 400,
                    'message' => 'All Data Must Be Filled In',
                    'status' => 'Failed'
                ];
                $data = '';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
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

    public function detailProduk(Request $request)
    {
        //Product
        $data = DB::table('csc_product_single as cps')
            ->leftjoin('csc_product as cp1', 'cp1.id', 'cps.id_csc_product')
            ->leftjoin('csc_product as cp2', 'cp2.id', 'cps.id_csc_product_level1')
            ->leftjoin('csc_product as cp3', 'cp3.id', 'cps.id_csc_product_level2')
            ->select(
                'cps.*',
                'cp1.nama_kategori_en as nama_kategori_en',
                'cp1.nama_kategori_in as nama_kategori_in',
                'cp1.nama_kategori_chn as nama_kategori_chn',
                'cp2.nama_kategori_en as nama_kategori_en_level_1',
                'cp2.nama_kategori_in as nama_kategori_in_level_1',
                'cp2.nama_kategori_chn as nama_kategori_chn_level_1',
                'cp3.nama_kategori_en as nama_kategori_en_level_2',
                'cp3.nama_kategori_in as nama_kategori_in_level_2',
                'cp3.nama_kategori_chn as nama_kategori_chn_level_2'
            )
            ->where('cps.id', '=', $request->id)
            ->first();

        if ($data != null) {
            $result = [
               'id' => $data->id,
                'id_csc_product' => $data->id_csc_product,
                'id_csc_product_level1' => $data->id_csc_product_level1,
                'id_csc_product_level2' => $data->id_csc_product_level2,
                'prodname_en' => $data->prodname_en,
                'prodname_in' => $data->prodname_in,
                'prodname_chn' => $data->prodname_chn,
                'code_en' => $data->code_en,
                'code_in' => $data->code_in,
                'code_chn' => $data->code_chn,
                'color_en' => $data->color_en,
                'color_in' => $data->color_in,
                'color_chn' => $data->color_chn,
                'size_en' => $data->size_en,
                'size_in' => $data->size_in,
                'size_chn' => $data->size_chn,
                'raw_material_en' => $data->raw_material_en,
                'raw_material_in' => $data->raw_material_in,
                'raw_material_chn' => $data->raw_material_chn,
                'capacity' => $data->capacity,
                'price_usd' => $data->price_usd,
                'image_1' => ($data->image_1) ? url('uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_1) : url('image/nia3.png'),
                'image_2' => ($data->image_2) ? url('uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_2) : url('image/nia3.png'),
                'image_3' => ($data->image_3) ? url('uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_3) : url('image/nia3.png'),
                'image_4' => ($data->image_4) ? url('uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_4) : url('image/nia3.png'),
                'id_itdp_profil_eks' => $data->id_itdp_profil_eks,
                'id_itdp_company_user' => $data->id_itdp_company_user,
                'minimum_order' => $data->minimum_order,
                'product_description_en' => $data->product_description_en,
                'product_description_in' => $data->product_description_in,
                'product_description_chn' => $data->product_description_chn,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'keterangan' => $data->keterangan,
                'id_mst_hscodes' => $data->id_mst_hscodes,
                'hot' => $data->hot,
                'unit' => $data->unit,
                'satuan_pro' => $data->satuan_pro,
                'nama_kategori_en' => $data->nama_kategori_en,
                'nama_kategori_in' => $data->nama_kategori_in,
                'nama_kategori_chn' => $data->nama_kategori_chn,
                'nama_kategori_en_level_1' => $data->nama_kategori_en_level_1,
                'nama_kategori_in_level_1' => $data->nama_kategori_in_level_1,
                'nama_kategori_chn_level_1' => $data->nama_kategori_chn_level_1,
                'nama_kategori_en_level_2' => $data->nama_kategori_en_level_2,
                'nama_kategori_in_level_2' => $data->nama_kategori_in_level_2,
                'nama_kategori_chn_level_2' => $data->nama_kategori_chn_level_2,
            ];
            
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $result;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    function setValue($value)
    {
        $value = str_replace('.', '', $value);

        return (int)$value;
    }

    public function list_perusahaan(Request $request)
    {
        //List Category Product
        $sorteks = isset($request->sorteks) ? $request->sorteks : '';
        $cat_eks = isset($request->cat_eks) ? $request->cat_eks : '';
        $offset = isset($request->offset) ? $request->offset : '';
        $cari_eksportir = isset($request->cari_eksportir) ? $request->cari_eksportir : '';

        $arrayexporter = [];
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        $exhasprod = DB::table('csc_product_single')->select('id_itdp_profil_eks')->groupby('id_itdp_profil_eks')->get();
        // dd($exhasprod);
        if (count($exhasprod) > 0) {
            foreach ($exhasprod as $dexhasprod) {
                array_push($arrayexporter, $dexhasprod->id_itdp_profil_eks);
            }
        }
        // Data eksporter
        if ($request->sorteks) {
            if ($request->sorteks == "new") {
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            } else if ($request->sorteks == "asc") {
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            if ($request->cat_eks == NULL) {
                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                    $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha', 'eks_business_entity.nmbadanusaha')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        ->orderByRaw($col)
                        ->paginate(20);

                    $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        ->orderByRaw($col)
                        ->count();
                } else {
                    $search_eks = NULL;
                    $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha', 'eks_business_entity.nmbadanusaha')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->orderByRaw($col)
                        ->paginate(20);

                    $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->orderByRaw($col)
                        ->count();
                }
                $catActive = NULL;
                $get_cat_eks = NULL;
            } else {
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $get_cat_eks = $pisah[0] . '|' . $pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $get_cat_eks = $pisah;
                }

                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                } else {
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory($offset, 'data', $pisah, $request->lctnya, $request->cari_eksportir, $col);
                $coeksporter = $this->getQueryCategory($offset, 'count', $pisah, $request->locnya, $request->cari_eksportir, $col);
            }

            $sortingby = $request->sorteks;
        } else {
            if ($request->cat_eks == NULL) {
                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                    $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        // ->inRandomOrder()
                        ->paginate(20);

                    $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        // ->inRandomOrder()
                        ->count();
                } else {
                    $search_eks = NULL;
                    // dd('ini');
                    $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        // ->inRandomOrder()
                        ->paginate(20);
                    $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        // ->inRandomOrder()
                        ->count();
                }
                $catActive = NULL;
                $get_cat_eks = NULL;
            } else {
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $get_cat_eks = $pisah[0] . '|' . $pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $get_cat_eks = $pisah;
                }

                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                } else {
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory($offset, 'data', $pisah, $request->lctnya, $request->cari_eksportir, '', '');
                $coeksporter = $this->getQueryCategory($offset, 'count', $pisah, $request->locnya, $request->cari_eksportir, '', '');
            }
            $sortingby = NULL;
        }

        $kat = [];
        $data['eksporter'] = $eksporter;
        $data['coeksporter'] = $coeksporter;
        foreach ($eksporter as $k) {
            $kat[] = getKategoriDetail($k->id_user);
        }
        $data['kategori'] = $kat;

        if ($data['eksporter']) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    function getQueryCategory($offset, $jenis, $dt, $search, $sortcol, $sortby = null)
    {
        $array = [];
        if (is_array($dt)) {
            $perusahaan = DB::table('csc_product_single')
                ->where('id_itdp_company_user', '!=', null)
                ->where('id_csc_product', $dt[0])
                ->where('id_csc_product_level1', $dt[1])
                ->select('id_itdp_company_user')
                ->distinct('id_itdp_company_user')
                ->get();
            foreach ($perusahaan as $key) {
                if (!in_array($key->id_itdp_company_user, $array)) {
                    array_push($array, $key->id_itdp_company_user);
                }
            }
        } else {
            $perusahaan = DB::table('csc_product_single')
                ->where('id_itdp_company_user', '!=', null)
                ->where('id_csc_product', $dt)
                ->select('id_itdp_company_user')
                ->distinct('id_itdp_company_user')
                ->get();
            foreach ($perusahaan as $key) {
                if (!in_array($key->id_itdp_company_user, $array)) {
                    array_push($array, $key->id_itdp_company_user);
                }
            }
        }

        sort($array);

        if ($sortcol == "") {
            if ($search) {
                $eksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search . '%')
                    // ->inRandomOrder()
                    ->paginate(20);

                $coeksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search . '%')
                    // ->inRandomOrder()
                    ->count();
            } else {
                $eksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    // ->inRandomOrder()
                    ->paginate(20);

                $coeksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    // ->inRandomOrder()
                    ->count();
            }
        } else {
            if ($search) {
                $eksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search . '%')
                    ->orderBy($sortcol, $sortby)
                    ->paginate(20);

                $coeksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search . '%')
                    ->orderBy($sortcol, $sortby)
                    ->count();
            } else {
                $eksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->orderBy($sortcol, $sortby)
                    ->paginate(20);

                $coeksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->orderBy($sortcol, $sortby)
                    ->count();
            }
        }


        if ($jenis == "data") {
            return $eksporter;
        } else {
            return $coeksporter;
        }
    }

    public function list_perusahaan_detail(Request $request)
    {
        $id = isset($request->id) ? $request->id : null;
        $cat = isset($request->cat) ? $request->cat : null;
        $shortprodeks = isset($request->shortprodeks) ? $request->shortprodeks : null;
        $shortsrveks = isset($request->shortsrveks) ? $request->shortsrveks : null;

        $r = "1";
        $loc = app()->getLocale();
        if ($loc == "ch") {
            $lct = "chn";
            $lcts = "chn";
        } else if ($loc == "in") {
            $lct = "in";
            $lcts = "ind";
        } else {
            $lct = "en";
            $lcts = "en";
        }
        //Eksportir yg di Pilih

        $data_user = DB::table('itdp_company_users')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
            ->leftjoin('mst_incoterm', 'mst_incoterm.id', '=', 'itdp_profil_eks.id_incoterm')
            ->leftjoin('mst_payment', 'mst_payment.id', '=', 'itdp_profil_eks.id_payment')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('eks_business_role', 'eks_business_role.id', '=', 'itdp_profil_eks.id_business_role_id')
            ->leftjoin('eks_business_size', 'eks_business_size.id', '=', 'itdp_profil_eks.id_eks_business_size')
            ->leftjoin('mst_province', 'mst_province.id', '=', 'itdp_profil_eks.id_mst_province')
            ->select(
                'itdp_profil_eks.*',
                'itdp_profil_eks.badanusaha',
                'itdp_company_users.email',
                'itdp_company_users.status as status_company',
                'itdp_company_users.type',
                'itdp_company_users.id_role',
                'itdp_company_users.id as id_user',
                'itdp_company_users.foto_profil',
                'itdp_company_users.verified_at',
                'eks_business_entity.nmbadanusaha',
                'eks_business_role.nmtype',
                'eks_business_size.nmsize',
                'mst_incoterm.incoterm',
                'mst_payment.payment',
                'mst_province.province_en'
            )
            ->where('itdp_company_users.id', $id)
            ->get();

        $jenis = null;
        if (isset($cat) && $cat != 'all') {
            if ($shortprodeks) {
                //product pada eksportir
                $product = getProductbyEksportirCat($id, 12, $shortprodeks, $lct, $cat);
                $product2 = getProductbyEksportirCat($id, null, $shortprodeks, $lct, $cat);
                $coproduct = count($product2);
                $sortby = $shortprodeks;
            } else {
                //product pada eksportir
                $product = getProductbyEksportirCat($id, 12, null, $lct, $cat);
                $product2 = getProductbyEksportirCat($id, null, null, $lct, $cat);
                $coproduct = count($product2);
                $sortby = "";
            }
        } else {
            if ($shortprodeks) {
                //product pada eksportir
                $product = getProductbyEksportir($id, 12, $shortprodeks, $lct);
                $product2 = getProductbyEksportir($id, null, $shortprodeks, $lct);
                $coproduct = count($product2);
                $sortby = $shortprodeks;
            } else {
                //product pada eksportir
                $product = getProductbyEksportir($id, 12, null, $lct);
                $product2 = getProductbyEksportir($id, null, null, $lct);
                $coproduct = count($product2);
                $sortby = "";
            }
        }

        //get service
        if ($shortsrveks) {
            if ($shortsrveks == "new") {
                $col = "created_at DESC NULLS LAST";
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data_user[0]->id)
                    ->where('status', 2)
                    ->orderByRaw($col)
                    ->get();
            } else if ($shortsrveks == "asc") {
                $col = "nama_" . $lcts . " ASC NULLS LAST";
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data_user[0]->id)
                    ->where('status', 2)
                    ->orderByRaw($col)
                    ->get();
            } else {
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data_user[0]->id)
                    ->where('status', 2)
                    ->inRandomOrder()
                    ->get();
            }
            $sortbysrv = $shortsrveks;
        } else {
            $service = DB::table('itdp_service_eks')
                ->where('id_itdp_profil_eks', $data_user[0]->id)
                ->where('status', 2)
                ->inRandomOrder()
                ->get();
            $sortbysrv = "";
        }

        $negara_eks = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.tahun', 'mst_country.country', 'itdp_eks_destination.rasio_persen')
            ->join('mst_country', 'mst_country.id', '=', 'id_mst_country')
            ->where('id_itdp_profil_eks', $data_user[0]->id)
            ->get();

        // Produk
        $prod = DB::table('csc_product_single')
            ->select('prodname_en')
            ->where('id_itdp_profil_eks', $data_user[0]->id);

        $catprod = $prod->distinct()->pluck('id_csc_product');

        $categories = DB::table('csc_product')
            ->select('nama_kategori_in', 'nama_kategori_en', 'nama_kategori_chn')
            ->whereIn('id', $catprod)
            ->get();

        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $data_user[0]->id)
            ->get();

        $port = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'itdp_eks_port.tahun', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $data_user[0]->id)
            ->orderby('itdp_eks_port.tahun', 'desc')
            ->limit(1)
            ->get();

        $capacity = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', $data_user[0]->id)
            ->orderby('itdp_eks_production.tahun', 'desc')
            ->limit(1)
            ->get();

        $market = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $data_user[0]->id)
            ->orderby('itdp_eks_destination.tahun', 'desc')
            ->limit(1)
            ->get();

        $annual = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $data_user[0]->id)
            ->orderby('itdp_eks_sales.tahun', 'desc')
            ->limit(1)
            ->get();

        // $annuals = DB::select("select sum(nilai_ekspor) as suma from itdp_eks_sales where id_itdp_profil_eks='" . (int)$data->id . "'");
        $annuals = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', $data_user[0]->id)
            ->sum('nilai_ekspor');

        //jenis halaman
        $jenisnya = "eksportir";

        $pageTitle = $data_user[0]->company . " | Inaexport";
        $topMenu = "supplier";

        $categoryutama = DB::table('csc_product')
            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->select(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->groupby(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            // ->where('level_1', 0)
            // ->where('level_2', 0)
            ->where('id_itdp_company_user', $id)
            ->where('csc_product_single.status', 2)
            ->orderBy('nama_kategori_en', 'ASC')
            // ->limit(10)
            ->get();
        // dd($categoryutama);

        $profile = null;

        if (!empty(Auth::user())) {
            $profile = DB::table('itdp_admin_users as a')->join('itdp_admin_ln as b', 'a.id_admin_ln', '=', 'b.id')
                ->select('b.username', 'a.*', 'b.id_country', 'b.country AS id_mst_country')
                ->where('a.id', Auth::user()->id)->first();
        } else if (!empty(Auth::guard('eksmp')->user())) {
            $profile = DB::table('itdp_profil_imp as a')->join('itdp_company_users as b', 'a.id', '=', 'b.id_profil')
                ->select('b.username', 'a.*', 'b.foto_profil')
                ->where('b.id', Auth::guard('eksmp')->user()->id)->first();
        }

        $data['annuals'] = $annuals;
        $data['market'] = $market;
        $data['port'] = $port;
        $data['capacity'] = $capacity;
        $data['profile'] = $profile;
        $data['r'] = $r;
        $data['categoryutama'] = $categoryutama;
        $data['data'] = $data_user;
        $data['product'] = $product;
        $data['coproduct'] = $coproduct;
        $data['id'] = $id;
        $data['jenisnya'] = $jenisnya;
        $data['sortby'] = $sortby;
        $data['service'] = $service;
        $data['sortbysrv'] = $sortbysrv;
        $data['lcts'] = $lcts;
        $data['topMenu'] = $topMenu;
        $data['negara_eks'] = $negara_eks;
        $data['categories'] = $categories;
        $data['certificate'] = $certificate;
        $data['cat'] = $cat;
        if ($id) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }
}
