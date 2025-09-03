<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CountryPaternBrandController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Negara Paten Merek";

        return view('eksportir.country_patern_brand.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $brand = DB::table('itdp_eks_product_brand')
            ->where('itdp_eks_product_brand.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        $country = DB::table('mst_country')->orderby('country', 'asc')->get();
        $url = '/eksportir/country_patern_brand_save';
        $pageTitle = 'Tambah Negara Paten Merek';
        return view('eksportir.country_patern_brand.tambah', compact('country', 'pageTitle', 'url', 'brand','years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_country_patents')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_itdp_eks_product_brand' => $request->brand,
            'id_mst_country' => $request->country,
            'bulan' => $request->bulan,
            'tahun' => $request->year,
        ]);
        return redirect('eksportir/country_patern_brand')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->where('itdp_eks_country_patents.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
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

    public function edit($id)
    {
        $pageTitle = 'Edit Negara Paten Merek';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/country_patern_brand_update';
        $brand = DB::table('itdp_eks_product_brand')->orderby('merek', 'asc')->get();
        $country = DB::table('mst_country')->orderby('country', 'asc')->get();
        $data = DB::table('itdp_eks_country_patents')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.country_patern_brand.edit', compact('pageTitle', 'data', 'url', 'brand', 'country','years'));
    }

    public function view($id)
    {
        //        dd($id);
        $pageTitle = 'Detail Negara Paten Merek';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_country_patents')
            ->where('id', '=', $id)
            ->get();
        $brand = DB::table('itdp_eks_product_brand')->orderby('merek', 'asc')->get();
        $country = DB::table('mst_country')->orderby('country', 'asc')->get();
//        dd($data);
        return view('eksportir.country_patern_brand.view', compact('pageTitle', 'data', 'brand', 'country','years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_country_patents')->where('id', $id)
            ->delete();
        return redirect('eksportir/country_patern_brand')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        DB::table('itdp_eks_country_patents')->where('id', $request->id_sales)
            ->update([
                'id_itdp_eks_product_brand' => $request->brand,
                'id_mst_country' => $request->country,
                'bulan' => $request->bulan,
                'tahun' => $request->year,
            ]);
        return redirect('eksportir/country_patern_brand')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Country Patern Brand";
        return view('eksportir.country_patern_brand.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        $user = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->where('itdp_eks_country_patents.id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('country_patern_brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
               
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
