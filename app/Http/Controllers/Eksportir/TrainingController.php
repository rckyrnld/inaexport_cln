<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrainingController extends Controller
{
    public function index()
    {
        //        dd("mantap");die();
        $pageTitle = "Aktivitas Pelatihan";

        return view('eksportir.training.index', compact('pageTitle'));
    }

    public function tambah()
    {
        //        dd($id_user);
        $ldate = date('Y');
        //        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $country = DB::table('mst_country')->orderBy('country')->get();
        $city = DB::table('mst_city')->orderBy('city')->get();
        $url = '/eksportir/training_save';
        $pageTitle = 'Tambah Aktivitas Pelatihan';
        return view('eksportir.training.tambah', compact('pageTitle', 'url', 'years', 'country', 'city'));
    }

    public function store(Request $request)
    {
        //        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_training')->insert([
            'id_itdp_profil_eks' => $id_user,
            'nama_training' => $request->training,
            'penyelenggara' => $request->organizer,
            'tanggal_mulai' => $request->start_date,
            'tanggal_selesai' => $request->due_date,
            'dalam_luar' => $request->inside_outside,
            'tempat_pelatihan' => $request->place_of_training,
            'id_mst_country' => $request->country,
            'id_mst_city' => $request->city,
            'lisensi_nafed' => $request->lisenced_dgned,
        ]);
        return redirect('eksportir/training')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_training')
            ->where('itdp_eks_training.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('nama_training', function ($mjl) {
                return '<div align="left">' . $mjl->nama_training . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('training.vieweksportir', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('training.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('training.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nama_training'])
            ->make(true);
    }

    public function edit($id)
    {
        $ldate = date('Y');
        $pageTitle = 'Edit Aktivitas Pelatihan';
        $url = '/eksportir/training_update';
        $country = DB::table('mst_country')->get();
        $city = DB::table('mst_city')->get();
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_training')
            ->where('id', '=', $id)
            ->get();
        //        dd($data);
        return view('eksportir.training.edit', compact('pageTitle', 'data', 'url', 'years', 'country', 'city'));
    }

    public function view($id)
    {
        //        dd($id);
        $ldate = date('Y');
        $pageTitle = 'Detail Aktivitas Pelatihan';
        $country = DB::table('mst_country')->get();
        $city = DB::table('mst_city')->get();
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_training')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.training.view', compact('pageTitle', 'data', 'years', 'country', 'city'));
    }

    public function delete($id)
    {
        //        dd($id);
        DB::table('itdp_eks_training')->where('id', $id)
            ->delete();
        return redirect('eksportir/training')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_training')->where('id', $request->id_training)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'nama_training' => $request->training,
                'penyelenggara' => $request->organizer,
                'tanggal_mulai' => $request->start_date,
                'tanggal_selesai' => $request->due_date,
                'dalam_luar' => $request->inside_outside,
                'tempat_pelatihan' => $request->place_of_training,
                'id_mst_country' => $request->country,
                'id_mst_city' => $request->city,
                'lisensi_nafed' => $request->lisenced_dgned,
            ]);
        return redirect('eksportir/training')->with('success', 'Success Update Data');
    }

    public function indexadmin($id)
    {
        //        dd("mantap");die();
        $pageTitle = "Training";

        return view('eksportir.training.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        //        dd("masuk gan");
        $user = DB::table('itdp_eks_training')
            ->where('itdp_eks_training.id_itdp_profil_eks', '=', $id)
            ->get();
        //        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('nama_training', function ($mjl) {
                return '<div align="left">' . $mjl->nama_training . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('training.vieweksportir', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>               
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nama_training'])
            ->make(true);
    }
}
