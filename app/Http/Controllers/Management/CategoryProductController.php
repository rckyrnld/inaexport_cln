<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;

class CategoryProductController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $pageTitle = 'List Category Product';
    $product = DB::table('csc_product')->orderby('nama_kategori_en', 'asc')->where('level_1', 0)->where('level_2', 0)->get();
    return view('management.category-product.index', compact('pageTitle', 'product'));
  }

  public function home(Request $req)
  {
    // Category
    for ($i = 1; $i <= 6; $i++) {

      $up = DB::table('csc_product_home')->updateOrInsert(
        [
          'number' => $i,
          'id_parent' => null
        ],
        [
          'id_product' => $req->{"cat$i"},
          'updated_at' => date('Y-m-d H:i:s')
        ]
      );

      if ($up) {

        $cat = DB::table('csc_product_home')->where('number', $i)->whereNull('id_parent')->first();

        // Sub Category
        for ($k = 1; $k <= 6; $k++) {
          DB::table('csc_product_home')->updateOrInsert(
            [
              'number' => $k,
              'id_parent' => $cat->id
              // 'id_parent' => $req->{"cat$i"}
            ],
            [
              'id_product_parent' => $cat->id_product,
              'id_product' => $req->{"sub$i" . "_" . "$k"},
              'updated_at' => date('Y-m-d H:i:s')
            ]
          );
        }
      }
    }

    return redirect('management/category-product/');
  }

  public function getData()
  {
    $product = DB::table('csc_product')->orderby('level_1', 'asc')->orderby('level_2', 'asc')->orderby('nama_kategori_en', 'asc')->get();

    return \Yajra\DataTables\DataTables::of($product)
      ->addIndexColumn()
      ->addColumn('nama_kategori_en', function ($data) {
        return '<div align="left">' . $data->nama_kategori_en . '</div>';
      })
      ->addColumn('action', function ($data) {
        //              return '
        //              <center>
        //              <div class="btn-group">
        //                <a href="'.route('management.category-product.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
        //                <a href="'.route('management.category-product.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
        //                <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('management.category-product.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
        //              </div>
        //              </center>
        //              ';

        return '
              <center>
              <div class="btn-group">
                <a href="' . route('management.category-product.view', $data->id) . '" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                <a href="' . route('management.category-product.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('management.category-product.destroy', $data->id) . '" class="btn btn-sm btn-danger"title="Delete"><i class="fa fa-trash text-white"></i></a>
              </div>
              </center>
              ';
      })
      ->rawColumns(['action', 'nama_kategori_en'])
      ->make(true);
  }

  public function create()
  {
    $pageTitle = 'Create Category Product';
    $page = 'create';
    $url = "/management/category-product/store/Create";
    $action = "Create";
    $level_1 = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
    return view('management.category-product.create', compact('url', 'pageTitle', 'page', 'level_1', 'action'));
  }

  public function store(Request $req, $param)
  {
    $id = DB::table('csc_product')->orderby('id', 'desc')->first();
    if ($id) {
      $id = $id->id + 1;
    } else {
      $id = 1;
    }
    if ($req->level_2 == 0) {
      $level_1 = $req->level_1;
      $level_2 = 0;
      $keyword = null;
    } else {
      $level_1 = $req->level_1;
      $level_2 = $req->level_2;
      $keyword = $req->keyword;
    };

    if ($req->level_1 == '0') {
      $destination = 'uploads\Product\Icon\\';
      if ($req->hasFile('icon')) {
        $icon = $req->file('icon');
        $nama_image = time() . '_icon-' . $req->product_en . '_' . $req->file('icon')->getClientOriginalName();
        Storage::disk('uploads')->putFileAs($destination, $icon, $nama_image);
      } else {
        $nama_image = $req->latest_icon;
      }
    } else {
      $nama_image = null;
    }

    // $destination= 'uploads\Product\Banner\\';
    $destination = 'assets\assets\versi 1\\';
    if ($req->hasFile('banner')) {
      $banner = $req->file('banner');
      $nama_banner = time() . '_banner-' . $req->product_en . '_' . $req->file('banner')->getClientOriginalName();
      Storage::disk('uploads')->putFileAs($destination, $banner, $nama_banner);
    } else {
      $nama_banner = (isset($req->latest_banner)) ? $req->latest_banner : null;
    }

    if ($param == 'Create') {

      $data = DB::table('csc_product')->insert([
        'id' => $id,
        'level_1' => $level_1,
        'level_2' => $level_2,
        'nama_kategori_en' => $req->product_en,
        'nama_kategori_in' => $req->product_in,
        'nama_kategori_chn' => $req->product_chn,
        'logo' => $nama_image,
        'banner' => $nama_banner,
        'keyword' => $keyword
      ]);
    } else {
      $pecah = explode('_', $param);
      $param = $pecah[0];

      $data = DB::table('csc_product')->where('id', $pecah[1])->update([
        'level_1' => $level_1,
        'level_2' => $level_2,
        'nama_kategori_en' => $req->product_en,
        'nama_kategori_in' => $req->product_in,
        'nama_kategori_chn' => $req->product_chn,
        'logo' => $nama_image,
        'banner' => $nama_banner,
        'keyword' => $keyword
      ]);
    }

    if ($data) {
      Session::flash('success', 'Success ' . $param . ' Data');
      return redirect('management/category-product/')->with('success', 'Success ' . $param . ' Data');
    } else {
      Session::flash('failed', 'Failed ' . $param . ' Data');
      return redirect('management/category-product/')->with('error', 'Failed ' . $param . ' Data');
    }
  }

  public function view($id)
  {
    $pageTitle = "View Category Product";
    $page = "view";
    $action = "View";
    $data = DB::table('csc_product')->where('id', $id)->first();
    $level_1 = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
    return view('management.category-product.create', compact('page', 'data', 'pageTitle', 'level_1', 'action'));
  }

  public function edit($id)
  {
    $page = "edit";
    $pageTitle = "Edit Category Product";
    $action = "Edit";
    $url = "/management/category-product/store/Update_" . $id;
    $data = DB::table('csc_product')->where('id', $id)->first();
    $level_1 = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
    return view('management.category-product.create', compact('url', 'data', 'pageTitle', 'page', 'level_1', 'action'));
  }

  public function destroy($id)
  {
    $data = DB::table('csc_product')->where('id', $id)->delete();
    if ($data) {
      Session::flash('error', 'Success Delete Data');
      return redirect('management/category-product/');
    } else {
      Session::flash('error', 'Failed Delete Data');
      return redirect('management/category-product/');
    }
  }

  public function level_2(Request $req)
  {
    $checking = DB::table('csc_product')
      ->where('level_1', $req->id)
      ->where('level_2', 0)
      ->whereNotIn('id', [$req->except])
      ->orderby('nama_kategori_en', 'asc')->get();

    $data = '<option value="0">Main Sub Hierarchy</option>';
    if ($checking) {
      foreach ($checking as $val) {
        $data .= '<option value="' . $val->id . '">' . $val->nama_kategori_en . '</option>';
      }
    }
    echo json_encode($data);
  }

  public function level_2_home(Request $req)
  {
    $checking = DB::table('csc_product')
      ->where('level_1', $req->id)
      ->where('level_2', 0)
      ->orderby('nama_kategori_en', 'asc')->get();

    $data = '<option></option>';
    if ($checking) {
      foreach ($checking as $val) {
        $data .= '<option value="' . $val->id . '">' . $val->nama_kategori_en . '</option>';
      }
    }
    echo json_encode($data);
  }
}
