<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Banner_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterBannerController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function message(){ 
    return redirect('master-banner')->with('success','Success Update Data');
  }

  public function index(){
    $pageTitle = 'Master Banner';
    $sampledata = Banner::where('deleted_at', null)->get();
    return view('master.banner.index',compact('pageTitle','sampledata'));
  }

  public function create()
  {
    $pageTitle = 'Create Banner';
    $page = 'create';
    $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
    return view('master.banner.create',compact('pageTitle', 'page', 'catprod'));
  }

  public function store($param, Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $datenow = date("Y-m-d H:i:s");
    if ($param == 'create') {
      // untuk nambahin image dan category
      if(empty($request->file('file_img'))){
        $file = "";
      }else{
        $file = $request->file('file_img')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/banner";
        $request->file('file_img')->move($destinationPath, $file);
      }

      $store = Banner::insert([
              'file' => $file,
              'id_csc_product' => $request->id_csc_product,
              'id_csc_product_level1' => $request->id_csc_product_level1,
              'id_csc_product_level2' => $request->id_csc_product_level2,
              'nama' => $request->nama,
              'status' => 0,
              'type' => $request->type,
              'ordering' =>$request->order,
              'created_at' => $datenow
              ]);

      return redirect('master-banner')->with('success','Success Add Data');
    } else if ($param == 'update') {
      
      $banner = Banner::where('id', $request->id)->get();
      // untuk aktifin banner
      if($request->semua == 1){ 
        // untuk perusahaan yang sesuai kategori start
        if (isset($banner[0]->id_csc_product_level2)) {
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level2', $banner[0]->id_csc_product_level2)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else if(isset($banner[0]->id_csc_product_level1)){
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level1', $banner[0]->id_csc_product_level1)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else{
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product', $banner[0]->id_csc_product)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }
        $explodeksportir = $company;
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".$eksportir->id."'");
          if(count($cekada) == 0){
            $storedetail = Banner_Detail::insert([
                    'id_banner' => $request->id,
                    'id_eks' => $eksportir->id,
                    'created_at' => $datenow,
                    'jenis_detail' => 1
                    ]);
           }
        }
        // untuk perusahaan yang sesuai kategori end
      }
      else{
        if($banner[0]->type == 2){
        }else{
          $dataeksportir = $request->dataeksportir;
        $explodeksportir = explode(',',$dataeksportir);
        // untuk perusahaan yang sesuai kategori end

        // untuk perusahaan diluar kategori start
        // $dataeksportirlain = $request->dataeksportirlain;
        // $explodeksportirlain = explode(',',$dataeksportirlain);
        // untuk perusahaan diluar kategori end
        // merge udah otomatis gak ada yang sama
        // $allexportir = array_merge($explodeksportir, $explodeksportirlain);
        // dd($allexportir);
        foreach($explodeksportir as $eksportir){
          $cekada = DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".(int)$eksportir."'");
          if(count($cekada) == 0){
              $storedetail = Banner_Detail::insert([
                      'id_banner' => $request->id,
                      'id_eks' => $eksportir,
                      'created_at' => $datenow,
                      'jenis_detail' => 1
                      ]);
          }
        }
        DB::table('banner_detail')->where('id_banner',$request->id)->where('jenis_detail', 1)->wherenotin('id_eks',$explodeksportir)->delete();
        

        }
        // untuk perusahaan yang sesuai kategori start
        
      }
      $update = Banner::where('id', $request->id)
              ->update(['end_at' => $request->s_date,'updated_at' => $datenow, 'status' => $request->status, 'nama' => $request->nama, 
              'ordering' =>$request->order]);

      
      $baliknya = 'sukses';
      return json_encode($baliknya);
    }else if($param == 'update2'){
      // untuk edit yang sudah pernah diaktifin
      // untuk kalo mau bikin checklist hapus semua
      if($request->hapussemua == 1){
        DB::table('banner_detail')->where('id_banner',$request->id)->where('jenis_detail', 1)->delete();
      }else if($request->semua == 1){ 
        $banner = Banner::where('id', $request->id)->get();
        if (isset($banner[0]->id_csc_product_level2)) {
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level2', $banner[0]->id_csc_product_level2)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else if(isset($banner[0]->id_csc_product_level1)){
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level1', $banner[0]->id_csc_product_level1)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else{
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product', $banner[0]->id_csc_product)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }
        $explodeksportir = $company;
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".$eksportir->id."'");
          if(count($cekada) == 0){
            $storedetail = Banner_Detail::insert([
                    'id_banner' => $request->id,
                    'id_eks' => $eksportir->id,
                    'created_at' => $datenow,
                    'jenis_detail' => 1
                    ]);
           }
        }
      }else if($request->dataeksportir != null){
        $dataeksportir = $request->dataeksportir;
        $explodeksportir = explode(',',$dataeksportir);
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".(int)$eksportir."'");
          if(count($cekada) == 0){
              $storedetail = Banner_Detail::insert([
                      'id_banner' => $request->id,
                      'id_eks' => $eksportir,
                      'created_at' => $datenow,
                      'jenis_detail' => 1
                      ]);
          }
          
          DB::table('banner_detail')->where('id_banner',$request->id)->where('jenis_detail', 1)->wherenotin('id_eks',$explodeksportir)->delete();
        }
      }
      $data1 = [
                'end_at' => $request->s_date,
                'updated_at' => $datenow, 
                'status' => $request->status, 
                'nama' => $request->nama,
                'ordering' =>$request->order,
              ];
      
      $cek1 = $request->file('file');
      if (isset($cek1)) {
          $filenya = $request->file('file');
          $extension1 = $filenya->getClientOriginalExtension();
          $filename1 = 'File'.uniqid().'.'.$extension1;
          $destinationPath1 =public_path() . "/uploads/banner";
          $filenya->move($destinationPath1, $filename1); // move file to our uploads path
          $data1['file'] = $filename1;
      }

      $update = Banner::where('id', $request->id)
              ->update($data1);

      
      $baliknya = 'sukses';
      return json_encode($baliknya);
    }
  }

  public function getData(Request $request)
  {
    $today = date("Y-m-d h:i:s");
    $columns = array(
      0 => 'id',
      1 => 'nama',
    );

    $totalData = DB::table('banner')->where('deleted_at', null)->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $datanyaawal = DB::table('banner')
              ->where('deleted_at', null)
              ->offset($start)
              ->orderBy($order, $dir);

        $datanya = $datanyaawal->limit($limit)->get();

      $totalFiltered = $datanyaawal->count();
    }else{
      $search = $request->input('search.value');
            $datanyaawal =DB::table('banner')
                    ->where('deleted_at', null)
                ->where(function ($query) use ($search) {
                    $query->where('nama', 'ilike', '%' . $search . '%');
                })
                ->offset($start)
                ->orderBy($order, $dir);
            $datanya= $datanyaawal->limit($limit)->get();

            $totalFiltered = $datanyaawal->count();
    }

    $data = array();
