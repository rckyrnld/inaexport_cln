<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LaborController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Tenaga Kerja";

        return view('eksportir.labor.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
//        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
//        dd($years);
        $url = '/eksportir/labor_save';
        $pageTitle = 'Tambah Tenaga Kerja';
        return view('eksportir.labor.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_labor')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'lokal_orang' => $request->local_employee,
            'asing_orang' => $request->foreign_worker,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/labor')->with('success','Success Add Data');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_labor')
            ->where('itdp_eks_labor.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">'. $mjl->tahun . '</div>';
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
            ->rawColumns(['action','tahun'])
            ->make(true);
    }

    public function edit($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Edit Tenaga Kerja';
        $url = '/eksportir/labor_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_labor')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.labor.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Detail Tenaga Kerja';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_labor')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.labor.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_labor')->where('id', $id)
            ->delete();
        return redirect('eksportir/labor')->with('error','Success Delete Data');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_labor')->where('id', $request->id_labor)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'lokal_orang' => $request->local_employee,
                'asing_orang' => $request->foreign_worker,
                'idcompanytahun' => $id_user . $request->year,
            ]);
        return redirect('eksportir/labor')->with('success','Success Update Data');
    }

    public function indexadmin($id)
    {
//        dd($id);
        $pageTitle = "Labor";

        return view('eksportir.labor.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_labor')
            ->where('itdp_eks_labor.id_itdp_profil_eks', '=', $id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('labor.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
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
