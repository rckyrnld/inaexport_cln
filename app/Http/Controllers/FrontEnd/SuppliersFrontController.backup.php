<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class SuppliersFrontController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        //Category Utama
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(9)
            ->get();

        $categoryutama2 = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('id', 'ASC')
            ->limit(8)
            ->get();
        return view('frontend.index', compact('categoryutama', 'categoryutama2'));
    }

    public function list_perusahaan(Request $request)
    {
        // dd($request->all());
        //List Category Product
        $arrayexporter = [];
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        $exhasprod = DB::table('csc_product_single')->select('id_itdp_profil_eks')->groupby('id_itdp_profil_eks')->get();
        // dd($exhasprod);
        if (count($exhasprod) > 0 ){
            foreach($exhasprod as $dexhasprod){
                array_push($arrayexporter,$dexhasprod->id_itdp_profil_eks);
            }
        }
        // Data eksporter
        if($request->sorteks){
            if($request->sorteks == "new"){
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            }else if($request->sorteks == "asc"){
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            if($request->cat_eks == NULL){
                if($request->cari_eksportir){
                    $search_eks = $request->cari_eksportir;
                    $eksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search_eks.'%')
                                ->orderByRaw($col)
                                ->paginate(12);

                    $coeksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search_eks.'%')
                                ->orderByRaw($col)
                                ->count();
                }else{
                    $search_eks = NULL;
                    $eksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->orderByRaw($col)
                                ->paginate(12);

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
            }else{
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah[0]).'">'.getCategoryName($pisah[0], $request->lctnya).'</a></li>';
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah[1]).'">'.getCategoryName($pisah[1], $request->lctnya).'</a></li>';
                    $get_cat_eks = $pisah[0].'|'.$pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah).'">'.getCategoryName($pisah, $request->lctnya).'</a></li>';
                    $get_cat_eks = $pisah;
                }

                if($request->cari_eksportir){
                    $search_eks = $request->cari_eksportir;
                }else{
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory('data', $pisah, $request->lctnya, $request->cari_eksportir, $col);
                $coeksporter = $this->getQueryCategory('count', $pisah, $request->locnya, $request->cari_eksportir, $col);
            }

            $sortingby = $request->sorteks;
        }else{
            if($request->cat_eks == NULL){
                if($request->cari_eksportir){
                    $search_eks = $request->cari_eksportir;
                    $eksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search_eks.'%')
                                ->inRandomOrder()
                                ->paginate(12);

                    $coeksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search_eks.'%')
                                ->inRandomOrder()
                                ->count();
                }else{
                    $search_eks = NULL;
                    // dd('ini');
                    $eksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->inRandomOrder()
                                ->paginate(12);
                    $coeksporter = DB::table('itdp_company_users')
                                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                                ->whereIn('itdp_profil_eks.id', $arrayexporter)
                                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                                ->where('itdp_company_users.id_role', 2)
                                ->where('itdp_company_users.status', 1)
                                ->inRandomOrder()
                                ->count();
                }
                $catActive = NULL;
                $get_cat_eks = NULL;
            }else{
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah[0]).'">'.getCategoryName($pisah[0], $request->lctnya).'</a></li>';
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah[1]).'">'.getCategoryName($pisah[1], $request->lctnya).'</a></li>';
                    $get_cat_eks = $pisah[0].'|'.$pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $catActive .= '<li><a href="'.url('/front_end/list_eksporter/category/'.$pisah).'">'.getCategoryName($pisah, $request->lctnya).'</a></li>';
                    $get_cat_eks = $pisah;
                }

                if($request->cari_eksportir){
                    $search_eks = $request->cari_eksportir;
                }else{
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory('data', $pisah, $request->lctnya, $request->cari_eksportir, '', '');
                $coeksporter = $this->getQueryCategory('count', $pisah, $request->locnya, $request->cari_eksportir, '', '');
            }
            $sortingby = NULL;
        }

        $jenisnya = "eksportir";
        $bgn = "list";
        // dd($jenisnya);
        return view('frontend.supplier.list_eksporter',['eksporter' => $eksporter->appends(Input::except('page'))], compact('categoryutama', 'catActive', 'coeksporter', 'search_eks', 'get_cat_eks', 'jenisnya', 'sortingby', 'bgn'));


    }

    function getQueryCategory($jenis, $dt, $lct, $search, $sortcol, $sortby)
    {
        $array = [];
        if(is_array($dt)){
            $perusahaan = DB::table('csc_product_single')
                    ->where('id_itdp_company_user', '!=', null)
                    ->where('id_csc_product', $dt[0])
                    ->where('id_csc_product_level1', $dt[1])
                    ->select('id_itdp_company_user')
                    ->distinct('id_itdp_company_user')
                    ->get();
            foreach ($perusahaan as $key) {
              if (!in_array($key->id_itdp_company_user, $array)){
                array_push($array, $key->id_itdp_company_user);
              }
            }
        }else{
            $perusahaan = DB::table('csc_product_single')
                    ->where('id_itdp_company_user', '!=', null)
                    ->where('id_csc_product', $dt)
                    ->select('id_itdp_company_user')
                    ->distinct('id_itdp_company_user')
                    ->get();
            foreach ($perusahaan as $key) {
              if (!in_array($key->id_itdp_company_user, $array)){
                array_push($array, $key->id_itdp_company_user);
              }
            }
        }

        sort($array);

        if($sortcol == ""){
            if($search){
                $eksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search.'%')
                            ->inRandomOrder()
                            ->paginate(12);

                $coeksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search.'%')
                            ->inRandomOrder()
                            ->count();
            }else{
                $eksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->inRandomOrder()
                            ->paginate(12);

                $coeksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->inRandomOrder()
                            ->count();
            }
        }else{
            if($search){
                $eksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search.'%')
                            ->orderBy($sortcol, $sortby)
                            ->paginate(12);

                $coeksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->where('itdp_profil_eks.company', 'ILIKE', '%'.$search.'%')
                            ->orderBy($sortcol, $sortby)
                            ->count();
            }else{
                $eksporter = DB::table('itdp_company_users')
                            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                            ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                            ->where('itdp_company_users.id_role', 2)
                            ->where('itdp_company_users.status', 1)
                            ->whereIn('itdp_company_users.id', $array)
                            ->orderBy($sortcol, $sortby)
                            ->paginate(12);

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


        if($jenis == "data"){
            return $eksporter;
        }else{
            return $coeksporter;
        }
    }

    public function getCategory(Request $request)
    {
        $name = $request->name;
        $loc = $request->loc;
        $srch = "nama_kategori_".$loc;
        $categoryutama = DB::table('csc_product')
            ->where($srch, 'ILIKE', '%'.$name.'%')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->limit(10)
            ->get();

        $result = "";
        foreach($categoryutama as $cu){
            $catprod1 = getCategoryLevel(1, $cu->id, "");
            $nk = "nama_kategori_".$loc; 
            if($cu->$nk == NULL){
                $nk = "nama_kategori_en";
            }

            if(count($catprod1) == 0){
                $result .= '<a href="'.url('/front_end/list_perusahaan/category/'.$cu->id).'" class="list-group-item">'.$cu->$nk.'</a>';
            }else{
                $result .= '<a onclick="openCollapse(\''.$cu->id.'\')" href="#menus'.$cu->id.'" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> '.$cu->$nk.' <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop'.$cu->id.'"></i></a>
                        <div class="collapse" id="menus'.$cu->id.'">';
                foreach($catprod1 as $cat1){
                    $result .= '<a href="'.url('/front_end/list_perusahaan/category/'.$cat1->id).'" class="list-group-item">'.$cat1->$nk.'</a>';
                }
                $result .= '</div>';
            }
        }

        echo $result;
    }

    public function eksportir_category($id, Request $request)
    {
        
        
        $loc = app()->getLocale();
        if($loc == "ch"){
            $lct = "chn";
        }else if($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }

        $urlsorting = "/front_end/list_perusahaan/category/".$id;
        //Category Product
        $catdata = DB::table('csc_product')->where('id', $id)->first();

        //List Category Product
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        $catActive = '';
        if($catdata->level_1 == 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->level_1.'|'.$catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 != 0){
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->level_2).'">'.getCategoryName($catdata->level_2, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_perusahaan/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->level_2.'|'.$catdata->level_1.'|'.$catdata->id;
        }

        $array = [];
        $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
              ->where(function ($query) use ($id) {
                      $query->where('id_csc_product', $id)
                            ->orWhere('id_csc_product_level1', $id)
                            ->orWhere('id_csc_product_level2', $id);
                  })
              ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
        foreach ($perusahaan as $key) {
          if (!in_array($key->id_itdp_company_user, $array)){
            array_push($array, $key->id_itdp_company_user);
          }
        }
        
        sort($array);

        if($request->sortekscat){
            if($request->sortekscat == "new"){
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            }else if($request->sortekscat == "asc"){
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->orderByRaw($col)
                        ->paginate(12);

            $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->orderByRaw($col)
                        ->count();

            $sortingby = $request->sortekscat;
        }else{
            $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->inRandomOrder()
                        ->paginate(12);

            $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->inRandomOrder()
                        ->count();

            $sortingby = NULL;
        }

        $jenisnya = "eksportir";
        $bgn = "category";

        return view('frontend.supplier.list_eksporter', compact('categoryutama', 'eksporter', 'catActive', 'coeksporter', 'get_cat_eks', 'jenisnya', 'urlsorting', 'bgn', 'sortingby'));
    }
    
    public function eksportir_category_seo($id,$catname, Request $request)
    {
        
        $loc = app()->getLocale();
        if($loc == "ch"){
            $lct = "chn";
        }else if($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }

        $urlsorting = "/perusahaan-kategori/".$id."/".slugifyTitle($catname);
        //Category Product
        $catdata = DB::table('csc_product')->where('id', $id)->first();

        //List Category Product
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        $catActive = '';
        if($catdata->level_1 == 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->id.'/'.slugifyTitle(getCategoryName($catdata->id, $lct))).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->level_1.'/'.slugifyTitle(getCategoryName($catdata->level_1, $lct))).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->id.'/'.slugifyTitle(getCategoryName($catdata->id, $lct))).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->level_1.'|'.$catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 != 0){
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->level_2.'/'.slugifyTitle(getCategoryName($catdata->level_2, $lct))).'">'.getCategoryName($catdata->level_2, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->level_1.'/'.slugifyTitle(getCategoryName($catdata->level_1, $lct))).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/perusahaan-kategori/'.$catdata->id.'/'.slugifyTitle(getCategoryName($catdata->id, $lct))).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $get_cat_eks = $catdata->level_2.'|'.$catdata->level_1.'|'.$catdata->id;
        }

        $array = [];
        $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
              ->where(function ($query) use ($id) {
                      $query->where('id_csc_product', $id)
                            ->orWhere('id_csc_product_level1', $id)
                            ->orWhere('id_csc_product_level2', $id);
                  })
              ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
        foreach ($perusahaan as $key) {
          if (!in_array($key->id_itdp_company_user, $array)){
            array_push($array, $key->id_itdp_company_user);
          }
        }
        
        sort($array);

        if($request->sortekscat){
            if($request->sortekscat == "new"){
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            }else if($request->sortekscat == "asc"){
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->orderByRaw($col)
                        ->paginate(12);

            $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->orderByRaw($col)
                        ->count();

            $sortingby = $request->sortekscat;
        }else{
            $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->inRandomOrder()
                        ->paginate(12);

            $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->whereIn('itdp_company_users.id', $array)
                        ->inRandomOrder()
                        ->count();

            $sortingby = NULL;
        }

        $jenisnya = "eksportir";
        $bgn = "category";

        return view('frontend.supplier.list_eksporter', compact('categoryutama', 'eksporter', 'catActive', 'coeksporter', 'get_cat_eks', 'jenisnya', 'urlsorting', 'bgn', 'sortingby'));
    }

    public function view_eksportir($id, Request $request)
    {
       
        
        $param = explode('-', $id);
        $id = $param[0];
        $loc = app()->getLocale(); 
        if($loc == "ch"){
            $lct = "chn";
            $lcts = "chn";
        }else if($loc == "in"){
            $lct = "in";
            $lcts = "ind";
        }else{
            $lct = "en";
            $lcts = "en";
        }
        //Eksportir yg di Pilih
        $data = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                ->where('itdp_company_users.id', $id)
                ->first();

        if($request->shortprodeks){
            //product pada eksportir
            $product = getProductbyEksportir($id, 12, $request->shortprodeks, $lct);
            $product2 = getProductbyEksportir($id, null, $request->shortprodeks, $lct);
            $coproduct = count($product2);
            $sortby = $request->shortprodeks;
        }else{
            //product pada eksportir
            $product = getProductbyEksportir($id, 12, null, $lct);
            $product2 = getProductbyEksportir($id, null, null, $lct);
            $coproduct = count($product2);
            $sortby = "";
        }

        //get service
        if($request->shortsrveks){
            if($request->shortsrveks == "new"){
              $col = "created_at DESC NULLS LAST";
              $service = DB::table('itdp_service_eks')
                        ->where('id_itdp_profil_eks', $data->id)
                        ->where('status', 2)
                        ->orderByRaw($col)
                        ->get();
            }else if($request->shortsrveks == "asc"){
              $col = "nama_".$lcts." ASC NULLS LAST";
              $service = DB::table('itdp_service_eks')
                        ->where('id_itdp_profil_eks', $data->id)
                        ->where('status', 2)
                        ->orderByRaw($col)
                        ->get();
            }else{
                $service = DB::table('itdp_service_eks')
                        ->where('id_itdp_profil_eks', $data->id)
                        ->where('status', 2)
                        ->inRandomOrder()
                        ->get();
            }
            $sortbysrv = $request->shortsrveks;
        }else{
            $service = DB::table('itdp_service_eks')
                        ->where('id_itdp_profil_eks', $data->id)
                        ->where('status', 2)
                        ->inRandomOrder()
                        ->get();
            $sortbysrv = "";
        }

        //jenis halaman
        $jenisnya = "eksportir";
        
        return view('frontend.supplier.view', compact('data', 'product', 'coproduct', 'id', 'jenisnya', 'sortby', 'service', 'sortbysrv','lcts'));
    }
}
