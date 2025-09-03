<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use PDF;

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
        // if (count($exhasprod) > 0) {
        //     foreach ($exhasprod as $dexhasprod) {
        //         array_push($arrayexporter, $dexhasprod->id_itdp_profil_eks);
        //     }
        // }
        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');

        // Data eksporter
        //echo $request->sorteks;die();
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
                        ->paginate(12);

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
            } else {
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah[0]) . '">' . getCategoryName($pisah[0], $request->lctnya) . '</a></li>';
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah[1]) . '">' . getCategoryName($pisah[1], $request->lctnya) . '</a></li>';
                    $get_cat_eks = $pisah[0] . '|' . $pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah) . '">' . getCategoryName($pisah, $request->lctnya) . '</a></li>';
                    $get_cat_eks = $pisah;
                }

                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                } else {
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory('data', $pisah, $request->lctnya, $request->cari_eksportir, $col, '');
                $coeksporter = $this->getQueryCategory('count', $pisah, $request->locnya, $request->cari_eksportir, $col, '');
            }

            $sortingby = $request->sorteks;
        } else {
            if ($request->cat_eks == NULL) {
                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                    $eksporter = DB::table('itdp_company_users')
                        ->leftjoin('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        ->inRandomOrder()
                        ->paginate(12);

                    $coeksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                        ->where('itdp_company_users.id_role', 2)
                        ->where('itdp_company_users.status', 1)
                        ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search_eks . '%')
                        ->inRandomOrder()
                        ->count();
                } else {
                    $search_eks = NULL;
                    $eksporter = DB::table('itdp_company_users')
                        ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->whereIn('itdp_profil_eks.id', $arrayexporter)
                        ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
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
            } else {
                $catActive = '';
                if (strstr($request->cat_eks, '|')) {
                    $pisah = explode('|', $request->cat_eks);
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah[0]) . '">' . getCategoryName($pisah[0], $request->lctnya) . '</a></li>';
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah[1]) . '">' . getCategoryName($pisah[1], $request->lctnya) . '</a></li>';
                    $get_cat_eks = $pisah[0] . '|' . $pisah[1];
                } else {
                    $pisah = $request->cat_eks;
                    $catActive .= '<li><a href="' . url('/front_end/list_eksporter/category/' . $pisah) . '">' . getCategoryName($pisah, $request->lctnya) . '</a></li>';
                    $get_cat_eks = $pisah;
                }

                if ($request->cari_eksportir) {
                    $search_eks = $request->cari_eksportir;
                } else {
                    $search_eks = "";
                }

                $eksporter = $this->getQueryCategory('data', $pisah, $request->lctnya, $request->cari_eksportir, '', '');
                $coeksporter = $this->getQueryCategory('count', $pisah, $request->locnya, $request->cari_eksportir, '', '');
            }
            $sortingby = NULL;
        }

        $jenisnya = "eksportir";
        $bgn = "list";

        $pageTitle = "Indonesian Suppliers | Inaexport";
        $topMenu = "supplier";


        return view('frontend.supplier.list_eksporter', ['eksporter' => $eksporter->appends(Input::except('page'))], compact('categoryutama', 'catActive', 'coeksporter', 'search_eks', 'get_cat_eks', 'jenisnya', 'sortingby', 'bgn', 'pageTitle', 'topMenu'));
    }

    function getQueryCategory($jenis, $dt, $lct, $search, $sortcol, $sortby)
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
                    ->inRandomOrder()
                    ->paginate(12);

                $coeksporter = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                    ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil')
                    ->where('itdp_company_users.id_role', 2)
                    ->where('itdp_company_users.status', 1)
                    ->whereIn('itdp_company_users.id', $array)
                    ->where('itdp_profil_eks.company', 'ILIKE', '%' . $search . '%')
                    ->inRandomOrder()
                    ->count();
            } else {
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
                    ->paginate(12);

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


        if ($jenis == "data") {
            return $eksporter;
        } else {
            return $coeksporter;
        }
    }

    public function getCategory(Request $request)
    {
        $name = $request->name;
        $loc = $request->loc;
        $srch = "nama_kategori_" . $loc;
        $categoryutama = DB::table('csc_product')
            ->where($srch, 'ILIKE', '%' . $name . '%')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->limit(10)
            ->get();

        $result = "";
        foreach ($categoryutama as $cu) {
            $catprod1 = getCategoryLevel(1, $cu->id, "");
            $nk = "nama_kategori_" . $loc;
            if ($cu->$nk == NULL) {
                $nk = "nama_kategori_en";
            }

            if (count($catprod1) == 0) {
                $result .= '<a href="' . url('/front_end/list_perusahaan/category/' . $cu->id) . '" class="list-group-item">' . $cu->$nk . '</a>';
            } else {
                $result .= '<a onclick="openCollapse(\'' . $cu->id . '\')" href="#menus' . $cu->id . '" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> ' . $cu->$nk . ' <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop' . $cu->id . '"></i></a>
                        <div class="collapse" id="menus' . $cu->id . '">';
                foreach ($catprod1 as $cat1) {
                    $result .= '<a href="' . url('/front_end/list_perusahaan/category/' . $cat1->id) . '" class="list-group-item">' . $cat1->$nk . '</a>';
                }
                $result .= '</div>';
            }
        }

        echo $result;
    }

    public function eksportir_category($id, Request $request)
    {


        $loc = app()->getLocale();
        if ($loc == "ch") {
            $lct = "chn";
        } else if ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }

        $urlsorting = "/front_end/list_perusahaan/category/" . $id;
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
        if ($catdata->level_1 == 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->id) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->level_1) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->id) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_1 . '|' . $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 != 0) {
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->level_2) . '">' . getCategoryName($catdata->level_2, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->level_1) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/front_end/list_perusahaan/category/' . $catdata->id) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_2 . '|' . $catdata->level_1 . '|' . $catdata->id;
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
            if (!in_array($key->id_itdp_company_user, $array)) {
                array_push($array, $key->id_itdp_company_user);
            }
        }

        sort($array);

        if ($request->sortekscat) {
            if ($request->sortekscat == "new") {
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            } else if ($request->sortekscat == "asc") {
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
        } else {
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

        $pageTitle = $catdata->nama_kategori_en . " | Inaexport";
        $topMenu = "supplier";

        return view('frontend.supplier.list_eksporter', compact('categoryutama', 'eksporter', 'catActive', 'coeksporter', 'get_cat_eks', 'jenisnya', 'urlsorting', 'bgn', 'sortingby', 'pageTitle', 'topMenu'));
    }

    public function eksportir_category_seo($id, $catname, Request $request)
    {

        $loc = app()->getLocale();
        if ($loc == "ch") {
            $lct = "chn";
        } else if ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }

        $urlsorting = "/perusahaan-kategori/" . $id . "/" . slugifyTitle($catname);
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
        if ($catdata->level_1 == 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->level_1 . '/' . slugifyTitle(getCategoryName($catdata->level_1, $lct))) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_1 . '|' . $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 != 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->level_2 . '/' . slugifyTitle(getCategoryName($catdata->level_2, $lct))) . '">' . getCategoryName($catdata->level_2, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->level_1 . '/' . slugifyTitle(getCategoryName($catdata->level_1, $lct))) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_2 . '|' . $catdata->level_1 . '|' . $catdata->id;
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
            if (!in_array($key->id_itdp_company_user, $array)) {
                array_push($array, $key->id_itdp_company_user);
            }
        }

        sort($array);

        if ($request->sortekscat) {
            if ($request->sortekscat == "new") {
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            } else if ($request->sortekscat == "asc") {
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            $eksporter = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
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
        } else {
            $eksporter = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
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

        $pageTitle = "Supplier " . $catdata->nama_kategori_en . " | Inaexport";
        $topMenu = "supplier";

        return view('frontend.supplier.list_eksporter', compact('categoryutama', 'eksporter', 'catActive', 'coeksporter', 'get_cat_eks', 'jenisnya', 'urlsorting', 'bgn', 'sortingby', 'pageTitle', 'topMenu'));
    }

    public function eksportir_category_seo_profil($id, $catname, Request $request)
    {
        $r = "1";
        $param = explode('-', $id);
        $id = $param[0];
        $loc = app()->getLocale();
        if ($loc == "ch") {
            $lct = "chn";
        } else if ($loc == "in") {
            $lct = "in";
        } else {
            $lct = "en";
        }

        $urlsorting = "/perusahaan-kategori-profil/" . $id . "/" . slugifyTitle($catname);
        //Category Product
        $catdata = DB::table('csc_product')->where('id', $id)->first();

        $data = DB::table('itdp_company_users')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('eks_business_role', 'eks_business_role.id', '=', 'itdp_profil_eks.id_business_role_id')
            ->select('itdp_profil_eks.*', 'itdp_profil_eks.badanusaha', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'eks_business_entity.nmbadanusaha', 'eks_business_role.nmtype')
            ->where('itdp_company_users.id', Auth::guard('eksmp')->user()->id)
            ->first();



        $capacity = DB::table('itdp_production_capacity')
            ->where('id_itdp_profil_eks', $id)
            ->get();

        //List Category Product
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        $catActive = '';
        if ($catdata->level_1 == 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 == 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->level_1 . '/' . slugifyTitle(getCategoryName($catdata->level_1, $lct))) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_1 . '|' . $catdata->id;
        } else if ($catdata->level_1 != 0 && $catdata->level_2 != 0) {
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->level_2 . '/' . slugifyTitle(getCategoryName($catdata->level_2, $lct))) . '">' . getCategoryName($catdata->level_2, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->level_1 . '/' . slugifyTitle(getCategoryName($catdata->level_1, $lct))) . '">' . getCategoryName($catdata->level_1, $lct) . '</a></li>';
            $catActive .= '<li><a href="' . url('/perusahaan-kategori-profil/' . $catdata->id . '/' . slugifyTitle(getCategoryName($catdata->id, $lct))) . '">' . getCategoryName($catdata->id, $lct) . '</a></li>';
            $get_cat_eks = $catdata->level_2 . '|' . $catdata->level_1 . '|' . $catdata->id;
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
            if (!in_array($key->id_itdp_company_user, $array)) {
                array_push($array, $key->id_itdp_company_user);
            }
        }

        sort($array);

        if ($request->sortekscat) {
            if ($request->sortekscat == "new") {
                $col = "itdp_company_users.created_at DESC NULLS LAST";
            } else if ($request->sortekscat == "asc") {
                $col = "itdp_profil_eks.company ASC NULLS LAST";
            }
            $eksporter = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
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
        } else {
            $eksporter = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->join('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->select('itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha')
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

        if ($request->shortprodeks) {
            //product pada eksportir
            $product = getProductbyEksportir($id, 12, $request->shortprodeks, $lct);
            $product2 = getProductbyEksportir($id, null, $request->shortprodeks, $lct);
            $coproduct = count($product2);
            $sortby = $request->shortprodeks;
        } else {
            //product pada eksportir
            $product = getProductbyEksportir($id, 12, null, $lct);
            $product2 = getProductbyEksportir($id, null, null, $lct);
            $coproduct = count($product2);
            $sortby = "";
        }

        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $id)
            ->get();



        $jenisnya = "eksportir";
        $bgn = "category";

        $pageTitle = "Supplier " . $catdata->nama_kategori_en . " | Inaexport";
        $topMenu = "supplier";

        return view('frontend.supplier.view_new', compact('param', 'r', 'id', 'product', 'product2', 'coproduct', 'sortby', 'certificate', 'capacity', 'data', 'categoryutama', 'eksporter', 'catActive', 'coeksporter', 'get_cat_eks', 'jenisnya', 'urlsorting', 'bgn', 'sortingby', 'pageTitle', 'topMenu'));
    }

    public function view_eksportir($id, $cat = null, $send = null, Request $request)
    {

        $r = "1";
        $param = explode('-', $id);
        $id = $param[0];
        $nama_perusahaan = $param[0];
        $kategori = isset($param[2]) ? $param[2] : null;
        $eo = $request->eo;
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

        $data = DB::table('itdp_company_users')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
            ->leftjoin('mst_incoterm', 'mst_incoterm.id', '=', 'itdp_profil_eks.id_incoterm')
            ->leftjoin('mst_payment', 'mst_payment.id', '=', 'itdp_profil_eks.id_payment')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('eks_business_role', 'eks_business_role.id', '=', 'itdp_profil_eks.id_business_role_id')
            ->leftjoin('eks_business_size', 'eks_business_size.id', '=', 'itdp_profil_eks.id_eks_business_size')
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
                'mst_payment.payment'
            )
            ->where('itdp_company_users.id', $id)
            ->first();

        $jenis = null;
        if (isset($cat) && $cat != 'all') {
            // $jenis = DB::table('csc_product')->
            if ($request->shortprodeks) {
                //product pada eksportir
                $product = getProductbyEksportirCat($id, 12, $request->shortprodeks, $lct, $cat);
                $product2 = getProductbyEksportirCat($id, null, $request->shortprodeks, $lct, $cat);
                $coproduct = count($product2);
                $sortby = $request->shortprodeks;
            } else {
                //product pada eksportir
                $product = getProductbyEksportirCat($id, 12, null, $lct, $cat);
                $product2 = getProductbyEksportirCat($id, null, null, $lct, $cat);
                $coproduct = count($product2);
                $sortby = "";
            }
        } else {
            if ($request->shortprodeks) {
                //product pada eksportir
                $product = getProductbyEksportir($id, 12, $request->shortprodeks, $lct);
                $product2 = getProductbyEksportir($id, null, $request->shortprodeks, $lct);
                $coproduct = count($product2);
                $sortby = $request->shortprodeks;
            } else {
                //product pada eksportir
                $product = getProductbyEksportir($id, 12, null, $lct);
                $product2 = getProductbyEksportir($id, null, null, $lct);
                $coproduct = count($product2);
                $sortby = "";
            }
        }


        //get service
        if ($request->shortsrveks) {
            if ($request->shortsrveks == "new") {
                $col = "created_at DESC NULLS LAST";
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data->id)
                    ->where('status', 2)
                    ->orderByRaw($col)
                    ->get();
            } else if ($request->shortsrveks == "asc") {
                $col = "nama_" . $lcts . " ASC NULLS LAST";
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data->id)
                    ->where('status', 2)
                    ->orderByRaw($col)
                    ->get();
            } else {
                $service = DB::table('itdp_service_eks')
                    ->where('id_itdp_profil_eks', $data->id)
                    ->where('status', 2)
                    ->inRandomOrder()
                    ->get();
            }
            $sortbysrv = $request->shortsrveks;
        } else {
            $service = DB::table('itdp_service_eks')
                ->where('id_itdp_profil_eks', $data->id)
                ->where('status', 2)
                ->inRandomOrder()
                ->get();
            $sortbysrv = "";
        }

        $negara_eks = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.tahun', 'mst_country.country', 'itdp_eks_destination.rasio_persen')
            ->join('mst_country', 'mst_country.id', '=', 'id_mst_country')
            ->where('id_itdp_profil_eks', $data->id)
            ->get();

        // Produk
        $prod = DB::table('csc_product_single')
            ->select('prodname_en')
            ->where('id_itdp_profil_eks', $data->id);

        $catprod = $prod->distinct()->pluck('id_csc_product');

        $categories = DB::table('csc_product')
            ->select('nama_kategori_in', 'nama_kategori_en', 'nama_kategori_chn')
            ->whereIn('id', $catprod)
            ->get();

        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $data->id)
            ->get();

        // foreach ($certificate as $ce) {
        //     $id_certif = $ce->id;

        //     $certificatemodal = DB::table('certificate')
        //         ->where('id_itdp_profil_eks', $data->id)
        //         ->where('id', $id_certif)
        //         ->get();
        // }



        // $cprod = $prod->count();
        // dd($cprod);

        $port = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'itdp_eks_port.tahun', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_port.tahun', 'desc')
            ->limit(1)
            ->get();

        $capacity = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', $data->id)
            ->orderby('itdp_eks_production.tahun', 'desc')
            ->limit(1)
            ->get();

        $market = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_destination.tahun', 'desc')
            ->limit(1)
            ->get();

        $annual = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_sales.tahun', 'desc')
            ->limit(1)
            ->get();



        $annuals = DB::select("select sum(nilai_ekspor) as suma from itdp_eks_sales where id_itdp_profil_eks='" . $data->id . "'");

        //  $annuals = DB::table('itdp_eks_sales')
        //     ->select('sum(itdp_eks_sales.nilai_ekspor) as sumexport')
        //     ->where('id_itdp_profil_eks', '=', $data->id)
        //     ->get();

        //jenis halaman
        $jenisnya = "eksportir";

        $pageTitle = $data->company . " | Inaexport";
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

        $tabName = "";
        if ($request->has('shortprodeks')) {
            $tabName = "products";
        } else {
            $tabName = "about-us";
        }

        return view('frontend.supplier.view_new', compact('tabName', 'kategori', 'annuals', 'annual', 'market', 'port', 'capacity', 'profile', 'r', 'categoryutama', 'data', 'product', 'coproduct', 'id', 'jenisnya', 'sortby', 'service', 'sortbysrv', 'lcts', 'pageTitle', 'topMenu', 'negara_eks', 'categories', 'prod', 'certificate', 'nama_perusahaan', 'cat', 'send'));
    }


    public function certif_modal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $id_profil)
            ->where('id', $request->id)
            ->get();

        return view('frontend.supplier.view_new', compact('id_profil', 'certificate'));
    }

    public function br_importir_add_suplai(request $request, $id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        if (!empty(Auth::guard('eksmp')->user())) {
            $subyek = $request->subyek;
            $valid = $request->valid;
            $spec = $request->spec;
            $eo = $request->eo;
            $neo = $request->neo;
            $ch1 = str_replace(".", "", $request->tp);
            $tp = str_replace(",", ".", $ch1);
            $ntp = $request->ntp;
            $country = DB::table('mst_country')->orderby('country', 'asc')->get();
            $profile = DB::table('itdp_profil_imp as a')->join('itdp_company_users as b', 'a.id', '=', 'b.id_profil')
                ->select('b.username', 'a.*', 'b.foto_profil')
                ->where('a.id', Auth::guard('eksmp')->user()->id)->first();

            $product = DB::table('csc_product_single')
                ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                ->where('itdp_company_users.status', 1)
                // ->where('csc_product_single.status', 2)
                ->orderby('csc_product_single.id', 'DESC')
                // ->inRandomOrder()
                ->limit(10)
                ->get();
            $pageTitle = "Buying Request Importer";
            $topMenu = "supplier";
            $r = "1";
            $categoryutama = DB::table('csc_product')
                ->where('level_1', 0)
                ->where('level_2', 0)
                ->orderBy('nama_kategori_en', 'ASC')
                // ->limit(9)
                ->get();
            $get_perusahaan = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->where('itdp_company_users.id', $id)
                ->first();
            return view('frontend.supplier.add-inquiri', compact('country', 'profile', 'id', 'get_perusahaan', 'product', 'categoryutama', 'r', 'subyek', 'valid', 'spec', 'eo', 'neo', 'tp', 'ntp', 'pageTitle', 'topMenu'));
        } else if (!empty(Auth::user())) {
            $subyek = $request->subyek;
            $valid = $request->valid;
            $spec = $request->spec;
            $eo = $request->eo;
            $neo = $request->neo;
            $ch1 = str_replace(".", "", $request->tp);
            $tp = str_replace(",", ".", $ch1);
            $ntp = $request->ntp;
            $country = DB::table('mst_country')->orderby('country', 'asc')->get();
            $profile = DB::table('itdp_admin_users as a')->join('itdp_admin_ln as b', 'a.id_admin_ln', '=', 'b.id')
                ->select('b.username', 'a.*', 'b.id_country', 'b.country')
                ->where('a.id', Auth::user()->id)->first();
            $product = DB::table('csc_product_single')
                ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                ->where('itdp_company_users.status', 1)
                // ->where('csc_product_single.status', 2)
                ->orderby('csc_product_single.id', 'DESC')
                // ->inRandomOrder()
                ->limit(10)
                ->get();
            $pageTitle = "Buying Request Importer";
            $topMenu = "supplier";
            $r = "1";
            $categoryutama = DB::table('csc_product')
                ->where('level_1', 0)
                ->where('level_2', 0)
                ->orderBy('nama_kategori_en', 'ASC')
                // ->limit(9)
                ->get();
            $get_perusahaan = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                // ->where('itdp_company_users.id', $id)
                ->where('itdp_company_users.id', $id)
                ->first();
            Session::put('id_perusahaan', $id);
            return view('frontend.supplier.add-inquiri-admin', compact('country', 'profile', 'id', 'get_perusahaan', 'product', 'categoryutama', 'r', 'subyek', 'valid', 'spec', 'eo', 'neo', 'tp', 'ntp', 'pageTitle', 'topMenu'));
        } else {
            return redirect('/login');
        }
    }

    public function br_importir_save_new(Request $request)
    {
        // dd(Session::get('id_perusahaan'));
        // dd($request->all());
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        if ($request->tp == null) {
            $ch2 = 0;
        } else {
            $ch1 = str_replace(".", "", $request->tp);
            $ch2 = str_replace(",", ".", $ch1);
        }

        $prod = null;
        $subyek2 = null;

        if (isset($request->subyek2)) {
            $prod = DB::table('csc_product_single')->where('id', $request->subyek2)->first();
            $subyek2 = $request->subyek2;
        }

        /*
		$kumpulcat = $request->category;
		$kumpulcat2 = $request->category.",";
		$h = explode(",",$request->category);
		// echo $kumpulcat2;die();
		*/
        // dd($request->t2s);
        $cat = 0;
        $cat1 = 0;
        $cat2 = 0;

        if (isset($request->category[0]) || isset($request->t2s) || isset($request->t3s)) {
            if ($request->t2s == 0 && $request->t3s == 0) {
                $kumpulcat2 =  $request->category[0] . ',';
                $cat =  $request->category[0] . ',';
            } else if ($request->t3s == 0) {
                $kumpulcat2 =  $request->category[0] . ',' . $request->t2s . ',';
                $cat1 = $request->t2s;
            } else {
                $kumpulcat2 =  $request->category[0] . ',' . $request->t2s . ',' . $request->t3s . ',';
                $cat3 = $request->t3s;
            }
        }

        if (isset($prod)) {
            $kumpulcat2 = $prod->id_csc_product . ',';
            $cat =  ($prod->id_csc_product) ? $prod->id_csc_product : 0;
            if (isset($prod->id_csc_product_level1)) {
                $kumpulcat2 .= $prod->id_csc_product_level1 . ',';
                $cat1 =  ($prod->id_csc_product_level1) ? $prod->id_csc_product_level1 : 0;
            }
            if (isset($prod->id_csc_product_level2)) {
                $kumpulcat2 .= $prod->id_csc_product_level2 . ',';
                $cat2 =  ($prod->id_csc_product_level2) ? $prod->id_csc_product_level2 : 0;
            }
        }

        // if ($request->gabungan2 == 0) {
        //     $kumpulcat2 = $request->gabungan;
        // } else {
        //     $kumpulcat2 = $request->gabungan . ',' . $request->gabungan2;
        // }

        $id_eks = (isset($request->id_eks)) ? $request->id_eks : Session::get('id_perusahaan');
        // $request->session()->forget('id_perusahaan');
        // dd(Session::get('id_perusahaan'));
        if (empty($request->file('image'))) {
            $file = "";
        } else {
            $file = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . "/uploads/buy_request";
            $request->file('image')->move($destinationPath, $file);
        }

        if (!empty(Auth::guard('eksmp')->user())) {

            $insert = DB::select("
                insert into csc_buying_request(
                    subyek,
                    id_csc_product_single,
                    valid,
                    id_mst_country,
                    city,
                    id_csc_prod_cat,
                    id_csc_prod_cat_level1,
                    id_csc_prod_cat_level2,
                    shipping,
                    spec,
                    files,
                    eo,
                    neo,
                    tp,
                    ntp,
                    by_role,
                    id_pembuat,
                    date,
                    id_csc_prod,
                    publish
                    ) 
                    values
                    ('" . $request->subyek . "',
                    '" . $subyek2 . "',
                    '" . $request->valid . "',
                    '" . $request->country . "',
                    '" . $request->city . "',
                    '" . $cat . "',
                    '" . $cat1 . "',
                    '" . $cat2 . "',
                    '" . $request->ship . "',
                    '" . $request->spec . "',
                    '" . $file . "',
                    '" . $request->eo . "',
                    '" . $request->neo . "',
                    '" . $ch2 . "',
                    '" . $request->ntp . "',
                    '3',
                    '" . Auth::guard('eksmp')->user()->id . "',
                    '" . date('Y-m-d H:m:s') . "',
                    '" . $kumpulcat2 . "',
                    '" . (($request->publish == "true") ? 'true' : 'false') . "')
                    RETURNING id");

            $insert_br = DB::table('csc_buying_request_join')->insert([
                'id_br' => $insert[0]->id,
                'id_eks' => $id_eks,
                'status_join' => 0,
                'date' => date('Y-m-d')
            ]);

            // $carimax = DB::select("select max(id) as maxid from csc_buying_request ");
            // foreach ($carimax as $cm) {
            //     $maxid = $cm->maxid;
            // }

            //log
            $insert = DB::select("
                insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
                ('" . Auth::guard('eksmp')->user()->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','" . Auth::guard('eksmp')->user()->id_role . "'
                ,'" . Auth::guard('eksmp')->user()->id . "','4','created buying request')");

            //end log
            // masuknya awalnya kesini, tapi karna berubah nampilin data exportir dulu jadinya ini di komen dulu
            // echo "<a href='".url('br_importir_bc/'.$maxid)."' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
            // echo "<a onclick='yz($maxid)' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
            // echo $maxid;

            return redirect('/front_end/history');
        } else if (!empty(Auth::user())) {
            $insert = DB::select("
                insert into csc_buying_request(
                    subyek,
                    id_csc_product_single,
                    valid,
                    id_mst_country,
                    city,
                    id_csc_prod_cat,
                    id_csc_prod_cat_level1,
                    id_csc_prod_cat_level2,
                    shipping,
                    spec,
                    files,
                    eo,
                    neo,
                    tp,
                    ntp,
                    by_role,
                    id_pembuat,
                    date,
                    id_csc_prod,
                    publish
                    ) 
                    values
                    ('" . $request->subyek . "',
                    '" . $subyek2 . "',
                    '" . $request->valid . "',
                    '" . $request->country . "',
                    '" . $request->city . "',
                    '" . $cat . "',
                    '" . $cat1 . "',
                    '" . $cat2 . "',
                    '" . $request->ship . "',
                    '" . $request->spec . "',
                    '" . $file . "',
                    '" . $request->eo . "',
                    '" . $request->neo . "',
                    '" . $ch2 . "',
                    '" . $request->ntp . "',
                    '4',
                    '" . Auth::user()->id . "',
                    '" . date('Y-m-d H:m:s') . "',
                    '" . $kumpulcat2 . "',
                    '" . (($request->publish == "true") ? 'true' : 'false') . "')
                    RETURNING id");

            $insert_br = DB::table('csc_buying_request_join')->insert([
                'id_br' => $insert[0]->id,
                'id_eks' => $id_eks,
                'status_join' => 0,
                'date' => date('Y-m-d')
            ]);

            // $carimax = DB::select("select max(id) as maxid from csc_buying_request ");
            // foreach ($carimax as $cm) {
            //     $maxid = $cm->maxid;
            // }

            //log
            $insert = DB::select("
                insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
                ('" . Auth::user()->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','4'
                ,'" . Auth::user()->id . "','4','created buying request')");

            //end log
            // masuknya awalnya kesini, tapi karna berubah nampilin data exportir dulu jadinya ini di komen dulu
            // echo "<a href='".url('br_importir_bc/'.$maxid)."' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
            // echo "<a onclick='yz($maxid)' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
            // echo $maxid;
            return redirect('/br_list');
        }
    }

    public function dataBrand($id, Request $request)
    {
        //        dd("masuk gan");

        $param = explode('-', $id);
        $id = $param[0];


        $user = DB::table('itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_product_brand.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->orderby('itdp_eks_product_brand.tahun_merek', 'DESC')
            ->limit(5)
            ->get();

        // dd($user);

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('merek', function ($mjl) {
                return '<div align="left">' . $mjl->merek . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('brand.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('brand.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'merek'])
            ->make(true);
    }

    public function dataBrandModal($id, Request $request)
    {
        //        dd("masuk gan");
        $param = explode('-', $id);
        $id = $param[0];
        $user = DB::table('itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_product_brand.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->orderby('itdp_eks_product_brand.tahun_merek', 'DESC')
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('merek', function ($mjl) {
                return '<div align="left">' . $mjl->merek . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('brand.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('brand.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'merek'])
            ->make(true);
    }

    public function dataCountry($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_country_patents.id_itdp_profil_eks')
            ->where('itdp_company_users.id', '=', $id)
            ->orderby('itdp_eks_country_patents.tahun', 'DESC')
            ->limit(5)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('merek', function ($mjl) {
                return '<div align="left">' . $mjl->merek . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('country_patern_brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('country_patern_brand.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('country_patern_brand.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'merek'])
            ->make(true);
    }
    public function dataCountryModal($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_country_patents.id_itdp_profil_eks')
            ->where('itdp_company_users.id', '=', $id)
            ->orderby('itdp_eks_country_patents.tahun', 'DESC')
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('merek', function ($mjl) {
                return '<div align="left">' . $mjl->merek . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('country_patern_brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('country_patern_brand.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('country_patern_brand.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'merek'])
            ->make(true);
    }
    public function dataProcap($id, Request $request)
    {
        // dd($id);
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_production.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('procap.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('procap.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('procap.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function datacapacity($id)
    {
        //        dd("masuk gan");
        $param = explode('-', $id);
        $id = $param[0];
        $user = DB::table('itdp_production_capacity')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_production_capacity.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('capulti.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('capulti.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('capulti.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataRaw($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_raw_material')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_raw_material.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('rawmaterial.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white" ></i>
                </a>
                <a href="' . route('rawmaterial.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white" ></i>
                </a>
                <a href="' . route('rawmaterial.delete', $mjl->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" title="Delete">
                    <i class="fa fa-trash text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataSales($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        $user = DB::table('itdp_eks_sales')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_sales.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">' . $mjl->tahun . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-success"title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('sales.delete', $mjl->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tahun'])
            ->make(true);
    }
    public function dataLabor($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_labor')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_labor.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">' . $mjl->tahun . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('labor.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('labor.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('labor.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tahun'])
            ->make(true);
    }
    public function dataTax($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_taxes')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_taxes.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">' . $mjl->id . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('taxes.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('taxes.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('taxes.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tahun'])
            ->make(true);
    }
    public function dataDesti($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_destination')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_destination.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exdes.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('exdes.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('exdes.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataPortland($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_port.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('portland.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('portland.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('portland.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataExhib($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        // $user = DB::table('itdp_eks_event_participants')
        //     ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
        //     ->where('itdp_company_users.id', $id)
        //     ->orderby('itdp_eks_event_participants.tahun', 'DESC')
        //     ->limit(5)
        //     ->get();

        $user = DB::table('itdp_eks_event_participants')
            ->select('itdp_eks_event_participants.*', 'event_detail.event_name_en')
            ->join('event_detail', 'event_detail.id', '=', 'itdp_eks_event_participants.id_itdp_eks_event_profil')
            // ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->orderby('itdp_eks_event_participants.tahun', 'DESC')
            ->limit(5)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exhibition.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('exhibition.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('exhibition.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addColumn('status', function ($mjl) {
                if ($mjl->subsidi == 'N') {
                    return "NO";
                } else if ($mjl->subsidi == 'Y') {
                    return "YES";
                } else {
                    return "";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function dataExhibModal($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");

        $user = DB::table('itdp_eks_event_participants')
            ->select('itdp_eks_event_participants.*', 'event_detail.event_name_en')
            ->join('event_detail', 'event_detail.id', '=', 'itdp_eks_event_participants.id_itdp_eks_event_profil')
            // ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->orderby('itdp_eks_event_participants.tahun', 'DESC')

            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exhibition.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('exhibition.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('exhibition.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addColumn('status', function ($mjl) {
                if ($mjl->subsidi == 'N') {
                    return "NO";
                } else if ($mjl->subsidi == 'Y') {
                    return "YES";
                } else {
                    return "";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function dataTraining($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_training')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_training.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('nama_training', function ($mjl) {
                return '<div align="left">' . $mjl->nama_training . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('training.vieweksportir', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('training.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('training.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nama_training'])
            ->make(true);
    }

    public function importPdfEksportir($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        $pageTitle = "";

        $data = DB::table('itdp_company_users')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('eks_business_role', 'eks_business_role.id', '=', 'itdp_profil_eks.id_business_role_id')
            ->select('eks_business_role.nmtype', 'itdp_profil_eks.*', 'itdp_company_users.email', 'itdp_company_users.status as status_company', 'itdp_company_users.type', 'itdp_company_users.id_role', 'itdp_company_users.id as id_user', 'itdp_company_users.foto_profil', 'itdp_company_users.created_at', 'eks_business_entity.nmbadanusaha', 'eks_business_entity.nmbadanusaha')
            ->where('itdp_company_users.id_profil', $id)
            ->first();

        $negara_eks = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.tahun', 'mst_country.country', 'itdp_eks_destination.rasio_persen')
            ->join('mst_country', 'mst_country.id', '=', 'id_mst_country')
            ->where('id_itdp_profil_eks', $data->id)
            ->get();

        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $id)
            ->get();

        $prod = DB::table('csc_product_single')
            ->where('id_itdp_profil_eks', $data->id);

        $catprod = $prod->distinct()->pluck('id_csc_product');

        $categories = DB::table('csc_product')
            ->select('nama_kategori_in', 'nama_kategori_en', 'nama_kategori_chn')
            ->whereIn('id', $catprod)
            ->get();

        $brand = DB::table('itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_product_brand.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $country = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_country_patents.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', '=', $id)
            ->get();

        $procap = DB::table('itdp_eks_production')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_production.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $capacity = DB::table('itdp_production_capacity')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_production_capacity.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $raw = DB::table('itdp_eks_raw_material')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_raw_material.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $sales = DB::table('itdp_eks_sales')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_sales.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $labor = DB::table('itdp_eks_labor')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_labor.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $tax = DB::table('itdp_eks_taxes')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_taxes.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();

        $desti = DB::table('itdp_eks_destination')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_destination.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $portland = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_port.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $exhib = DB::table('itdp_eks_event_participants')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $training = DB::table('itdp_eks_training')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_training.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $pdf = PDF::loadview('frontend.supplier.export_pdf', compact(
            'param',
            'id',
            'pageTitle',
            'data',
            'brand',
            'country',
            'procap',
            'capacity',
            'raw',
            'sales',
            'labor',
            'raw',
            'labor',
            'tax',
            'desti',
            'portland',
            'exhib',
            'training',
            'negara_eks',
            'categories',
            'catprod',
            'prod'
        ));
        return $pdf->download('Detail Eksportir.pdf');
        // die;
        // return view('frontend.supplier.export_pdf', compact('param','id','pageTitle','data','brand','country','procap',
        // 'capacity','raw','sales', 'labor','raw','labor','tax', 'desti','portland','exhib','training','negara_eks','categories','catprod','prod'));
    }

    public function importPdfEksportirFront($id)
    {
        $param = explode('-', $id);
        $id = $param[0];
        $pageTitle = "";
        $nama_perusahaan = $param[0];
        $kategori = isset($param[2]) ? $param[2] : null;

        $data = DB::table('itdp_company_users')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
            ->leftjoin('mst_incoterm', 'mst_incoterm.id', '=', 'itdp_profil_eks.id_incoterm')
            ->leftjoin('mst_payment', 'mst_payment.id', '=', 'itdp_profil_eks.id_payment')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('eks_business_role', 'eks_business_role.id', '=', 'itdp_profil_eks.id_business_role_id')
            ->leftjoin('eks_business_size', 'eks_business_size.id', '=', 'itdp_profil_eks.id_eks_business_size')
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
                'mst_payment.payment'
            )
            ->where('itdp_company_users.id_profil', $id)
            ->first();

        $negara_eks = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.tahun', 'mst_country.country', 'itdp_eks_destination.rasio_persen')
            ->join('mst_country', 'mst_country.id', '=', 'id_mst_country')
            ->where('id_itdp_profil_eks', $data->id)
            ->get();

        $certificate = DB::table('certificate')
            ->where('id_itdp_profil_eks', $data->id)
            ->get();

        $prod = DB::table('csc_product_single')
            ->where('id_itdp_profil_eks', $data->id);

        $catprod = $prod->distinct()->pluck('id_csc_product');

        $categories = DB::table('csc_product')
            ->select('nama_kategori_in', 'nama_kategori_en', 'nama_kategori_chn')
            ->whereIn('id', $catprod)
            ->get();

        $brand = DB::table('itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_product_brand.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $country = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_country_patents.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', '=', $id)
            ->get();

        $procap = DB::table('itdp_eks_production')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_production.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $capacity = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', $data->id)
            ->orderby('itdp_eks_production.tahun', 'desc')
            ->limit(1)
            ->get();

        $raw = DB::table('itdp_eks_raw_material')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_raw_material.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $sales = DB::table('itdp_eks_sales')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_sales.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $labor = DB::table('itdp_eks_labor')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_labor.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $tax = DB::table('itdp_eks_taxes')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_taxes.id_itdp_profil_eks')
            ->where('itdp_company_users.id', $id)
            ->get();

        $desti = DB::table('itdp_eks_destination')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_destination.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $portland = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_port.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $exhib = DB::table('itdp_eks_event_participants')
            ->select('itdp_eks_event_participants.*', 'event_detail.event_name_en')
            ->join('event_detail', 'event_detail.id', '=', 'itdp_eks_event_participants.id_itdp_eks_event_profil')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->orderby('itdp_eks_event_participants.tahun', 'DESC')
            ->limit(1)
            ->get();

        $training = DB::table('itdp_eks_training')
            ->join('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_eks_training.id_itdp_profil_eks')
            ->where('itdp_company_users.id_profil', $id)
            ->get();

        $market = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_destination.tahun', 'desc')
            ->limit(1)
            ->get();

        $annual = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_sales.tahun', 'desc')
            ->limit(1)
            ->get();

        $annuals = DB::select("select sum(nilai_ekspor) as suma from itdp_eks_sales where id_itdp_profil_eks='" . $data->id . "'");

        $port = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'itdp_eks_port.tahun', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $data->id)
            ->orderby('itdp_eks_port.tahun', 'desc')
            ->limit(1)
            ->get();

        $pdf = PDF::loadview('frontend.supplier.export_pdf_new', compact(
            'kategori',
            'market',
            'port',
            'annual',
            'annuals',
            'param',
            'id',
            'pageTitle',
            'data',
            'brand',
            'country',
            'procap',
            'capacity',
            'raw',
            'sales',
            'labor',
            'raw',
            'labor',
            'tax',
            'desti',
            'portland',
            'exhib',
            'training',
            'negara_eks',
            'categories',
            'catprod',
            'prod',
            'certificate'
        ));
        return $pdf->download('Detail Eksportir.pdf');
        // die;
        // return view('frontend.supplier.export_pdf', compact('param','id','pageTitle','data','brand','country','procap',
        // 'capacity','raw','sales', 'labor','raw','labor','tax', 'desti','portland','exhib','training','negara_eks','categories','catprod','prod'));
    }

    public function change_lg($id)
    {
        Session::put('gl', $id);
    }
}
