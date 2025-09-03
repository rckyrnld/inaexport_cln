<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Merek";

        return view('eksportir.brand.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/brand_save';
        $pageTitle = 'Tambah Merek';
        return view('eksportir.brand.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_product_brand')->insert([
            'id_itdp_profil_eks' => $id_user,
            'merek' => $request->brand,
            'arti_merek' => $request->arti_brand,
            'bulan_merek' => $request->bulan,
            'tahun_merek' => $request->year,
            'paten_merek' => $request->copyright_number,
        ]);
        return redirect('eksportir/brand')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_product_brand')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
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

    public function edit($id)
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Edit Merek';
        $url = '/eksportir/brand_update';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.brand.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Merek';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.brand.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_product_brand')->where('id', $id)
            ->delete();
        return redirect('eksportir/brand')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        DB::table('itdp_eks_product_brand')->where('id', $request->id_sales)
            ->update([
                'merek' => $request->brand,
                'arti_merek' => $request->arti_brand,
                'bulan_merek' => $request->bulan,
                'tahun_merek' => $request->year,
                'paten_merek' => $request->copyright_number,
            ]);
        return redirect('eksportir/brand')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Brand";
        return view('eksportir.brand.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        $user = DB::table('itdp_eks_product_brand')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('merek', function ($mjl) {
                return '<div align="left">' . $mjl->merek . '</div>';
            })
            ->addColumn('arti_merek', function ($mjl) {
                return '<div align="left">' . $mjl->arti_merek . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('brand.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
               
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'merek', 'arti_merek'])
            ->make(true);
    }
}
