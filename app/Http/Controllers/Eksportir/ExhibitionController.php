<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExhibitionController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Aktivitas Pameran";

        return view('eksportir.exhibition.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $exhibition = DB::table('event_detail')->orderBy('event_name_en')->get();
        $url = '/eksportir/exhibition_save';
        $pageTitle = 'Tambah Aktivitas Pameran';
        return view('eksportir.exhibition.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        //    dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_event_participants')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'id_itdp_eks_event_profil' => $request->exhibition,
            'luas_boot' => $request->booth_area,
            'nilai_kontrak' => $request->value_contract,
            'subsidi' => $request->subsidi_djpen
        ]);
        return redirect('eksportir/exhibition')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_event_participants')
            ->select('itdp_eks_event_participants.*','event_detail.event_name_en')
            ->join('event_detail', 'event_detail.id', '=', 'itdp_eks_event_participants.id_itdp_eks_event_profil')
            ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_eks_event_participants.id_itdp_profil_eks')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('status', function ($mjl) {
                $subsidi = $mjl->subsidi;
                if($subsidi == "N") {
                    return "NO";
                }else if ($subsidi == "Y") {
                    return "YES";
                }else{
                    return "";
                }
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exhibition.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('exhibition.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('exhibition.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
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
        $pageTitle = 'Edit Aktivitas Pameran';
        $url = '/eksportir/exhibition_update';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_event_participants')
            ->where('id', '=', $id)
            ->get();
        $exbition = DB::table('event_detail')->select('id', 'event_name_en')->orderBy('event_name_en')->limit(5)->get();
        return view('eksportir.exhibition.edit', compact('pageTitle', 'data', 'url', 'years','exbition'));
    }

    public function view($id)
    {
        //        dd($id);
        $pageTitle = 'Detail Aktivitas Pameran';
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_event_participants')

            ->where('id', '=', $id)
            ->get();
            
        $exbition = DB::table('event_detail')->select('id', 'event_name_en')->orderBy('event_name_en')->limit(5)->get();
        //        $brand = DB::table('itdp_eks_product_brand')->get();
        //        $country = DB::table('mst_country')->get();
        //        dd($data);
        return view('eksportir.exhibition.view', compact('data', 'pageTitle', 'years','exbition'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_event_participants')->where('id', $id)
            ->delete();
        return redirect('eksportir/exhibition')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_event_participants')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'id_itdp_eks_event_profil' => $request->exhibition,
                'luas_boot' => $request->booth_area,
                'nilai_kontrak' => $request->value_contract,
                'subsidi' => $request->subsidi_djpen
            ]);
        return redirect('eksportir/exhibition')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd($id);
        $pageTitle = "Exhibition";
        return view('eksportir.exhibition.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        $user = DB::table('itdp_production_capacity')
        //            ->where('id_itdp_profil_eks', '=', $id)
        //            ->get();
        $user = DB::table('itdp_eks_event_participants')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            //            ->addColumn('id_itdp_eks_event_profil', function ($mjl) {
            //                return '<div align="left">' . $mjl->id_itdp_eks_event_profil . '</div>';
            //            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exhibition.view', $mjl->id) . '" title="View" class="btn btn-sm btn-info">
                    <i class="fa fa-eye text-white"></i>
                </a>
                </center>
                ';
            })
            ->addColumn('status', function ($mjl) {
                if ($mjl->subsidi == 'N') {
                    return "NO";
                } else if ($mjl->subsidi == 'Y') {
                    return "YES";
                } else {
                    return "";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function loadP(Request $request)
    {
        //        dd("hahaha");
        if ($request->has('q')) {
            $cari = $request->q;
            //            dd($cari);
            $data = DB::table('event_detail')->select('id', 'event_name_en')->where('event_name_en', 'LIKE', '%' . $cari . '%')->orderBy('event_name_en')->get();
            //            dd($data);
        } else {
            $data = DB::table('event_detail')->select('id', 'event_name_en')->orderBy('event_name_en')->limit(5)->get();
        }
        return response()->json($data);
    }
}
