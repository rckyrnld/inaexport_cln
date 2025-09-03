<?php

namespace App\Http\Controllers\Eksportir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class ServiceController extends Controller
{
  public function __construct()
  {
    // if(Auth::check()){
    //   $this->middleware('auth');
    // } else {
    //   $this->middleware('auth:eksmp');
    // }
  }

  public function index()
  {
    $pageTitle = "Service";
    if (Auth::guard('eksmp')->user()) {
      if (Auth::guard('eksmp')->user()->id_role == 2) {
        return view('eksportir.service.index', compact('pageTitle'));
      } else {
        return redirect('/login');
      }
    } else {
      return redirect('/login');
    }
  }

  public function index_admin($id)
  {
    $pageTitle = "Service";
    if (Auth::user()) {
      $data = DB::table('itdp_service_eks')->where('id', $id)->first();
      return view('eksportir.service.index_admin', compact('pageTitle', 'id', 'data'));
    } else {
      return redirect('/login');
    }
  }

  public function verifikasi($id)
  {
    if (Auth::user()) {
      DB::table('notif')->where('url_terkait', 'eksportir/service/verifikasi')->where('id_terkait', $id)->update([
        'status_baca' => 1
      ]);
      $pageTitle = 'Service';
      $data = DB::table('itdp_service_eks')->where('id', $id)->first();
      return view('eksportir.service.verifikasi', compact('pageTitle', 'data'));
    } else {
      return redirect('/login');
    }
  }

  public function approval(Request $req, $id)
  {
    if (Auth::user()) {
      $id_user = Auth::user()->id;
      $data_sebelumnya = DB::table('itdp_service_eks')->where('id', $id)->first();
      $pageTitle = 'Service';
      if ($req->verifikasi == 1) {
        $status = 2;
        $ket = "This product has been added on the front page";
        $notifnya = "has been accepted";

        $update = DB::table('itdp_service_eks')->where('id', $id)->update([
          'status' => 2,
          'keterangan' => $ket
        ]);
      } else {
        $status = 3;
        $ket = "The product that you added cannot be displayed on the front page because " . $req->keterangan;
        $notifnya = "has been declined";

        $update = DB::table('itdp_service_eks')->where('id', $id)->update([
          'status' => 3,
          'keterangan' => $ket
        ]);
      }

      $cek_notif = DB::table('notif')->where('url_terkait', 'eksportir/service/view')
        ->where('id_terkait', $id)
        ->where('untuk_id', getIdUserEks($data_sebelumnya->id_itdp_profil_eks))
        ->first();

      if ($update) {
        if (!$cek_notif) {
          $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
          $penerima = DB::table('itdp_profil_eks')->where('id', $data_sebelumnya->id_itdp_profil_eks)->first();
          $notif = DB::table('notif')->insert([
            'dari_nama' => $pengirim->name,
            'dari_id' => $id_user,
            'untuk_nama' => $penerima->company,
            'untuk_id' => getIdUserEks($data_sebelumnya->id_itdp_profil_eks),
            'keterangan' => 'Product ' . $data_sebelumnya->nama_en . ' ' . $notifnya . ' by Admin',
            'url_terkait' => 'eksportir/service/view',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'id_terkait' => $id,
            'to_role' => 2
          ]);
        } else {
          $notif = DB::table('notif')->where('id_notif', $cek_notif->id_notif)->update([
            'keterangan' => 'Product ' . $data_sebelumnya->nama_en . ' ' . $notifnya . ' by Admin',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s')
          ]);
        }
      }
      return redirect('/eksportir/service/admin/' . $data_sebelumnya->id_itdp_profil_eks);
    } else {
      return redirect('/login');
    }
  }

