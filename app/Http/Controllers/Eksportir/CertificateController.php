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

class CertificateController extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {
    $pageTitle = "Sertifikat";

    return view('eksportir.certificate.index', compact('pageTitle'));
  }

  public function getData()
  {
    $certificate = DB::table('certificate')
      ->where('certificate.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
      ->get();

    return \Yajra\DataTables\DataTables::of($certificate)
      ->addIndexColumn()

      ->addColumn('name', function ($data) {
        return $data->name;
      })

      ->addColumn('image', function ($data) {
        $image = '';
        $image .= '<img src="' . asset('/uploads/Certificate/' . $data->id_itdp_profil_eks . '/' . $data->image) . '" alt="Lights" style="width:100%">';
        return $image;
      })

      ->addColumn('no_ref', function ($data) {
        return $data->no_ref;
      })

      ->addColumn('category', function ($data) {
        return $data->category;
      })

      ->addColumn('type', function ($data) {
        return $data->type;
      })

      ->addColumn('action', function ($data) {
        $p = '<center><div class="btn-group">';
        $p .= '
            <a href="' . route('certificate.view', $data->id) . '" class="btn btn-sm btn-info" title="View">
              <i class="fa fa-eye text-white"></i>
            </a>&nbsp;
            <a href="' . route('certificate.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit">
              <i class="fa fa-edit text-white"></i>
            </a>&nbsp;
            <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('certificate.destroy', $data->id) . '" class="btn btn-sm btn-danger" title="Delete">
              <i class="fa fa-trash text-white"></i>
            </a>';
        return $p . '</div></center>';
      })
      ->rawColumns(['name', 'image', 'no_ref', 'category', 'type', 'action'])
      ->make(true);
  }

  public function store(Request $req, $param)
  {
    $this->validate(
      $req,
      [
        'file' => 'mimes:jpg,jpeg,png,pdf',
      ],
      [
        'file.mimes' => 'The Upload Gambar\'s type allowed only JPG, JPEG, PNG or PDF',
      ]
    );

    $id_user = Auth::guard('eksmp')->user()->id_profil;
    $destination =   'uploads\Certificate\\' . $id_user;

    if ($req->hasFile('file')) {
      $file = $req->file('file');
      $nama_file = time() . '_' . date('Y_m_d') . '_' . $req->file('file')->getClientOriginalName();

      Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
    } else {
      $nama_file = $req->lastest_file;
    }


    if ($param == 'Create') {
      $data = $id =  DB::table('certificate')->insertGetId([
        'id_itdp_profil_eks' => $id_user,
        'image' => $nama_file,
        'name' => $req->name,
        'no_ref' => $req->no_ref,
        'category' => $req->category,
        'type' => $req->type,
        'start_date' => $req->start_date,
        'end_date' => $req->end_date

      ]);
    } else {
      $pecah = explode('|', $param);
      $param = $pecah[0];
      $id = $pecah[1];

      $id_user = Auth::guard('eksmp')->user()->id_profil;
      $data =  DB::table('certificate')->where('id', $id)->update([
        'id_itdp_profil_eks' => $id_user,
        'image' => $nama_file,
        'name' => $req->name,
        'no_ref' => $req->no_ref,
        'category' => $req->category,
        'type' => $req->type,
        'start_date' => $req->start_date,
        'end_date' => $req->end_date
      ]);
    }

    if ($data) {
      Session::flash('success', 'Success ' . $param . 'd Data');
      return redirect('eksportir/certificate')->with('success', 'Success ' . $param . 'd Data!');
    } else {
      Session::flash('failed', 'Failed ' . $param . 'd Data');
      return redirect('eksportir/certificate')->with('error', 'Failed ' . $param . 'd Data!');
    }
  }

  public function view($id)
  {
    $pageTitle = "Detail Sertifikat";
    $page = "view";
    $data =  DB::table('certificate')->where('id', $id)->first();

    return view('eksportir.certificate.create', compact('page', 'data', 'pageTitle'));
  }

  public function create()
  {
    $pageTitle = 'Form Tambah Sertifikat';
    $page = 'create';
    $url = "/eksportir/certificate_store/Create";

    return view('eksportir.certificate.create', compact('url', 'pageTitle', 'page'));
  }

  public function edit($id)
  {
    $page = "edit";
    $pageTitle = "Edit Sertifikat";
    $url = "/eksportir/certificate_store/Update|" . $id;
    $data =  DB::table('certificate')->where('id', $id)->first();
    return view('eksportir.certificate.create', compact('url', 'data', 'pageTitle', 'page'));
  }

  public function destroy($id)
  {
    $data =  DB::table('certificate')->where('id', $id)->delete();
    if ($data) {
      Session::flash('error', 'Success Deleted Data');
      return redirect('eksportir/certificate')->with('error', 'Success Deleted Data');
    } else {
      Session::flash('error', 'Failed Deleted Data');
      return redirect('eksportir/certificate')->with('error', 'Failed Deleted Data');
    }
  }
}
