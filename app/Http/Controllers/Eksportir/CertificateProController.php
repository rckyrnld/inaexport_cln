<?php

namespace App\Http\Controllers\Eksportir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class CertificateProController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $pageTitle = "Sertifikat Produk";

        return view('eksportir.certificatepro.index', compact('pageTitle'));
    }

    public function getData()
    {
        $certificate = DB::table('certificate_pro')
            ->select(
                'certificate_pro.id',
                'certificate_pro.nama',
                'certificate_pro.file',
                'certificate_pro.no_ref',
                'certificate_pro.kategori',
                'certificate_pro.id_itdp_profil_eks',
                'certificate_pro.id_produk',
                'csc_product_single.prodname_en'
            )
            ->leftjoin('csc_product_single', 'csc_product_single.id', '=', 'certificate_pro.id_produk')
            ->where('certificate_pro.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        return \Yajra\DataTables\DataTables::of($certificate)
            ->addIndexColumn()

            ->addColumn('produk', function ($data) {
                return $data->prodname_en;
            })

            ->addColumn('nama', function ($data) {
                return $data->nama;
            })

            ->addColumn('file', function ($data) {
                $file = '';
                $file .= '<img src="' . asset('/uploads/CertificatePro/' . $data->id_itdp_profil_eks . '/' . $data->file) . '" alt="Lights" style="width:100%">';
                return $file;
            })

            ->addColumn('no_ref', function ($data) {
                return $data->no_ref;
            })

            ->addColumn('kategori', function ($data) {
                return $data->kategori;
            })

            ->addColumn('action', function ($data) {
                $p = '<center><div class="btn-group">';
                $p .= '
                <a href="' . route('certificatepro.view', $data->id) . '" class="btn btn-sm btn-info" title="View">
                <i class="fa fa-eye text-white"></i>
                </a>&nbsp;
                <a href="' . route('certificatepro.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit">
                <i class="fa fa-edit text-white"></i>
                </a>&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('certificatepro.destroy', $data->id) . '" class="btn btn-sm btn-danger" title="Delete">
                <i class="fa fa-trash text-white"></i>
                </a>';
                return $p . '</div></center>';
            })
            ->rawColumns(['produk', 'nama', 'file', 'no_ref', 'kategori', 'action'])
            ->make(true);
    }

    public function store(Request $req, $param)
    {

        $id_user = Auth::guard('eksmp')->user()->id_profil;
        $destination =   'uploads\CertificatePro\\' . $id_user;

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $nama_file = time() . '_' . date('Y_m_d') . '_' . $req->file('file')->getClientOriginalName();

            Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
        } else {
            $nama_file = $req->lastest_file;
        }

        if ($param == 'Create') {
            $data = $id =  DB::table('certificate_pro')->insertGetId([
                'id_itdp_profil_eks' => $id_user,
                'id_produk' => $req->prodname_en,
                'file' => $nama_file,
                'nama' => $req->nama,
                'no_ref' => $req->no_ref,
                'kategori' => $req->kategori

            ]);
        } else {
            $pecah = explode('|', $param);
            $param = $pecah[0];
            $id = $pecah[1];

            $id_user = Auth::guard('eksmp')->user()->id_profil;
            $data =  DB::table('certificate_pro')->where('id', $id)->update([
                'id_itdp_profil_eks' => $id_user,
                'id_produk' => $req->prodname_en,
                'file' => $nama_file,
                'nama' => $req->nama,
                'no_ref' => $req->no_ref,
                'kategori' => $req->kategori
            ]);
        }

        if ($data) {
            Session::flash('success', 'Success ' . $param . 'd Data');
            return redirect('eksportir/certificatepro')->with('success', 'Success ' . $param . 'd Data!');
        } else {
            Session::flash('failed', 'Failed ' . $param . 'd Data');
            return redirect('eksportir/certificatepro')->with('error', 'Failed ' . $param . 'd Data!');
        }
    }

    public function view($id)
    {
        $pageTitle = "Detail Sertifikat Produk";
        $page = "view";
        $data =  DB::table('certificate_pro')->where('id', $id)->first();
        $produk = DB::table('csc_product_single')
            ->where('csc_product_single.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        return view('eksportir.certificatepro.create', compact('produk', 'page', 'data', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Tambah Sertifikat Produk';
        $page = 'create';
        $url = "/eksportir/certificatepro_store/Create";
        $produk = DB::table('csc_product_single')
            ->where('csc_product_single.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        return view('eksportir.certificatepro.create', compact('produk', 'url', 'pageTitle', 'page'));
    }

    public function edit($id)
    {
        $page = "edit";
        $pageTitle = "Edit Sertifikat Produk";
        $url = "/eksportir/certificatepro_store/Update|" . $id;
        $data =  DB::table('certificate_pro')->where('id', $id)->first();
        $produk = DB::table('csc_product_single')
            ->where('csc_product_single.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
        return view('eksportir.certificatepro.create', compact('produk', 'url', 'data', 'pageTitle', 'page'));
    }

    public function destroy($id)
    {
        $data =  DB::table('certificate_pro')->where('id', $id)->delete();
        if ($data) {
            Session::flash('error', 'Success Deleted Data');
            return redirect('eksportir/certificatepro')->with('error', 'Success Deleted Data');
        } else {
            Session::flash('error', 'Failed Deleted Data');
            return redirect('eksportir/certificatepro')->with('error', 'Failed Deleted Data');
        }
    }
}
