<?php

namespace App\Http\Controllers\ActivitySupplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Session;
use Auth;
use Mail;

class ActivitySupplierController extends Controller
{

	public function __construct(){

  }

  public function index(){
    $pageTitle = 'Activity Supplier';

    if(isset(Auth::user()->id)){
      if(Auth::user()->id_group == 1)
        return view('ActivitySupplier.index',compact('pageTitle'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function getData()
  {
    $activity = DB::table('itdp_company_users as parent')
              ->select('parent.id','parent.email','detail.company','detail.status_email',DB::raw('(select date from log_user where id_user  =   parent.id order by date DESC limit 1) as date'))
              ->join('itdp_profil_eks as detail','detail.id','parent.id_profil')
              ->where('id_role',2)
              ->limit(10)
              ->orderBy('date','ASC')->get();

    return \Yajra\DataTables\DataTables::of($activity)
        ->addColumn('last_login', function($data){

          if(!empty($data->date)){
            $datenow = date_create(date('Y-m-d'));
            $datestart = date_create($data->date);
            $selisih = date_diff($datenow, $datestart);
          }

          return ($data->date) ? '<center><span class="btn btn-sm btn-success">'.$selisih->format("%a days ago").'</span></center>' : '<center><span class="btn btn-sm btn-warning">BELUM LOGIN</span></center>';
        })
        // ->addColumn('status', function($data){
        //     if($data->status_email == 1){
        //       $status_email = '<center><span class="btn btn-sm status-btn-warning">PERINGATAN</span></center>';
        //     }else{
        //       $status_email = '<center><span class="btn btn-sm btn-success">OK</span></center>';
        //     }

        //     return $status_email;
        // })
        ->addColumn('action', function ($data) {
          $p = '<center><div class="btn-group">';
          $p .= '<a href="'.route('activity.view', $data->id).'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;';
          if($data->status_email == null){
          $p .=  '<button onclick="InformasiEmailPeringatan('.$data->id.')" class="btn btn-sm btn-success" title="Email Peringatan"><i class="fa fa-send"></i></button>&nbsp;';
          }elseif($data->status_email == 1){
          $p .=  '<button onclick="InformasiEmailBanned('.$data->id.')" class="btn btn-sm btn-danger" title="Email Banned"><i class="fa fa-send"></i></button>&nbsp;';
          }
          return $p.'</div></center>';
        })
        ->addIndexColumn()
        ->rawColumns(['action','last_login'])  
        ->make(true);
  }

  public function view($id)
  {
    $pageTitle = "Activity Supplier";
    $data = DB::table('itdp_company_users as parent')
          ->join('itdp_profil_eks as detail','detail.id','parent.id_profil')
          ->where('parent.id',$id)
          ->first();
    if(isset(Auth::user()->id)){
      if(Auth::user()->id_group == 1)
        return view('ActivitySupplier.view',compact('data','pageTitle'));
      else
        return redirect('/home');
    } else {
      return redirect('/');
    }
  }

  public function emailPeringatan($id)
  {
    $user = DB::table('itdp_company_users as parent')
          ->select('parent.id','parent.username','parent.email','detail.company','detail.id as id_profil')
          ->join('itdp_profil_eks as detail','detail.id','parent.id_profil')
          ->where('parent.id',$id)
          ->first();

    $log = DB::table('log_user')->where('id_user',$id)->orderBy('date','DESC')->first();
    $datenow = date_create(date('Y-m-d'));
    $datestart = date_create($log->date);
    $selisih = date_diff($datestart,$datenow);

    $countDate = ($log->date) ? $selisih->format("%a") : '';
    $data = [
      'id' => $id,
      'username' => $user->username,
      'company' => strtoupper($user->company),
      'email' => $user->email,
      'user' => 'exporter',
      'type' => 'Indonesian Exporter',
      'pesan' => 'Terakhir Login '.$countDate.' hari yang lalu, jika dalam beberapa hari kedepan tidak melakukan aktifitas, maka akun anda akan dicabut dari inaexport'];

    Mail::send('UM.user.email-notif', $data, function ($mail) use ($data) {
      $mail->to($data['email'], $data['username']);
      $mail->subject('Notifikasi Peringatan Akun');
    });

    DB::table('itdp_profil_eks')->where('id', $user->id_profil)->update(['status_email'=>1]);
    if(isset(Auth::user()->id)){
      if(Auth::user()->id_group == 1){
        return redirect()->back();
      }else{
        return redirect('/home');
      }
    } else {
      return redirect('/');
    }
  }

  public function emailBanned($id)
  {
    $user = DB::table('itdp_company_users as parent')
          ->select('parent.id','parent.username','parent.email','detail.company','parent.id_profil')
          ->join('itdp_profil_eks as detail','detail.id','parent.id_profil')
          ->where('parent.id',$id)
          ->first();

    $log = DB::table('log_user')->where('id_user',$id)->orderBy('date','DESC')->first();
    $datenow = date_create(date('Y-m-d'));
    $datestart = date_create($log->date);
    $selisih = date_diff($datestart,$datenow);

    $countDate = ($log->date) ? $selisih->format("%a") : '';
    $data = [
      'id' => $id,
      'username' => $user->username,
      'company' => strtoupper($user->company),
      'email' => $user->email,
      'user' => 'exporter',
      'type' => 'Indonesian Exporter',
      'pesan' => 'Akibat aktifitas anda terlalu lama vakum di inaexport, maka mulai hari ini akun anda dihapus dari inaexport.id'];

    Mail::send('UM.user.email-notif', $data, function ($mail) use ($data) {
      $mail->to($data['email'], $data['username']);
      $mail->subject('Notifikasi Peringatan Akun');
    });
    DB::table('itdp_company_users')->where('id', $id)->delete();
    DB::table('itdp_profil_eks')->where('id', $user->id_profil)->delete();
    if(isset(Auth::user()->id)){
      if(Auth::user()->id_group == 1){
        return redirect()->back();
      }else{
        return redirect('/home');
      }
    } else {
      return redirect('/');
    }
  }

}