  public function getData($id)
  {
    if (Auth::user()) {
      $service = DB::table('itdp_service_eks as a')->where('id_itdp_profil_eks', $id)->where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
    } else if (Auth::guard('eksmp')->user()) {
      if (Auth::guard('eksmp')->user()->id_role == 2) {
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $service = DB::table('itdp_service_eks as a')->where('id_itdp_profil_eks', $id_profil)->orderBy('created_at', 'desc')->get();
      }
    } else {
      return redirect('/login');
    }

    return \Yajra\DataTables\DataTables::of($service)
      ->addIndexColumn()
      ->addColumn('bidang_en', function ($value) {

        return '<div align="left">' . $value->bidang_en . '</div>';
      })
      ->addColumn('status', function ($value) {
        switch ($value->status) {
          case 0:
            return 'Hide';
            break;
          case 1:
            return 'Publish';
            break;
          case 2:
            return 'Publish - Accepted';
            break;
          case 3:
            return 'Publish - Rejected';
            break;
        }
      })
      ->addColumn('pengalaman_en', function ($value) {
        $hitung = substr_count($value->pengalaman_en, '<p>');
        if ($hitung > 3) {
          $pecah = explode('<p>', $value->pengalaman_en);
          return '<div align="left">' . $pecah[1] . $pecah[2] . $pecah[3] . '.........</div>';
        } else {
          return '<div align="left">' . $value->pengalaman_en . '</div>';
        }
      })
      ->addColumn('link', function ($value) {
        $hitung = substr_count($value->link, '<p>');
        if ($hitung > 3) {
          $pecah = explode('<p>', $value->link);
          return $pecah[1] . $pecah[2] . $pecah[3] . '.........';
        } else {
          return $value->link;
        }
      })
      ->addColumn('skill_en', function ($value) {
        $hitung = preg_split('/\n/', $value->skill_en);
        // var_dump($hitung);
        if (count($hitung) > 3) {
          return '<div align="left">' . $hitung[0] . '<br>' . $hitung[1] . '<br>' . $hitung[2] . '<br>.........</div>';
        } else {
          return '<div align="left">' . $value->skill_en . '</div>';
        }
      })
      ->addColumn('action', function ($data) {
        if (Auth::user()) {
          if ($data->status == 2) {
            return '
                <center>
                  <div class="btn-group">
                    <a href="' . route('service.view', $data->id) . '" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>
                  </div>
                </center>';
          } else if ($data->status != 0) {
            if ($data->status == 1) {
              $class = 'success';
            } else {
              $class = 'danger';
            }
            return '
                <center>
                  <div class="btn-group">
                    <a href="' . route('service.view', $data->id) . '" class="btn btn-sm btn-info" title="View"> <i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                    <a href="' . route('service.verifikasi', $data->id) . '" class="btn btn-sm btn-' . $class . '" title="Verifikasi">&nbsp;<i class="fa fa-edit text-white"></i></a>
                  </div>
                </center>';
          }
        } else {
          return '
              <center>
                <div class="btn-group">
                  <a href="' . route('service.view', $data->id) . '" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                  <a href="' . route('service.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('service.destroy', $data->id) . '" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
                </div>
              </center>';
        }
      })
      ->rawColumns(['action', 'skill_en', 'pengalaman_en', 'link', 'bidang_en'])
      ->make(true);
  }

  public function create()
  {
    if (Auth::guard('eksmp')->user()) {
      if (Auth::guard('eksmp')->user()->id_role == 2) {
        $url = '/eksportir/service/store';
        $pageTitle = 'Service';
        return view('eksportir.service.create', compact('pageTitle', 'url'));
      } else {
        return redirect('/login');
      }
    } else {
      return redirect('/login');
    }
  }

