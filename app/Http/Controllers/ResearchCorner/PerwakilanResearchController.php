<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;
use Mail;

class PerwakilanResearchController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $pageTitle = 'Market Research';
    if (Auth::user()->id_group == 4) {
      return view('research-corner.perwakilan.index', compact('pageTitle'));
    } else {
      return view('research-corner.admin.index', compact('pageTitle'));
    }
  }

  public function getData()
  {
    $id_user = Auth::user()->id;
    $research = DB::table('csc_research_corner')->where('created_by', $id_user)->orderby('publish_date', 'desc')->get();

    return \Yajra\DataTables\DataTables::of($research)
      ->addIndexColumn()
      ->addColumn('country', function ($value) {
        $data =  DB::table('mst_country')->where('id', $value->id_mst_country)->first();
        if ($data) {
          return $data->country;
        } else {
          return 'Country Not Found';
        }
      })
      ->addColumn('type', function ($value) {
        $data =  DB::table('csc_research_type')->where('id', $value->id_csc_research_type)->first();
        if ($data) {
          return $data->nama_en;
        } else {
          return 'Type Not Found';
        }
      })
      ->addColumn('title_en', function ($value) {
        return '<div align="left">' . $value->title_en . '</div>';
      })
      ->addColumn('download', function ($value) {
        return getDataDownload($value->id);
      })
      ->addColumn('date', function ($data) {
        return date('d F Y', strtotime($data->publish_date)) . ' ( ' . date('H:i', strtotime($data->publish_date)) . ' )';
      })
      ->addColumn('action', function ($data) {
        // $research = DB::table('csc_broadcast_research_corner')
        //   ->where('id_research_corner', $data->id)
        //   ->first();
        //   if($research){
        //     return '<center>
        //       <a href="'.route("perwakilan.research-corner.view", $data->id).'" id="button" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
        //       <a onclick="return confirm(\'Are You Sure ?\')" href="'.route("perwakilan.research-corner.destroy", $data->id).'" id="button" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
        //       </center>';
        //   } else {
        return '<center>
                  <button onclick="broadcast(\'' . $data->title_en . '||' . $data->id . '\')" id="button" class="btn btn-sm btn-warning text-white" title="Broadcast">&nbsp;<i class="fa fa-bullhorn text-white"></i></button>&nbsp;&nbsp;
                  <a href="' . route("perwakilan.research-corner.edit", $data->id) . '" id="button" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>
                  </center>';
        // }
      })
      ->rawColumns(['action', 'title_en'])
      ->make(true);
  }

  public function getDataDownload($id)
  {
    $download = DB::table('csc_download_research_corner')
      ->orderby('waktu', 'asc')->where('id_research_corner', $id)->get();

    return \Yajra\DataTables\DataTables::of($download)
      ->addIndexColumn()
      ->addColumn('company', function ($var) {
        $data = DB::table('itdp_profil_eks')->where('id', $var->id_itdp_profil_eks)->first();
        if ($data) {
          return '<div align="left">' . $data->company . '</div>';
        } else {
          return '<div align="left">Company ' . $var->id_itdp_profil_eks . ' Not Found</div>';
        }
      })
      ->addColumn('download_date', function ($data) {
        return date('d F Y', strtotime($data->waktu)) . ' ( ' . date('H:i', strtotime($data->waktu)) . ' )';
      })
      ->rawColumns(['company'])
      ->make(true);
  }

  public function create()
  {
    if (Auth::user()->id_group == 11) {
      Session::flash('error', "You don't have permission to access this page");
      return redirect('perwakilan/research-corner/')->with('error', "You don't have permission to access this page");
    } else {
      $pageTitle = 'Market Research';
      $page = 'create';
      $url = "/perwakilan/research-corner/store/Create";
      $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      if (Auth::user()->id_group == 4) {
        return view('research-corner.perwakilan.create', compact('url', 'pageTitle', 'page', 'country', 'type'));
      } else {
        return redirect('/admin/research-corner');
      }
    }
  }

  public function store(Request $req, $param)
  {
    if (Auth::user()->id_group == 11) {
      Session::flash('error', "You don't have permission to access this page");
      return redirect('perwakilan/research-corner/')->with('error', "You don't have permission to access this page");
    } else {
      $id_user = Auth::user()->id;
      $id = DB::table('csc_research_corner')->orderby('id', 'desc')->first();
      if ($id) {
        $id = $id->id + 1;
      } else {
        $id = 1;
      }

      $destination = 'uploads\Market Research\File\\';
      if ($req->hasFile('file')) {
        $file = $req->file('file');
        $nama_file = time() . '_Research ' . $req->title_en . '_' . $req->file('file')->getClientOriginalName();
        Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
      } else {
        $nama_file = $req->lastest_file;
      }

      $destination = 'uploads\Market Research\Cover\\';
      if ($req->hasFile('cover')) {
        $cover = $req->file('cover');
        $nama_image = time() . '_Cover ' . $req->title_en . '_' . $req->file('cover')->getClientOriginalName();
        Storage::disk('uploads')->putFileAs($destination, $cover, $nama_image);
      } else {
        $nama_image = $req->lastest_cover;
      }

      if ($param == 'Create') {
        $data = DB::table('csc_research_corner')->insert([
          'id' => $id,
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_csc_research_type' => $req->type,
          'id_mst_country' => $req->country,
          'id_mst_hscodes' => $req->code,
          'publish_date' => $req->date,
          'exum' => $nama_file,
          'cover' => $nama_image,
          'download' => 0,
          'created_by' => $id_user
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = DB::table('csc_research_corner')->where('id', $pecah[1])->update([
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_csc_research_type' => $req->type,
          'id_mst_country' => $req->country,
          'id_mst_hscodes' => $req->code,
          'publish_date' => $req->date,
          'exum' => $nama_file,
          'cover' => $nama_image,
          'created_by' => $id_user
        ]);
      }

      if ($data) {
        Session::flash('success', 'Success ' . $param . ' Data');
        return redirect('perwakilan/research-corner/');
      } else {
        Session::flash('error', 'Failed ' . $param . ' Data');
        return redirect('perwakilan/research-corner/');
      }
    }
  }

  public function broadcast(Request $req)
  {
    if (Auth::user()->id_group == 11) {
      Session::flash('error', "You don't have permission to access this page");
      return redirect('perwakilan/research-corner/')->with('error', "You don't have permission to access this page");
    } else {
      date_default_timezone_set('Asia/Jakarta');
      $id_user = Auth::user()->id;
      $array = array();
      $date = date('Y-m-d H:i:s');

      for ($i = 0; $i < count($req->categori); $i++) {
        $var = $req->categori[$i];
        $id = DB::table('csc_broadcast_research_corner')->orderby('id', 'desc')->first();
        if ($id) {
          $id = $id->id + 1;
        } else {
          $id = 1;
        }

        $data = DB::table('csc_broadcast_research_corner')->insert([
          'id' => $id,
          'id_research_corner' => $req->research,
          'id_categori_product' => $req->categori[$i],
          'created_at' => $date
        ]);

        $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
          ->where(function ($query) use ($var) {
            $query->where('id_csc_product', $var)
              ->orWhere('id_csc_product_level1', $var)
              ->orWhere('id_csc_product_level2', $var);
          })
          ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
        foreach ($perusahaan as $key) {
          if (!in_array($key->id_itdp_company_user, $array)) {
            array_push($array, $key->id_itdp_company_user);
          }
        }
      }
      sort($array);
      for ($user = 0; $user < count($array); $user++) {
        $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
        $account_penerima = DB::table('itdp_company_users')->where('id', $array[$user])->first();
        if ($account_penerima) {
          $profile_penerima = DB::table('itdp_profil_eks')->where('id', $account_penerima->id_profil)->first();
          if ($profile_penerima) {
            $notif = DB::table('notif')->insert([
              'dari_nama' => $pengirim->name,
              'dari_id' => $pengirim->id,
              'untuk_nama' => $profile_penerima->company,
              'untuk_id' => $array[$user],
              'keterangan' => 'New Broadcast from ' . $pengirim->name . ' with Title  "' . $req->title_en . '"',
              'url_terkait' => 'research-corner/read',
              'status_baca' => 0,
              'waktu' => $date,
              'id_terkait' => $req->research,
              'to_role' => '2',
            ]);

            $data = [
              'email' => $account_penerima->email,
              'username' => $profile_penerima->company,
              'bu' => $profile_penerima->badanusaha,
              'judul' => $req->title_en,
            ];

            Mail::send('UM.user.sendnotifrceks', $data, function ($mail) use ($data) {
              $mail->to($data['email'], $data['username']);
              $mail->subject('Dokumen Baru di Market Research');
            });
          }
        }
      }

      if ($data) {
        Session::flash('success', 'Success Broadcast Data');
        return redirect('perwakilan/research-corner/');
      } else {
        Session::flash('error', 'Failed Broadcast Data');
        return redirect('perwakilan/research-corner/');
      }
    }
  }

  public function view($id)
  {
    $pageTitle = "Market Research";
    $page = "view";
    $data = DB::table('csc_research_corner')->where('id', $id)->first();
    $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
    $country = DB::table('mst_country')->orderby('country', 'asc')->get();
    if (Auth::user()->id_group == 4) {
      return view('research-corner.perwakilan.create', compact('page', 'data', 'pageTitle', 'country', 'type'));
    } else {
      return redirect('/admin/research-corner');
    }
  }

  public function edit($id)
  {
    if (Auth::user()->id_group == 11) {
      Session::flash('error', "You don't have permission to access this page");
      return redirect('perwakilan/research-corner/')->with('error', "You don't have permission to access this page");
    } else {
      $page = "edit";
      $pageTitle = "Market Research";
      $url = "/perwakilan/research-corner/store/Update_" . $id;
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      if (Auth::user()->id_group == 4) {
        return view('research-corner.perwakilan.create', compact('url', 'data', 'pageTitle', 'page', 'country', 'type'));
      } else {
        return redirect('/admin/research-corner');
      }
    }
  }

  public function destroy($id)
  {
    if (Auth::user()->id_group == 11) {
      Session::flash('error', "You don't have permission to access this page");
      return redirect('perwakilan/research-corner/')->with('error', "You don't have permission to access this page");
    } else {
      $data = DB::table('csc_research_corner')->where('id', $id)->delete();
      if ($data) {
        Session::flash('error', 'Success Delete Data');
        return redirect('perwakilan/research-corner/');
      } else {
        Session::flash('failed', 'Failed Delete Data');
        return redirect('perwakilan/research-corner/');
      }
    }
  }
}
