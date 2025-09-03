<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Lang;
use Mail;

class TransactionFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        $pageTitle = "TEST";
        if(Auth::guard('eksmp')->user()->id_role == 3){
            return view('frontend.transaction.index', compact('pageTitle'));
        }else{
            return redirect('/');
        }
    }

    public function datanya()
    {
        $loc = app()->getLocale();
        $lct = "";
        if($loc == "ch"){
            $lct = "chn";
        }elseif($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }
        // dd($lct);
        $id_user = Auth::guard('eksmp')->user()->id;
        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.prodname_en, csc_product_single.prodname_in, csc_product_single.prodname_chn, csc_product_single.id_itdp_company_user, csc_product_single.image_1')
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            ->whereIn('csc_inquiry_br.status', [ 3, 4 ])
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('category', function ($mjl) use($lct) {
                $category = "-";
                $catbhs = "nama_kategori_".$lct;
                if($mjl->id_csc_prod_cat != NULL){
                    if($mjl->id_csc_prod_cat_level1 != NULL){
                        if($mjl->id_csc_prod_cat_level2 != NULL){
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level2)->first();
                            $category = $catprod->$catbhs;
                        }else{
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level1)->first();
                            $category = $catprod->$catbhs;
                        }
                    }else{
                        $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat)->first();
                        $category = $catprod->$catbhs;
                    }
                    
                }
                return $category;
            })
            ->addColumn('prodname', function ($mjl) use($lct) {
                $img1 = "image/noimage.jpg";
                if($mjl->image_1 != NULL){
                    $imge1 = 'uploads/Eksportir_Product/Image/'.$mjl->id_product.'/'.$mjl->image_1;
                    if(file_exists($imge1)) {
                      $img1 = 'uploads/Eksportir_Product/Image/'.$mjl->id_product.'/'.$mjl->image_1;
                    }
                }
                $imgnya = '<img src="'.url('/').'/'.$img1.'" alt="" class="myImg" onclick="openImage(\''.$img1.'\')" />';
                $prodname = "-";
                $prodbhs = "prodname_".$lct;
                if($mjl->$prodbhs != NULL){
                    $prodname = $mjl->$prodbhs;
                }

                return $imgnya .'&nbsp;&nbsp;&nbsp;&nbsp;'. $prodname;
            })
            ->addColumn('exportir', function ($mjl) use($lct) {
                $exp = "-";
                if($mjl->id_itdp_company_user != NULL){
                    $exp = getCompanyName($mjl->id_itdp_company_user);
                }

                return $exp;
            })
            ->addColumn('notrack', function ($mjl) use($lct) {
                $notracking = "-";
                return $notracking;
            })
            ->addColumn('origin', function ($mjl) use($lct) {
                $org = "Inquiry";
                return $org;
            })
            ->addColumn('date', function ($mjl) use($lct) {
                $datenya = "-";
                if($mjl->date != NULL){
                    $datenya = date('d/m/Y', strtotime($mjl->date));
                }

                return $datenya;
            })
            ->addColumn('kos', function ($mjl) use($lct) {
                $kosnya = "-";
                $kosbhs = "jenis_perihal_".$lct;
                if($mjl->$kosbhs != NULL){
                    $kosnya = $mjl->$kosbhs;
                }

                return $kosnya;
            })
            ->addColumn('msg', function ($mjl) use($lct) {
                $msgnya = "-";
                $msgbhs = "messages_".$lct;
                if($mjl->$msgbhs != NULL){
                    $num_char = 70;
                    $text = $mjl->$msgbhs;
                    if(strlen($text) > 70){
                        $cut_text = substr($text, 0, $num_char);
                        if ($text[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                            $cut_text = substr($text, 0, $new_pos);
                        }
                        $msgnya = $cut_text . '...';
                    }else{
                        $msgnya = $text;
                    }
                }

                return $msgnya;
            })
            ->addColumn('status', function ($mjl) use($lct) {
                $statnya = "-";
                if($mjl->status != NULL){
                    if($mjl->status == 0){
                        $stat = 1;
                    }else{
                        $stat = $mjl->status;
                    }

                    $statnya = Lang::get('inquiry.stat'.$stat);
                    if($stat == 4){
                        $statnya = '<span style="color: red;">'.Lang::get('inquiry.stat'.$stat).'</span>';
                    }
                }

                return $statnya;
            })
            ->rawColumns(['msg', 'prodname', 'status'])
            ->make(true);
    }

    public function create($id)
    {
        //
    }

    public function store($id, Request $request)
    {
        //
    }

    public function view($id)
    {
        //
    }

    public function edit()
    {
        # code...
    }

    public function update()
    {
        # code...
    }
}
