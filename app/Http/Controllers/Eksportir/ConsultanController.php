<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsultanController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Consultant";

        return view('eksportir.consultan.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        //        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        //        dd($years);
        $url = '/eksportir/consultan_save';
        $pageTitle = 'Add Consultan';
        return view('eksportir.consultan.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $datenow = date('Y-m-d');
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_consultation')->insert([
            'id_profil_eks' => $id_user,
            'nama_pegawai' => $request->name,
            'jabatan' => $request->posotion,
            'telepon' => $request->phone,
            'masalah' => $request->problem,
            'solusi' => $request->solution,
            'pejabat' => $request->pejabat,
            'created_at' => $datenow
        ]);
        return redirect('eksportir/consultan')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_consultation')
            ->where('itdp_eks_consultation.id_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('nama_pegawai', function ($mjl) {
                return $mjl->nama_pegawai;
            })
            ->addColumn('masalah', function ($mjl) {
                return strip_tags($mjl->masalah);
            })
            ->addColumn('solusi', function ($mjl) {
                return strip_tags($mjl->solusi);
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('consultan.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('consultan.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('consultan.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
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
        $pageTitle = 'Detail Consulting';
        $url = '/eksportir/consultan_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_consultation')
            ->where('id', '=', $id)
            ->get();
        //        dd($data);
        return view('eksportir.consultan.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'View Detail Consultan';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_consultation')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.consultan.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_consultation')->where('id', $id)
            ->delete();
        return redirect('eksportir/consultan')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $datenow = date('Y-m-d');
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_consultation')->where('id', $request->id_sales)
            ->update([
                'id_profil_eks' => $id_user,
                'nama_pegawai' => $request->name,
                'jabatan' => $request->posotion,
                'telepon' => $request->phone,
                'masalah' => $request->problem,
                'solusi' => $request->solution,
                'pejabat' => $request->pejabat,
                'modified' => $datenow
            ]);
        return redirect('eksportir/consultan')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Consultant";
        return view('eksportir.consultan.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        $user = DB::table('itdp_eks_consultation')
            ->where('id_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('nama_pegawai', function ($mjl) {
                return '<div align="left">' . $mjl->nama_pegawai . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('consultan.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
               
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nama_pegawai'])
            ->make(true);
    }
}
