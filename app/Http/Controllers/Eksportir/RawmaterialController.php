<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RawmaterialController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Bahan Baku";

        return view('eksportir.raw_material.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        //        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        //        dd($years);
        $url = '/eksportir/rawmaterial_save';
        $pageTitle = 'Tambah Bahan Baku';
        return view('eksportir.raw_material.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_raw_material')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'lokal_persen' => str_replace(",", ".", $request->domestic),
            'impor_persen' => str_replace(",", ".", $request->overseas),
            'nilai_impor' =>  str_replace(",", ".", $request->valuefromdomestic),
        ]);
        return redirect('eksportir/rawmaterial')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
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

    public function edit($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Edit Bahan Baku';
        $url = '/eksportir/rawmaterial_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_raw_material')
            ->where('id', '=', $id)
            ->get();
        //        dd($data);
        return view('eksportir.raw_material.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {

        $pageTitle = 'Detail Bahan Baku';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_raw_material')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.raw_material.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_raw_material')->where('id', $id)
            ->delete();
        return redirect('eksportir/rawmaterial')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        // dd($request->all());
        DB::table('itdp_eks_raw_material')
            ->where('id', $request->id_bahan)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'lokal_persen' => str_replace(",", ".", $request->domestic),
                'impor_persen' => str_replace(",", ".", $request->overseas),
                'nilai_impor' => str_replace(".", ".", $request->valuefromdomestic),
            ]);
        return redirect('eksportir/rawmaterial')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Bahan Baku";

        return view('eksportir.raw_material.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('rawmaterial.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getscoope(Request $request)
    {
        $overseas = DB::table('itdp_eks_raw_material')->where('id', $request->id)->select('impor_persen')->first();

        echo json_encode($overseas);
    }
}
