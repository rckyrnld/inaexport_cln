<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProcapController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Kapasitas Produksi";

        return view('eksportir.procap.index', compact('pageTitle'));
    }

    public function tambah()
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/procap_save';
        $pageTitle = 'Tambah Kapasitas Produksi';
        return view('eksportir.procap.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_production')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'sendiri_persen' => str_replace(',', '.', $request->persen_sendiri),
            'outsourcing_persen' => str_replace(',', '.', $request->out_persen),
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/product_capacity')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('sendiri_persen', function ($mjl) {
                return str_replace('.', ',', $mjl->sendiri_persen);
            })
            ->addColumn('outsourcing_persen', function ($mjl) {
                return str_replace('.', ',', $mjl->outsourcing_persen);
            })
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

    public function edit($id)
    {
        $pageTitle = 'Edit Kapasitas Produk';
        $url = '/eksportir/procap_update';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;

        $data = DB::table('itdp_eks_production')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.procap.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        //        dd($id);
        $pageTitle = 'Detail Kapasitas Produk';
        $data = DB::table('itdp_eks_production')
            ->where('id', '=', $id)
            ->get();
        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
        //        dd($data);
        return view('eksportir.procap.view', compact('pageTitle', 'data', 'brand', 'country'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_production')->where('id', $id)
            ->delete();
        return redirect('eksportir/product_capacity')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        DB::table('itdp_eks_production')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->tahun,
                'sendiri_persen' => str_replace(',', '.', $request->persen_sendiri),
                'outsourcing_persen' => str_replace(',', '.', $request->out_persen),
            ]);
        return redirect('eksportir/product_capacity')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Production Capacity";

        return view('eksportir.procap.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('procap.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
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