  public function view($id)
  {
    if (Auth::guard('eksmp')->user() || Auth::user()) {
      if (Auth::user()) {
        $id_user = Auth::user()->id;
        DB::table('notif')->where('url_terkait', 'eksportir/service/verifikasi')->where('untuk_id', $id_user)->where('id_terkait', $id)->update([
          'status_baca' => 1
        ]);
        $data = DB::table('itdp_service_eks')->where('id', $id)->first();
        $button = '<a class="btn btn-danger" href="' . url('eksportir/service/admin/' . $data->id_itdp_profil_eks) . '" style="width: 80px;">Back</a>';
        $pageTitle = 'Service';
        return view('eksportir.service.view', compact('pageTitle', 'data', 'button'));
      } else if (Auth::guard('eksmp')->user()->id_role == 2) {
        $id_user = Auth::guard('eksmp')->user()->id;
        $cek = DB::table('notif')->where('url_terkait', 'eksportir/service/view')->where('untuk_id', $id_user)->where('id_terkait', $id)->update([
          'status_baca' => 1
        ]);
        $data = DB::table('itdp_service_eks')->where('id', $id)->first();
        $button = '<a class="btn btn-danger" href="' . url('eksportir/service') . '" style="width: 80px;">Back</a>';
        $pageTitle = 'Service';
        return view('eksportir.service.view', compact('pageTitle', 'data', 'button'));
      } else {
        return redirect('/login');
      }
    } else {
      return redirect('/login');
    }
  }

  public function edit($id)
  {
    if (Auth::guard('eksmp')->user()) {
      if (Auth::guard('eksmp')->user()->id_role == 2) {
        $data = DB::table('itdp_service_eks')->where('id', $id)->first();
        $url = '/eksportir/service/update/' . $id;
        $pageTitle = 'Service';
        return view('eksportir.service.edit', compact('pageTitle', 'url', 'data'));
      } else {
        return redirect('/login');
      }
    } else {
      return redirect('/login');
    }
  }

  public function store(Request $req)
  {
    // dd($req->all());
    if (Auth::guard('eksmp')->user()->id_role == 2) {
      $id_profil = Auth::guard('eksmp')->user()->id_profil;
      $id_user = Auth::guard('eksmp')->user()->id;
      $id = DB::table('itdp_service_eks')->orderBy('id', 'desc')->first();
      $date =  date('Y-m-d H:i:s');

      if ($id) {
        $id = $id->id + 1;
      } else {
        $id = 1;
      }
      $bidang_en = '';
      $bidang_ind = '';
      // $bidang_chn = '';

      $jumlah_bidang = count($req->bidang_en);
      for ($i = 0; $i < $jumlah_bidang; $i++) {
        if ($i === $jumlah_bidang - 1) {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_ind .= $req->bidang_ind[$i];
          // $bidang_chn .= $req->bidang_chn[$i];
        } else {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_en .= ', ';
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_ind .= ', ';
          // $bidang_chn .= $req->bidang_chn[$i];
          // $bidang_chn .= ', ';
        }
      }

      $data = DB::table('itdp_service_eks')->insert([
        'id' => $id,
        'id_itdp_profil_eks' => $id_profil,
        'nama_en' => $req->name_en,
        'nama_ind' => $req->name_ind,
        // 'nama_chn' => $req->name_chn,
        'bidang_en' => $bidang_en,
        'bidang_ind' => $bidang_ind,
        // 'bidang_chn' => $bidang_chn,
        'skill_en' => $req->skill_en,
        'skill_ind' => $req->skill_ind,
        // 'skill_chn' => $req->skill_chn,
        'pengalaman_en' => $req->experience_en,
        'pengalaman_ind' => $req->experience_ind,
        // 'pengalaman_chn' => $req->experience_chn,
        'link' => $req->link,
        'status' => $req->status,
        'created_at' => $date
      ]);

      if ($req->status == 1) {
        $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
        foreach ($admin as $adm) {
          $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyName($id_user),
            'dari_id' => $id_user,
            'untuk_nama' => $adm->name,
            'untuk_id' => $adm->id,
            'keterangan' => 'New Service Published By ' . getCompanyName($id_user) . ' with Title  "' . $req->name_en . '"',
            'url_terkait' => 'eksportir/service/verifikasi',
            'status_baca' => 0,
            'waktu' => $date,
            'id_terkait' => $id,
            'to_role' => 1
          ]);
        }
      }

