<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExsdesController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Tujuan Ekspor";

        return view('eksportir.export_destination.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        //        $brand = DB::table('itdp_eks_product_brand')->get();
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $country = DB::table('mst_country')->orderBy('country')->get();
        $url = '/eksportir/exdes_save';
        $pageTitle = 'Tambah Tujuan Ekspor';
        return view('eksportir.export_destination.tambah', compact('country', 'pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_destination')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_mst_country' => $request->country,
            'rasio_persen' => str_replace(",", ".", $request->ratio_export),
            'tahun' => $request->year,
            'comtahuncountry' => $id_user . $request->tahun . $request->country,
        ]);
        return redirect('eksportir/export_destination')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
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

    public function edit($id)
    {
        $pageTitle = 'Edit Tujuan Ekspor';
        $url = '/eksportir/exdes_update';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $country = DB::table('mst_country')->orderBy('country')->get();
        $data = DB::table('itdp_eks_destination')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.export_destination.edit', compact('pageTitle', 'data', 'url', 'country', 'years'));
    }

    public function view($id)
    {
        //        dd($id);
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Detail Tujuan Ekspor';
        $data = DB::table('itdp_eks_destination')
            ->where('id', '=', $id)
            ->get();
        //        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
        //        dd($data);
        return view('eksportir.export_destination.view', compact('pageTitle', 'data', 'country', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_destination')->where('id', $id)
            ->delete();
        return redirect('eksportir/export_destination')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_destination')->where('id', $request->id_sales)
            ->update([
                'id_mst_country' => $request->country,
                'rasio_persen' => str_replace(",", ".", $request->ratio_export),
                'tahun' => $request->year,
                'comtahuncountry' => $id_user . $request->tahun . $request->country,
            ]);
        return redirect('eksportir/export_destination')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Tujuan Ekspor";

        return view('eksportir.export_destination.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exdes.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addColumn('country', function ($mjl) {
                return '<div align="left">' . $mjl->country . '</div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'country'])
            ->make(true);
    }
}
