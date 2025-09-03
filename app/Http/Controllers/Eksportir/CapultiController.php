<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CapultiController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Utilisasi Kapasiti";

        return view('eksportir.capacity_utilization.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        //        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        //        dd($years);
        $url = '/eksportir/capulti_save';
        $pageTitle = 'Form Tambah Utilisasi Kapasiti';
        return view('eksportir.capacity_utilization.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_production_capacity')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'kapasitas_terpakai_persen' => str_replace(",", ".", $request->used_capacity)
        ]);
        return redirect('eksportir/capulti')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_production_capacity')
            ->select('itdp_production_capacity.id', 'itdp_production_capacity.tahun', 'itdp_production_capacity.kapasitas_terpakai_persen')
            ->where('itdp_production_capacity.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
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

    public function edit($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Edit Utilisasi Kapasiti';
        $url = '/eksportir/capulti_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_production_capacity')
            ->where('id', '=', $id)
            ->get();
        //        dd($data);
        return view('eksportir.capacity_utilization.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Detail Utilisasi Kapasiti';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_production_capacity')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.capacity_utilization.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_production_capacity')->where('id', $id)
            ->delete();
        return redirect('eksportir/capulti')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_production_capacity')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'kapasitas_terpakai_persen' => str_replace(",", ".", $request->used_capacity),
            ]);
        return redirect('eksportir/capulti')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Utilisasi Kapasiti";
        return view('eksportir.capacity_utilization.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        $user = DB::table('itdp_production_capacity')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('capulti.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
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