// dd($posts);
    if ($datanya) {
      $count = $start+1;
      foreach ($datanya as $d) {
        $token = csrf_token();
        $nestedData['no'] = $count;
        $nestedData['nama'] = $d->nama;
        $nestedData['file'] = '<div class="thumbnail"><img src="'.asset('/uploads/banner/'.$d->file).'" alt="Lights" style="width:100%"></div>';
        // if($d->end_at != null){
        //   $nestedData['until'] = date('d-m-Y',strtotime($d->end_at));
        // }else{
        //   $nestedData['until'] = '-';
        // }
        $nestedData['order'] = '<div style="text-align:left">'.$d->ordering.'</div>';
        $nestedData['until'] = isset($d->end_at) ? date('d-m-Y',strtotime($d->end_at)) : '-';
        if($d->status == 1 && (date('d-m-Y',strtotime($d->end_at)) == date('d-m-Y',strtotime($today)) || date('d-m-Y',strtotime($d->end_at)) > date('d-m-Y',strtotime($today)) ) ){
          $nestedData['status'] = 'Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalEdit2" data-image-id = "'.$d->file.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-check-id="'.$d->status.'" data-edit-id="'.$d->id.'" data-edit-order="'.$d->ordering.'" data-edit-type="'.$d->type.'" data-edit-name="'.$d->nama.'"><i class="fas fa-edit"></i></button>
                               <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';

        } else if($d->status == 2){
          // untuk yang pernah aktif, tapi di nonaktifkan
          $nestedData['status'] = 'Tidak Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalEdit2" data-image-id = "'.$d->file.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-check-id="'.$d->status.'" data-edit-id="'.$d->id.'" data-edit-order="'.$d->ordering.'" data-edit-type="'.$d->type.'" data-edit-name="'.$d->nama.'"><i class="fas fa-edit"></i></button>
                               <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';

        }
        else if($d->status == 0 ) {
          $nestedData['status'] = 'Tidak Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalEdit" data-edit-id="'.$d->id.'" data-edit-name="'.$d->nama.'" data-edit-order="'.$d->ordering.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-edit-type="'.$d->type.'"><i class="fas fa-edit"></i></i></button>
                                <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';
        }else{
          $nestedData['status'] = 'Tidak Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalEdit2" data-edit-id="'.$d->id.'" data-edit-name="'.$d->nama.'" data-edit-order="'.$d->ordering.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-edit-type="'.$d->type.'"><i class="fas fa-edit"></i></button>
                                <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';
        }
        
                              // <button type="button" onclick="destroy('.$d->id.')" class="btn btn-sm btn-danger" title="Cetak"><i class="fa fa-trash"></i></button> </div>';
        $data[] = $nestedData;
        $count++;
      }
    }
      $json_data = array(
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'data' => $data
      );
      // dd($json_data);

      echo json_encode($json_data);
  }

  

  public function getCompany(Request $request)
  {
    //disini masih error pas cari perusahaan yang sudah di verifikasi productnya
    $banner = Banner::find($request->id);
    // dd($banner->id_csc_product_level2);
    if($request->tipe == 'kategori'){
      if (isset($banner->id_csc_product_level2)) {
        $company = DB::table('csc_product_single')  
                    ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                    ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                    ->where('itdp_company_users.status',1)
                    ->where('csc_product_single.status',2)
                    ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                    ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->orderBy('itdp_profil_eks.id', 'ASC')
                    ->get();
      }else if(isset($banner->id_csc_product_level1)){
        $company = DB::table('csc_product_single')
                    ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                    ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                    ->where('itdp_company_users.status',1)
                    ->where('csc_product_single.status',2)
                    ->where('csc_product_single.id_csc_product_level1', $banner->id_csc_product_level1)
                    ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->orderBy('itdp_profil_eks.id', 'ASC')
                    ->get();
      }else{
        $company = DB::table('csc_product_single')
                    ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                    ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                    ->where('itdp_company_users.status',1)
                    ->where('csc_product_single.status',2)
                    ->where('csc_product_single.id_csc_product', $banner->id_csc_product)
                    ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                    ->orderBy('itdp_profil_eks.id', 'ASC')
                    ->get();
      }
    }else{
      $company = DB::table('banner_detail')
                  ->join('itdp_profil_eks', 'banner_detail.id_eks','itdp_profil_eks.id')
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->where('id_banner',$request->id)
                  ->where('jenis_detail', 2)
                  ->get();
    }

    $no = 0;
    foreach ($company as $val) {
      $company[$no]->no = ($no+1);
      $no++;
    }
    
    return response()->json($company);
  }

  public function getCompany2(Request $request)
  {
    $banner = Banner::find($request->id);
    $banner_detail = Banner_Detail::where('id_banner',$request->id)->get();
    if (isset($banner->id_csc_product_level2)) {
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                  ->where('itdp_company_users.status',1)
                  ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else if(isset($banner->id_csc_product_level1)){
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                  ->where('itdp_company_users.status',1)
                  ->where('csc_product_single.id_csc_product_level1', $banner->id_csc_product_level1)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else{
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
                  ->where('itdp_company_users.status',1)
                  ->where('csc_product_single.id_csc_product', $banner->id_csc_product)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }
    
    $no = 0;
    foreach ($company as $val) {
      if(Banner_Detail::where([['id_banner', '=',$request->id],['id_eks', '=',$val->id]])->exists()){
        $company[$no]->status = 1;
      }else{
        $company[$no]->status = 0;
      }
      $company[$no]->no = ($no+1);
      $no++;
    }
    
    return response()->json($company);
  }

  public function getCompanyName(Request $request){
    
    // dd(isset($request->id));
    // dd($request);
    $exceptcompanies = [];
    $incompanies = [];
    $banner = Banner::find($request->idbanner);
    // untuk yang nama companynya udah ada di sebelumnya start
    if (isset($banner->id_csc_product_level2)) {
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else if(isset($banner->id_csc_product_level1)){
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level1', $banner->id_csc_product_level1)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else{
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product', $banner->id_csc_product)
                  ->where('csc_product_single.status',2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }
    // untuk yang nama companynya belum ada di sebelumnya end    
    foreach($company as $comp){
      array_push($exceptcompanies,$comp->id);
    }

    // untuk yang udah ada di table meskipun bukan dari category start
    $another = DB::Table('banner_detail')->where('id_banner', $request->idbanner)->where('jenis_detail',2)->get();
    // dd($another);
    // untuk yang udah ada di table meskipun bukan dari category end
    foreach($another as $comp){
      array_push($exceptcompanies,$comp->id_eks);
    }

    $companyhasproduct = DB::table('csc_product_single')
                        ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                        ->where('csc_product_single.status',2)
                        ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                        ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                        ->orderBy('itdp_profil_eks.id', 'ASC')
                        ->wherenotin( 'itdp_profil_eks.id',$exceptcompanies)
                        ->get();
    foreach($companyhasproduct as $comp){
      array_push($incompanies,$comp->id);
    }
            

    // dd($exceptcompanies);
    // dd($request);
      $companyall = DB::table('itdp_profil_eks')
          ->leftjoin('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
          ->select('itdp_profil_eks.id','itdp_profil_eks.company')
          ->where('itdp_company_users.status', 1)
          ->wherein('itdp_profil_eks.id',$incompanies);
          // ->wherenotin( 'itdp_profil_eks.id',$exceptcompanies);

      if (isset($request->search)) {
          $search = $request->search;
          $companyall->where(function ($query) use ($search) {
              $query->where('itdp_profil_eks.company', 'ilike', '%' . $search . '%');
          });
      } else if (isset($request->code)) {
          $companyall->where('itdp_profil_eks.id', $request->code);
      } else {
          $companyall->orderby('itdp_profil_eks.company', 'asc')
                      ->limit(10);
      }
      // echo $final_query->toSql();die();
      return response()->json($companyall->get());
  }

  public function destroy(Request $request){
    date_default_timezone_set('Asia/Jakarta');
    $today = date("Y-m-d h:i:s");
    DB::table('banner')->where('id', $request->id)->update(['deleted_at'=>$today]);
    // $msg = ["status"=>"success"];
    // echo json_encode($msg);
    
    return redirect('master-banner')->with('error','Success Delete Data');
    
  }

  public function addcompanylain(Request $request){
    $datenow = date("Y-m-d H:i:s");
      $cekada = DB::select("select * from banner_detail where id_banner='".(int)$request->id."' and id_eks='".(int)$request->id_perusahaan."'");
      if(count($cekada) == 0){
          $storedetail = Banner_Detail::insert([
                  'id_banner' => (int)$request->id_banner,
                  'id_eks' => (int)$request->id_perusahaan,
                  'created_at' => $datenow,
                  'jenis_detail' => 2
                  ]);
      }
  }

  public function destroycompanylain(Request $request){
    // dd($request);
    date_default_timezone_set('Asia/Jakarta');
    $today = date("Y-m-d h:i:s");
    DB::table('banner_detail')->where('id_banner', $request->id_banner)->where('id_eks', $request->id_perusahaan)->delete();
    // $msg = ["status"=>"success"];
    // echo json_encode($msg);
    
    // return redirect('master-banner')->with('error','Success Delete Data');
    
  }

  public function destroycompanylain2(Request $request){
    // dd($request);
    date_default_timezone_set('Asia/Jakarta');
    $today = date("Y-m-d h:i:s");
    DB::table('banner_detail')->where('id_banner', $request->id_banner)->where('id_eks', $request->id_perusahaan)->delete();
    // $msg = ["status"=>"success"];
    // echo json_encode($msg);
    
    // return redirect('master-banner')->with('error','Success Delete Data');
    
  }


}
