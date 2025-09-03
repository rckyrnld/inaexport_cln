<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;
use Carbon\Carbon;

class TrainingControllerEksportir extends Controller
{

		public function __construct(){
      // $this->middleware('auth');
    }

	  public function index(){
	  	$pageTitle = 'Training';
		return view('training.eksportir.view', compact('pageTitle'));
   //    	$pageTitle = 'Training';
			// $data = DB::table('training_admin')->where('status', 1)->paginate(5);
			// $id_user = Auth::guard('eksmp')->user()->id;
			// $id = DB::table('itdp_company_users as icu')
			// ->selectRaw('ipe.id')
			// ->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			// ->where('icu.id', $id_user)
			// ->first();
   //    	return view('training.eksportir.index', compact('pageTitle','data','id'));
    }

    public function create(){
      $pageTitle = 'Training';
      $page = 'create';
      return view('training.create', compact('page','pageTitle'));
    }

	public function join(Request $req){
		$id_user = $req->id_user;
		$id_training = $req->id_training_admin; 
		$data = DB::table('itdp_company_users as icu')
		->selectRaw('ipe.id, ipe.company')
		->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
		->where('icu.id', $id_user)
		->first();

		$cek = DB::table('training_join')->where('id_profil_eks', $data->id)
			->where('id_training_admin', $id_training)
			->first();
		if($cek){
			$return = 'Failed';
		} else {
			$return = 'Success';
			DB::table('training_join')->insert([
	        	'id_training_admin' => $id_training,
				'id_profil_eks' => $data->id,
				'date_join' => date('Y-m-d H:i:s'),
				'status' => 0
	      	]);

			DB::table('notif')->insert([
			    'dari_id' => $id_user,
			    'untuk_id' => 1,
			    'keterangan' => '<b>'.$data->company.'</b> Request To Join Training',
			    'waktu' => date('Y-m-d H:i:s'),
				'url_terkait' => 'admin/training/view',
				'status_baca' => 0,
				'id_terkait' => $id_training,
	        	'to_role' => 1
	      	]);
		}


      	return json_encode($return);
	}

    public function getData(){
		$tick = DB::table('training_admin as ts')->orderby('start_date', 'DESC')->get();

      return \Yajra\DataTables\DataTables::of($tick)
          ->addIndexColumn()
          ->addColumn('start_date', function($data){
				// $date = date("d-m-Y", strtotime($data->start_date));
				// $date2 = date("d-m-Y", strtotime($data->end_date));
				$date = Carbon::parse($data->start_date)->format('d M Y');
				$date2 = Carbon::parse($data->end_date)->format('d M Y');
				return ''.$date.' - '.$date2.'';
			})
          ->addColumn('duration', function($data){
             	return ''.$data->duration.' '.$data->param.'';
			})
          ->addColumn('training_en', function($data){
             	return '<div align="left">'.$data->training_en.'</div>';
			})
          ->addColumn('topic_en', function($data){
             	return '<div align="left">'.$data->topic_en.'</div>';
			})
          ->addColumn('location_en', function($data){
             	return '<div align="left">'.$data->location_en.'</div>';
			})
          ->addColumn('action', function ($val) {
          		$data = getContactPerson($val->id, 'training');
          		return '<center>
                  <button onclick="contact_person(\''.$data.'\','.$val->id.')" class="btn btn-sm btn-info text-white" title="View">&nbsp;<i class="fa fa-eye"></i>&nbsp;</button>
                  </center>';
          })
          ->rawColumns(['action','training_en','topic_en','location_en'])
          ->make(true);
    }

		public function view(){
			$pageTitle = 'Training';
			return view('training.eksportir.view', compact('pageTitle'));
		}

		public function search(Request $request){
			$cari = $request->cari;

			$data = DB::table('training_admin')
			->where('training_in','ilike',"%".$cari."%")
			->paginate(10);

			$pageTitle = 'Training';

			$id_user = Auth::guard('eksmp')->user()->id;
			$id = DB::table('itdp_company_users as icu')
			->selectRaw('ipe.id')
			->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			->where('icu.id', $id_user)
			->first();

			return view('training.eksportir.index', compact('pageTitle','data','id'));
		}

}
