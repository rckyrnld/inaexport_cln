<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class NewsController extends Controller
{

  public function __construct()
  {
  }

  public function index()
  {
    $pageTitle = 'News';
    $comp = DB::table('itdp_company_users')->whereIn('newsletter', [1, 2])->orderBy('email', 'asc')->get();
    if (isset(Auth::user()->id)) {
      if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
        return view('news.index', compact('pageTitle', 'comp'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function getData()
  {
    $news = DB::table('artikel')->orderBy('tanggal', 'desc')->get();

    return \Yajra\DataTables\DataTables::of($news)
      ->addIndexColumn()
      ->addColumn('judul', function ($data) {
        return $data->judul;
      })
      ->addColumn('tanggal', function ($data) {
        return $data->tanggal;
      })
      ->addColumn('status', function ($data) {
        $p = '';
        if ($data->aktif == 'Y') {
          $p = '<center><span class="btn btn-sm btn-success" style="cursor:default;"><i class="fa fa-check"></i></span></center> ';
        }
        return $p;
      })
      ->rawColumns(['action', 'status'])

      ->addColumn('action', function ($data) {
        $p = '<center><div class="btn-group">';
        $p .= '<a href="' . route('news.view', $data->id) . '" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;<a href="' . route('news.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>&nbsp;<a onclick="return confirm(\'Are You Sure ?\')" href="' . route('news.destroy', $data->id) . '" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a> ';
        return $p . '</div></center>';
      })

      ->make(true);
  }

  public function getDataCompany()
  {
    $comp = DB::table('itdp_company_users')->whereIn('newsletter', [1, 2])->orderBy('email', 'asc')->get();

    return \Yajra\DataTables\DataTables::of($comp)
      ->addIndexColumn()
      ->addColumn('email', function ($data) {
        // return '<div align="left">'.$data->email.'</div>';
        return $data->email;
      })
      ->addColumn('company', function ($data) {
        // return '<div align="left">'.getProfileCompany($data->id_profil).'</div>';
        return getProfileCompany($data->id_profil);
      })
      ->addColumn('action', function ($data) {
        if ($data->status == 1) {
          $p = '<input type="checkbox" checked data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya"><input type="hidden" name="status" id="status" value="1">';
        } else {
          $p = '<input type="checkbox" data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya"><input type="hidden" name="status" id="status" value="2">';
        }
        return $p;
      })
      ->rawColumns(['action'])
      ->make(true);
  }

  public function create()
  {
    $pageTitle = 'News';
    $page = 'create';
    $url = "/news/store/Create";
    $section = "Add News";
    if (isset(Auth::user()->id)) {
      if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
        return view('news.create', compact('url', 'pageTitle', 'page', 'section'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function store(Request $req, $param)
  {

    date_default_timezone_set('Asia/Jakarta');
    // Tujuan
    $send_to = '';
    if ($req->send_to) {
      $send_to = 'Y';
    } else {
      $send_to = 'N';
    }


    $destination = 'uploads\News\\';
    $destination_gambar_header = 'uploads\News\gambar_header\\';
    if ($req->hasFile('file')) {
      $file = $req->file('file');
      $nama_file = time() . '_' . date('Y_m_d') . '_' . $req->file('file')->getClientOriginalName();
      Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
    } else {
      $nama_file = $req->lastest_file;
    }

    if ($req->hasFile('gambar_header')) {
      $gambar_header = $req->file('gambar_header');
      $nama_gambar_header = time() . '_' . date('Y_m_d') . '_' . $req->file('gambar_header')->getClientOriginalName();
      Storage::disk('uploads')->putFileAs($destination_gambar_header, $gambar_header, $nama_gambar_header);
    } else {
      $nama_gambar_header = $req->lastest_gambar_header;
    }

    if ($param == 'Create') {
      $data = $id =  DB::table('artikel')->insertGetId([
        'id_kategoriartikel' => 0,
        'judul' => $req->judul,
        'sub_judul' => '',
        'youtube' => '',
        'judul_seo' => slugifyTitle($req->judul),
        'headline' => 'Y',
        'aktif' => $send_to,
        'utama' => 'Y',
        'isi_artikel' => $req->news,
        'keterangan_gambar' => slugifyTitle($req->judul),
        'hari' => '',
        'tanggal' => $req->tanggal,
        'jam' => $req->jam,
        'gambar' => $nama_file,
        'gambar_header' => $nama_gambar_header,
        'dibaca' => 0,
        'tag' => ''
      ]);
    } else {
      $pecah = explode('|', $param);
      $param = $pecah[0];
      $id = $pecah[1];

      $data =  DB::table('artikel')->where('id', $id)->update([
        'judul' => $req->judul,
        'isi_artikel' => $req->news,
        'gambar' => $nama_file,
        'gambar_header' => $nama_gambar_header,
        'tanggal' => $req->tanggal,
        'jam' => $req->jam,
        'aktif' => $send_to
      ]);
    }

    // End
    if ($data) {
      Session::flash('success', 'Success ' . $param . 'd Data');
      return redirect('/news')->with('success', 'Success ' . $param . 'd Data!');
    } else {
      Session::flash('failed', 'Failed ' . $param . 'd Data');
      return redirect('/news')->with('error', 'Failed ' . $param . 'd Data!');
    }
  }

  public function view($id)
  {
    $pageTitle = "News";
    $page = "view";
    $data =  DB::table('artikel')->where('id', $id)->first();
    $section = "View News";
    if (isset(Auth::user()->id)) {
      if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
        return view('news.create', compact('page', 'data', 'pageTitle', 'section'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function edit($id)
  {
    $page = "edit";
    $pageTitle = "News";
    $section = "Update News";
    $url = "/news/store/Update|" . $id;
    $data =  DB::table('artikel')->where('id', $id)->first();
    if (isset(Auth::user()->id)) {
      if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
        return view('news.create', compact('url', 'data', 'pageTitle', 'page', 'section'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function destroy($id)
  {
    $data =  DB::table('artikel')->where('id', $id)->delete();
    if ($data) {
      Session::flash('error', 'Success Deleted Data');
      return redirect('/news')->with('error', 'Success Deleted Data');
    } else {
      Session::flash('error', 'Failed Deleted Data');
      return redirect('/news')->with('error', 'Failed Deleted Data');
    }
  }

  public function broadcast(Request $req)
  {
    $newsletter =  DB::table('itdp_newsletter')->where('id', $req->newsletter)->first();
    $data = [
      'subject' => $newsletter->about,
      'messages' => $newsletter->messages,
      'file' => $newsletter->file
    ];

    $query = DB::table('itdp_company_users as a')->selectRaw('a.id,a.email')->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')->where('a.newsletter', 1);
    if (strstr($newsletter->send_to, 'All')) {
      $user = $query->groupBy('a.id')->groupBy('a.email')->get();
    } else {
      if (strstr($newsletter->send_to, 'Province')) {
        $arrProv = [];
        $province = DB::table('newsletter_province')->where('id_newsletter', $req->newsletter)->get();
        foreach ($province as $key => $prov) {
          array_push($arrProv, $prov->id_province);
        }
        $query->whereIn('b.id_mst_province', $arrProv);
      }
      if (strstr($newsletter->send_to, 'Category')) {
        $arrCat = [];
        $category = DB::table('newsletter_category')->where('id_newsletter', $req->newsletter)->get();
        foreach ($category as $key => $prov) {
          array_push($arrCat, $prov->id_category);
        }
        $query->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user');
        $query->where(function ($query) use ($arrCat) {
          $query->whereIn('c.id_csc_product', $arrCat)->orWhereIn('c.id_csc_product_level1', $arrCat)->orWhereIn('c.id_csc_product_level2', $arrCat);
        });
      }
      $query->groupBy('a.id')->groupBy('a.email');
      $user = $query->get();
    }

    foreach ($user as $key => $value) {
      $data['email'] = $value->email;
      $data['email_unsub'] = Crypt::encryptString($value->id);
      // return view('newsletter.mail', $data);
      Mail::send('newsletter.mail', $data, function ($mail) use ($data) {
        $mail->subject($data['subject']);
        $mail->to($data['email']);
      });
    }

    $simpan =   DB::table('itdp_newsletter')->where('id', $req->newsletter)->update(['status' => 1]);

    if ($simpan) {
      Session::flash('success', 'Success Broadcast Data');
      return redirect('/newsletter/')->with('success', 'Success Broadcast Data');
    } else {
      Session::flash('failed', 'Failed Broadcast Data');
      return redirect('/newsletter/')->with('error', 'Failed Broadcast Data');
    }
  }

  public function unsubscribe($lock_id)
  {
    $id = Crypt::decryptString($lock_id);
    $data = DB::table('itdp_company_users')->where('id', $id)->update(['newsletter' => 2]);
    if ($data) {
      $message = ['title' => 'You\'ve been unsubscribed.', 'body' => 'You will not get another newsletter. if you have any feedback or questions please contact us.'];
      return view('newsletter.unsubscribe', $message);
    } else {
      $message = ['title' => 'Unsubscribed Failed.', 'body' => 'Unsubscribe failed due to a data error. if you have any feedback or questions please contact us.'];
      return view('newsletter.unsubscribe', $message);
    }
  }

  public function toggleCompany(Request $req)
  {
    $pecah = explode('|', $req->id);
    if ($pecah[1] == 1) {
      $data = DB::table('itdp_company_users')->where('id', $pecah[0])->update(['newsletter' => 2]);
    } else {
      $data = DB::table('itdp_company_users')->where('id', $pecah[0])->update(['newsletter' => 1]);
    }
    if ($data)
      return 'Success';
    else
      return 'Failed';
  }
}
