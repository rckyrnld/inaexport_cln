<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PortlandController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Pelabuhan Ekspor";

        return view('eksportir.port_landing.index', compact('pageTitle'));
    }

    public function tambah()
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $port = DB::table('mst_port')->orderBy('name_port')->get();
        $url = '/eksportir/portland_save';
        $pageTitle = 'Tambah Pelabuhan Ekspor';
        return view('eksportir.port_landing.tambah', compact('port', 'pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);

        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_port')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_mst_port' => $request->port,
            'tahun' => $request->year,
            'pelcompany' => $id_user . $request->tahun . $request->port,
        ]);
        return redirect('eksportir/portland')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'itdp_eks_port.tahun', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return $mjl->tahun;
            })
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

    public function edit($id)
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Edit Pelabuhan Ekspor';
        $url = '/eksportir/portland_update';
        $port = DB::table('mst_port')->orderBy('name_port')->get();
        $data = DB::table('itdp_eks_port')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.port_landing.edit', compact('pageTitle', 'data', 'url', 'port', 'years'));
    }

    public function view($id)
    {
        //        dd($id);
        $pageTitle = 'Detail Pelabuhan Ekspor';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_port')
            ->where('id', '=', $id)
            ->get();
        //        $brand = DB::table('itdp_eks_product_brand')->get();
        $port = DB::table('mst_port')->orderBy('name_port')->get();
        //        dd($data);
        return view('eksportir.port_landing.view', compact('pageTitle', 'data', 'port', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_port')->where('id', $id)
            ->delete();
        return redirect('eksportir/portland')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_port')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'id_mst_port' => $request->port,
                'pelcompany' => $id_user . $request->year . $request->port,
                'tahun' => $request->year
            ]);
        return redirect('eksportir/portland')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Pelabuhan Ekspor";

        return view('eksportir.port_landing.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->leftjoin('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('name_port', function ($mjl) {
                return '<div align="left">' . $mjl->name_port . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('portland.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'name_port'])
            ->make(true);
    }
}