      if ($data) {
        Session::flash('success', 'Success Store Data');
        return redirect('/eksportir/service/')->with('success', 'Success Add Data');
      } else {
        Session::flash('failed', 'Failed Store Data');
        return redirect('/eksportir/service/')->with('error', 'Success Add Data');
      }
    } else {
      return redirect('/login');
    }
  }

  public function update(Request $req, $id)
  {
    if (Auth::guard('eksmp')->user()->id_role == 2) {
      $id_user = Auth::guard('eksmp')->user()->id;
      $date = date('Y-m-d H:i:s');
      $bidang_en = '';
      $bidang_ind = '';
      // $bidang_chn = '';
      $data_sebelumnya = DB::table('itdp_service_eks')->where('id', $id)->first();
      if ($data_sebelumnya->status == 2 || $data_sebelumnya->status == 3) {
        $status = $data_sebelumnya->status;
      } else {
        $status = $req->status;
      }

      $jumlah_bidang = count($req->bidang_en);
      for ($i = 0; $i < $jumlah_bidang; $i++) {
        if ($i === $jumlah_bidang - 1) {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_ind .= $req->bidang_ind[$i];
          // $bidang_chn .= $req->bidang_chn[$i];
        } else {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_en .= ', ';
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_ind .= ', ';
          // $bidang_chn .= $req->bidang_chn[$i];
          // $bidang_chn .= ', ';
        }
      }

      $data = DB::table('itdp_service_eks')->where('id', $id)->update([
        'nama_en' => $req->name_en,
        'nama_ind' => $req->name_ind,
        // 'nama_chn' => $req->name_chn,
        'bidang_en' => $bidang_en,
        'bidang_ind' => $bidang_ind,
        // 'bidang_chn' => $bidang_chn,
        'skill_en' => $req->skill_en,
        'skill_ind' => $req->skill_ind,
        // 'skill_chn' => $req->skill_chn,
        'pengalaman_en' => $req->experience_en,
        'pengalaman_ind' => $req->experience_ind,
        // 'pengalaman_chn' => $req->experience_chn,
        'link' => $req->link,
        'status' => $status,
        'updated_at' => $date
      ]);

      $cek_notif = DB::table('notif')->where('url_terkait', 'eksportir/service/verifikasi')
        ->where('id_terkait', $id)
        ->where('dari_id', $id_user)
        ->first();

      if ($status == 1) {
        if (!$cek_notif) {
          $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
          foreach ($admin as $adm) {
            $notif = DB::table('notif')->insert([
              'dari_nama' => getCompanyName($id_user),
              'dari_id' => $id_user,
              'untuk_nama' => $adm->name,
              'untuk_id' => $adm->id,
              'keterangan' => 'New Service Published By ' . getCompanyName($id_user) . ' with Title  "' . $req->name_en . '"',
              'url_terkait' => 'eksportir/service/verifikasi',
              'status_baca' => 0,
              'waktu' => $date,
              'id_terkait' => $id,
              'to_role' => 1
            ]);
          }
        }
      } else if ($status == 3) {
        if ($req->status != 0) {
          $notif = DB::table('notif')->where('url_terkait', 'eksportir/service/verifikasi')->where('id_terkait', $id)->where('dari_id', $id_user)->update([
            'keterangan' => 'New Service Published By ' . getCompanyName($id_user) . ' with Title  "' . $req->name_en . '"',
            'status_baca' => 0,
            'waktu' => $date
          ]);
        }
      }

      if ($data) {
        Session::flash('success', 'Success Store Data');
        return redirect('/eksportir/service/')->with('success', 'Success Update Data');
      } else {
        Session::flash('failed', 'Failed Store Data');
        return redirect('/eksportir/service/')->with('error', 'Failed Update Data');
      }
    } else {
      return redirect('/login');
    }
  }

  public function destroy($id)
  {
    if (Auth::guard('eksmp')->user()->id_role == 2) {
      $data = DB::table('itdp_service_eks')->where('id', $id)->delete();
      if ($data) {
        Session::flash('success', 'Success Delete Data');
        return redirect('/eksportir/service/')->with('error', 'Success Delete Data');
      } else {
        Session::flash('failed', 'Failed Delete Data');
        return redirect('/eksportir/service/')->with('error', 'Error Delete Data');
      }
    } else {
      return redirect('/login');
    }
  }
}
