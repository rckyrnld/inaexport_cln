<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaxesController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Pajak";

        return view('eksportir.taxes.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        //        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        //        dd($years);
        $url = '/eksportir/taxes_save';
        $pageTitle = 'Tambah Pajak';
        return view('eksportir.taxes.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        // dd($request->laporan_pph);
        if ($request->laporan_pph == "1") {
            $pph =  "Sudah";
        } else if ($request->laporan_pph == "2") {
            $pph = "Belum";
        }

        if ($request->laporan_ppn == "1") {
            $ppn =  "Sudah";
        } else if ($request->laporan_ppn == "2") {
            $ppn = "Belum";
        }

        if ($request->laporan_pasal_21 == "1") {
            $pasal_21 =  "Sudah";
        } else if ($request->laporan_pasal_21 == "2") {
            $pasal_21 = "Belum";
        }

        DB::table('itdp_eks_taxes')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'laporan_pph' => $pph,
            'laporan_ppn' => $ppn,
            'laporan_psl21' => $pasal_21,
            'setor_pph' => $request->total_pph,
            'setor_ppn' => $request->total_ppn,
            'setor_psl21' => $request->total_pasal_21,
            'tunggakan_pph' => $request->tunggakan_pph,
            'tunggakan_ppn' => $request->tunggakan_ppn,
            'tunggakan_psl21' => $request->tunggakan_pasal_21,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/taxes')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_taxes')
            ->where('itdp_eks_taxes.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">' . $mjl->tahun . '</div>';
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

    public function edit($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Edit Pajak';
        $url = '/eksportir/taxes_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_taxes')
            ->where('id', '=', $id)
            ->get();
        //        dd($data);
        return view('eksportir.taxes.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Detail Pajak';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_taxes')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.taxes.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_taxes')->where('id', $id)
            ->delete();
        return redirect('eksportir/taxes')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_taxes')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'laporan_pph' => $request->laporan_pph,
                'laporan_ppn' => $request->laporan_ppn,
                'laporan_psl21' => $request->laporan_pasal_21,
                'setor_pph' => $request->total_pph,
                'setor_ppn' => $request->total_ppn,
                'setor_psl21' => $request->total_pasal_21,
                'tunggakan_pph' => $request->tunggakan_pph,
                'tunggakan_ppn' => $request->tunggakan_ppn,
                'tunggakan_psl21' => $request->tunggakan_pasal_21,
                'idcompanytahun' => $id_user . $request->year,
            ]);
        return redirect('eksportir/taxes')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Taxes";

        return view('eksportir.taxes.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_taxes')
            ->where('itdp_eks_taxes.id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('taxes.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
