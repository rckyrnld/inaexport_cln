<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\ItdpAdminDn;
use App\Models\ItdpAdminLn;
use App\Models\ItdpAdminUser;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\ItdpContactEks;
use App\Models\ItdpProfilExp;
use Exception;
use Mail;
use QrCode;
use URL;
use Illuminate\Validation\Rule;

class VerifyuserController extends Controller
{
	public function index()
	{
		$pageTitle = "Indonesian Exporter";
		// dd(Auth::user());
		if (Auth::user()->id_group == 4 && Auth::user()->id_admin_dn != 0) {
			$prov = DB::table('itdp_admin_users AS a')
				->select('c.*')
				->join('itdp_admin_dn AS b', 'b.id', '=', 'a.id_admin_ln')
				->join('mst_province AS c', 'c.id', '=', 'b.id_country')
				->where('a.id', Auth::user()->id)
				->first();

			$data = DB::table('itdp_company_users AS a')
				->select('a.*', 'a.id as ida', 'a.status as status_a', 'b.*')
				->join('itdp_profil_eks AS b', 'b.id', '=', 'a.id_profil')
				->where('a.id_role', 2)
				->where('b.id_mst_province', $prov->id)
				->orderBy('a.id', 'desc')
				->get();

			$pageTitle = "Indonesian Exporter - " . $prov->province_in;
		} else {
			$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
		}

		return view('verifyuser.index', compact('pageTitle', 'data'));
	}

	public function indexMember()
	{
		$pageTitle = "List Member";
		$kondisi = "";
		// $member = DB::select("SELECT mst_province.*,( SELECT COUNT ( * ) FROM itdp_profil_eks WHERE itdp_profil_eks.id_mst_province = mst_province.id ) AS jumlah FROM itdp_profil_eks INNER JOIN mst_province ON itdp_profil_eks.id_mst_province = mst_province.id GROUP BY mst_province.id ORDER BY province_en asc ");
		$member = DB::table('itdp_company_users AS a')
			->select('c.province_en', 'c.province_in', DB::raw('COUNT(*) AS jumlah'))
			->join('itdp_profil_eks AS b', 'b.id', '=', 'a.id_profil')
			->join('mst_province AS c', 'c.id', '=', 'b.id_mst_province')
			// ->where('itdp_company_users.status', '1')
			->groupBy('c.province_en', 'c.province_in')
			->orderBy('c.province_in')
			->get();
		// dd($member);


		// $pageTitle = "Indonesian Exporter - ".$prov->province_in;

		return view('verifyuser.index-member', compact('pageTitle', 'member'));
	}

	public function index2()
	{

		$pageTitle = "Buyer";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
		return view('verifyuser.index2', compact('pageTitle', 'data'));
	}

	public function listactv($id)
	{
		$pageTitle = "Log Activity";
		return view('verifyuser.logactivity', compact('pageTitle', 'id'));
	}

	public function getimportir()
	{
		if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8) {


			// $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, b.company, b.postcode, b.phone, a.id_role, a.agree ,a.id as ida,a.status as status_a, a.verified_at as verified_at, c.country from itdp_company_users a, itdp_profil_imp b, mst_country c  where a.id_profil = b.id and id_role='3' order by a.id desc ");
			//   $pesan = DB::table('itdp_company_users')
			// 			->join('itdp_profil_imp', 'itdp_company_users.id_profil','itdp_profil_imp.id')
			// 			->join('mst_country','mst_country.id','itdp_profil_imp.id_mst_country')
			// 			->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_profil_imp.company, itdp_profil_imp.postcode, itdp_profil_imp.phone, itdp_company_users.id_role, itdp_company_users.agree ,itdp_company_users.id as ida,itdp_company_users.status as status_a, itdp_company_users.verified_at as verified_at, mst_country.country')
			// 			->where('id_role','3');
			$pesan = DB::select("SELECT ROW_NUMBER
						() OVER ( ORDER BY A.ID DESC ) AS ROW,
						A.email,
						b.company,
						b.postcode,
						b.phone,
						A.id_role,
						A.agree,
						A.ID AS ida,
						A.status AS status_a,
						A.verified_at AS verified_at,
						C.country 
					FROM
						itdp_company_users A 
					JOIN 
						itdp_profil_imp b ON A.id_profil = b.id
					LEFT JOIN
						mst_country C ON b.id_mst_country = c.id
					WHERE
					id_role = '3' 
					ORDER BY
						A.ID DESC");
		} else if (Auth::user()->id_group == 4) {
			$a = Auth::user()->id;
			if (Auth::user()->id_admin_dn == 0) {
				// luar
				$b = Auth::user()->id_admin_ln;
				$quer = DB::select("select * from  itdp_admin_ln where id='" . $b . "'");
				foreach ($quer as $t1) {
					$ic = $t1->country;
				}
				// echo $ic;die();
				// $pesan = DB::table('itdp_company_users')
				// 			->join('itdp_profil_imp', 'itdp_company_users.id_profil','itdp_profil_imp.id')
				// 			->join('mst_country','mst_country.id','itdp_profil_imp.id_mst_country')
				// 			->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_profil_imp.company, itdp_profil_imp.postcode, itdp_profil_imp.phone, itdp_company_users.id_role, itdp_company_users.agree ,itdp_company_users.id as ida,itdp_company_users.status as status_a, itdp_company_users.verified_at as verified_at')
				// 			->where('id_role','3')
				// 			->where('mst_country.id', $ic)
				// 			->where('itdp_profil_imp.id_mst_country', 'mst_country.id')
				// 			->where('itdp_company_users.id_profil','itdp_profil_imp.id');

				$pesan = DB::select("SELECT ROW_NUMBER
					() OVER ( ORDER BY A.ID DESC ) AS ROW,
					A.email,
					b.company,
					b.postcode,
					b.phone,
					A.id_role,
					A.agree,
					A.ID AS ida,
					A.status AS status_a,
					A.verified_at AS verified_at,
					C.country 
				FROM
					itdp_company_users A 
				JOIN 
					itdp_profil_imp b ON A.id_profil = b.id
				LEFT JOIN
					mst_country C ON b.id_mst_country = c.id
				WHERE
					C.ID = '" . $ic . "' 
					AND b.id_mst_country = C.ID 
					AND A.id_profil = b.ID 
					AND id_role = '3' 
				ORDER BY
					A.ID DESC");
			} else {
				//dalam

				// $pesan = DB::table('itdp_company_users')
				// 			->join('itdp_profil_imp', 'itdp_company_users.id_profil','itdp_profil_imp.id')
				// 			->join('mst_country','mst_country.id','itdp_profil_imp.id_mst_country')
				// 			->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_profil_imp.company, itdp_profil_imp.postcode, itdp_profil_imp.phone, itdp_company_users.id_role, itdp_company_users.agree ,itdp_company_users.id as ida,itdp_company_users.status as status_a, itdp_company_users.verified_at as verified_at')
				// 			->where('id_role','3')
				// 			->where('itdp_company_users.id_profil','itdp_profil_imp.id')
				// 			->where('itdp_company_users.status','1');


				$pesan = DB::select("SELECT ROW_NUMBER
								() OVER ( ORDER BY A.ID DESC ) AS ROW,
								A.email,
								b.company,
								b.postcode,
								b.phone,
								A.id_role,
								A.agree,
								A.ID AS ida,
								A.status AS status_a,
								A.verified_at AS verified_at,
								C.country 
							FROM
								itdp_company_users A 
							JOIN 
								itdp_profil_imp b ON A.id_profil = b.id
							LEFT JOIN
								mst_country C ON b.id_mst_country = c.id
							WHERE
								A.id_profil = b.ID 
								AND id_role = '3' 
								AND A.status = '1' 
							ORDER BY
								A.ID DESC");
			}
		}
		return DataTables::of($pesan)
			->addColumn('f1', function ($pesan) {
				return '<div align="left">' . $pesan->company . '</div>';
			})
			->addColumn('f2', function ($pesan) {
				return $pesan->email;
			})
			->addColumn('f3', function ($pesan) {
				return $pesan->postcode;
			})
			->addColumn('f4', function ($pesan) {
				return $pesan->phone;
			})
			->addColumn('f5', function ($pesan) {
				$cariac = DB::select("select * from log_user where id_user='" . $pesan->ida . "' and id_role='" . $pesan->id_role . "' order by id_log desc limit 1");
				if (count($cariac) == 0) {
					return '<center><span class="badge bg-danger" style="color: #fff;">No Action <span/></center>';
				} else {
					foreach ($cariac as $cc) {
						if ($cc->keterangan == null) {
							$kt = "Login";
						} else {

							$kt = $cc->keterangan;
						}

						return '<a target="_BLANK" href="' . url('listactv/' . $pesan->ida) . '">' . $cc->date . "(" . $cc->waktu . ") " . $kt . '</a>';
					}
				}
			})
			->addColumn('f6', function ($pesan) {
				if ($pesan->agree == 1) {
					return "<center><span class='badge bg-success' style='color: #fff;'>Yes</span></center>";
				} else {
					return "<center><span class='badge bg-danger' style='color: #fff;'>No</span></center>";
				}
			})

			->addColumn('f7', function ($pesan) {
				if ($pesan->status_a == 1) {
					return "<center><span class='badge bg-success' style='color: #fff;'>Verified</span></center>";
				} else if ($pesan->status_a == 2) {
					return "<center><span class='badge bg-danger' style='color: #fff;'>Not Verified</span></center>";
				} else {
					return "<center><span class='badge bg-warning' style='color: #fff;'>Wait Administrator</span></center>";
				}
			})

			->addColumn('country', function ($pesan) {
				return $pesan->country;
			})

			->addColumn('f8', function ($pesan) {
				if (isset($pesan->verified_at)) {
					$time = strtotime($pesan->verified_at);
					$newformat = date('d-m-Y', $time);
					return $newformat;
				} else {
					return '-';
				}
			})

			->addColumn('action', function ($pesan) {

				if (Auth::user()->id_group == 4 && (Auth::user()->id_admin_ln == null || Auth::user()->id_admin_ln == 0)) {
					return '<a href="' . url('profil2/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit text-white"></i></a>';
				} else {
					if ($pesan->status_a == 1 || $pesan->status_a == 2) {
						return '<a href="' . url('profil2/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit text-white"></i></a>
					<a Onclick="return ConfirmDelete();" href="' . url('hapusimportir/' . $pesan->ida) . '" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a>
					<a href="' . url('resetimportir/' . $pesan->ida) . '" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
					';
					} else {
						return '<a href="' . url('profil2/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-success" title="Verify"><i class="fa fa-check text-white"></i></a>
					<a Onclick="return ConfirmDelete();" href="' . url('hapusimportir/' . $pesan->ida) . '" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a>
					<a href="' . url('resetimportir/' . $pesan->ida) . '" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
					';
					}
				}
			})
			->rawColumns(['action', 'f6', 'f7', 'f1', 'f5'])
			->make(true);
	}

	// public function geteksportir()
	// {
	// 	if(Auth::user()->id_group == 1) {
	// 	$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone, a.verified_at as verified_at from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
	// 	}
	// 	else if(Auth::user()->id_group == 4){
	// 		$a = Auth::user()->id;

	// 		if(Auth::user()->id_admin_dn == 0){
	// 			// luar
	// 			$b = Auth::user()->id_admin_ln;

	// 			$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone, a.verified_at as verified_at from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' and a.status = '1'  order by a.id desc ");

	// 		}else{
	// 			//dalam
	// 			$b = Auth::user()->id_admin_dn;
	// 			$quer = DB::select("select * from  itdp_admin_dn where id='".$b."'");
	// 			foreach($quer as $t1){ $ic = $t1->id_country; }
	// 			// echo $ic;die();
	// 			$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone, a.verified_at as verified_at from itdp_company_users a, itdp_profil_eks b where b.id_mst_province = '".$ic."' and a.id_profil = b.id and id_role='2' order by a.id desc ");


	// 		}

	// 	}
	//  	return DataTables::of($pesan)
	//         ->addColumn('f1', function ($pesan) {
	// 			 return '<div align="left">'.$pesan->company.'</div>';
	//         })
	// 		->addColumn('f2', function ($pesan) {
	// 			 return $pesan->email;
	//         })
	// 		->addColumn('f3', function ($pesan) {
	// 			 return $pesan->postcode;
	//         })
	// 		->addColumn('f4', function ($pesan) {
	// 			 return $pesan->phone;
	//         })
	// 		->addColumn('f5', function ($pesan) {
	// 			 $cariac = DB::select("select * from log_user where id_user='".$pesan->ida."' and id_role='".$pesan->id_role."' order by id_log desc limit 1");
	// 			 if(count($cariac) == 0){
	// 				return "<font color='red'>No Action</font>";
	// 			 }else{
	// 				 foreach($cariac as $cc){
	// 					 if($cc->keterangan == null){
	// 						 $kt ="Login";
	// 					 }else{

	// 						$kt = $cc->keterangan;
	// 					 }

	// 					 return '<a target="_BLANK" href="'.url('listactv/'.$pesan->ida).'">'.$cc->date."(".$cc->waktu.") ".$kt.'</a>';
	// 				 }
	// 			 }
	//         })
	// 		->addColumn('f6', function ($pesan) {
	// 			 if($pesan->agree == 1){ 
	// 			 return "<center><font color='green'>Yes</font></center>";
	// 			 }else{ 
	// 			 return "<center><font color='red'>No</font></center>";
	// 			 }
	//         })
	// 		->addColumn('f7', function ($pesan) {
	// 			if($pesan->status_a == 1){ 
	// 			return "<center><font color='green'>Verified</font></center>";
	// 			} else if($pesan->status_a == 2){ 
	// 			return "<center><font color='red'>Not Verified</font></center>";
	// 			}else{ 
	// 			return "<center><font color='orange'>Wait Administrator</font></center>";
	// 			}

	//         })
	//         ->addColumn('f8', function ($pesan) {
	//         	if (isset($pesan->verified_at)) {
	//         		$time = strtotime($pesan->verified_at);
	//                 $newformat = date('d-m-Y',$time);
	//                 return $newformat;
	//         	} else {
	//                 return '-';
	//         	}
	//      	})
	//         ->addColumn('action', function ($pesan) {

	// 			if(Auth::user()->id_group == 4){
	// 			return '<a href="'.url('profil/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>';

	// 			}else{

	//             if($pesan->status_a == 1 || $pesan->status_a == 2){ 
	// 			return '<a href="'.url('profil/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>
	// 			<a Onclick="return ConfirmDelete();" href="'.url('hapuseksportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
	// 			<a href="'.url('reseteksportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
	// 			';
	// 			}else{
	// 			return '<a href="'.url('profil/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success" title="Verify"><i class="fa fa-check text-white"></i></a>
	// 			<a Onclick="return ConfirmDelete();" href="'.url('hapuseksportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
	// 			<a href="'.url('reseteksportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
	// 			';
	// 			}

	//             }


	//         })
	// 		->rawColumns(['action','f6','f7','f1','f5'])
	//         ->make(true);
	// }

	public function geteksportir(Request $request)
	{
		// Admin or Admin Data
		if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8) {
			if (isset($request->filternya)) {
				if ($request->filternya == '1') {
					// yang belum di verifikasi
					$pesan = DB::table("itdp_profil_eks")
						->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
						->where('itdp_company_users.status', 0)
						->where("itdp_company_users.id_role", "2");
				} else if ($request->filternya == '2') {
					// yang sudah di verifikasi
					$pesan = DB::table("itdp_profil_eks")
						->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
						->where('itdp_company_users.status', 1)
						->where("itdp_company_users.id_role", "2");
				} else if ($request->filternya == '3') {
					// yang tidak di verifikasi
					$pesan = DB::table("itdp_profil_eks")
						->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
						->where('itdp_company_users.status', 2)
						->where("itdp_company_users.id_role", "2");
				} else if ($request->filternya == '4') {
					// yang ghoib
					$pesan = DB::table("itdp_profil_eks")
						->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
						->where('itdp_company_users.status', 3)
						->where("itdp_company_users.id_role", "2");
				} else {
					$pesan = DB::table("itdp_profil_eks")
						->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
						->where("itdp_company_users.id_role", "2");
				}
			} else {
				$pesan = DB::table("itdp_profil_eks")
					->join("itdp_company_users", "itdp_profil_eks.id", "itdp_company_users.id_profil")
					->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
					->selectraw("ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha")
					->where("itdp_company_users.id_role", "2");
			}

			// ->get();
			// dd($pesan);
			// $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.id as idb,b.company, b.postcode, b.phone, b.npwp, a.created_at as created_at from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
		} else if (Auth::user()->id_group == 4 || Auth::user()->id_group == 5) {
			$a = Auth::user()->id;

			if (Auth::user()->id_admin_dn == 0) {
				// luar
				$b = Auth::user()->id_admin_ln;
				$pesan = DB::table('itdp_company_users')
					->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
					->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
					->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
					->where('itdp_company_users.id_role', '2')
					->where('itdp_company_users.status', '1');
				// ->get();

				// $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a, b.id as idb,b.company, b.postcode, b.phone, b.npwp, a.created_at as created_at from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' and a.status = '1'  order by a.id desc ");

			} else {
				//dalam
				$b = Auth::user()->id_admin_dn;
				$quer = DB::select("select * from  itdp_admin_dn where id='" . $b . "'");
				foreach ($quer as $t1) {
					$ic = $t1->id_country;
				}

				if (isset($request->filternya)) {
					if ($request->filternya == '1') {
						$pesan = DB::table('itdp_company_users')
							->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
							->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
							->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
							->where('itdp_profil_eks.id_mst_province', $ic)
							->where('itdp_company_users.id_role', '2')
							->where('itdp_company_users.status', '0');
					}
					if ($request->filternya == '2') {
						$pesan = DB::table('itdp_company_users')
							->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
							->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
							->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
							->where('itdp_profil_eks.id_mst_province', $ic)
							->where('itdp_company_users.id_role', '2')
							->where('itdp_company_users.status', '1');
					}
					if ($request->filternya == '3') {
						$pesan = DB::table('itdp_company_users')
							->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
							->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
							->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
							->where('itdp_profil_eks.id_mst_province', $ic)
							->where('itdp_company_users.id_role', '2')
							->where('itdp_company_users.status', '2');
					}
					if ($request->filternya == '4') {
						$pesan = DB::table('itdp_company_users')
							->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
							->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
							->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
							->where('itdp_profil_eks.id_mst_province', $ic)
							->where('itdp_company_users.id_role', '2')
							->where('itdp_company_users.status', '3');
					}
					if ($request->filternya == '0') {
						$pesan = DB::table('itdp_company_users')
							->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
							->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
							->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
							->where('itdp_profil_eks.id_mst_province', $ic)
							->where('itdp_company_users.id_role', '2');
					}


					// ->where('itdp_company_users.status','1');
					// ->get();
					// $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a, b.id as idb,b.company, b.postcode, b.phone, b.npwp, a.created_at as created_at from itdp_company_users a, itdp_profil_eks b where b.id_mst_province = '".$ic."' and a.id_profil = b.id and id_role='2' order by a.id desc ");
				} else {
					$pesan = DB::table('itdp_company_users')
						->join('itdp_profil_eks', 'itdp_profil_eks.id', 'itdp_company_users.id_profil')
						->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
						->selectraw('ROW_NUMBER() OVER (ORDER BY itdp_company_users.id DESC) AS Row, itdp_company_users.email, itdp_company_users.id_role, itdp_company_users.agree, itdp_company_users.id as ida,itdp_company_users.status as status_a,itdp_profil_eks.id as idb,itdp_profil_eks.company, itdp_profil_eks.postcode, itdp_profil_eks.phone, itdp_profil_eks.npwp, itdp_company_users.created_at as created_at, eks_business_entity.nmbadanusaha')
						->where('itdp_profil_eks.id_mst_province', $ic)
						->where('itdp_company_users.id_role', '2');
				}
			}
		}
		// dd($pesan);
		// return Datatables::of($posts)
		// ->editColumn('title', '{!! str_limit($title, 60) !!}')
		// ->editColumn('name', function ($model) {
		//     return \HTML::mailto($model->email, $model->name);
		// })
		// ->make(true);
		return DataTables::of($pesan)
			->editColumn('company', function ($pesan) {
				return '<div align="left">' . $pesan->company . ', ' . $pesan->nmbadanusaha . '</div>';
			})
			->editColumn('email', function ($pesan) {
				return '<div align="left">' . $pesan->email . '</div>';
			})
			->addColumn('name', function ($pesan) {
				$namapicnya = '';
				$no = 0;
				$datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks', $pesan->idb)->get();
				if (count($datapic) > 0) {
					foreach ($datapic as $namapic) {
						if ($no == 0) {
							$namapicnya .=  $namapic->name;
						} else {
							$namapicnya .= ', ' . $namapic->name;
						}
						$no++;
					}
				}
				return '<div align="left">' . $namapicnya . '</div>';
			})
			->addColumn('phone', function ($pesan) {
				$telppicnya = '';
				$no2 = 0;

				$datapic2 = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks', $pesan->idb)->get();
				if (count($datapic2) > 0) {
					foreach ($datapic2 as $telppic) {
						if ($no2 == 0) {
							$telppicnya .=  $telppic->phone;
						} else {
							$telppicnya .= ', ' . $telppic->phone;
						}
						$no2++;
					}
				}
				return '<div align="left">' . $telppicnya . '</div>';
			})
			->editColumn('created_at', function ($pesan) {
				if ($pesan->created_at != null) {
					return date('d-m-Y', strtotime($pesan->created_at));
				} else {
					return $pesan->created_at;
				}
			})
			->addColumn('keterangan', function ($pesan) {
				$cariac = DB::select("select * from log_user where id_user='" . $pesan->ida . "' and id_role='" . $pesan->id_role . "' order by id_log desc limit 1");
				if (count($cariac) == 0) {
					return '<center><span class="badge bg-danger" style="color: #FFFFFF; border-radius: 6px; border-width: 0;">No Action <span/></center>';
				} else {
					foreach ($cariac as $cc) {
						if ($cc->keterangan == null) {
							$kt = "Login";
						} else {

							$kt = $cc->keterangan;
						}

						return '<div<a target="_BLANK" href="' . url('listactv/' . $pesan->ida) . '">' . $cc->date . "(" . $cc->waktu . ") " . $kt . '</a>';
					}
				}
			})
			->addColumn('npwp', function ($pesan) {
				return '<div align="left">' . $pesan->npwp . '</div>';
			})
			->addColumn('action', function ($pesan) {

				if (Auth::user()->id_group == 4 && (Auth::user()->id_admin_dn == null || Auth::user()->id_admin_dn == 0)) {
					return '<a href="' . url('profil/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit text-white"></i></a>';
				} else {

					if ($pesan->status_a == 1) {
						return '<a href="' . url('profil/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit text-white"></i></a>
					<a Onclick="return ConfirmDelete();" href="' . url('hapuseksportir/' . $pesan->ida) . '" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
					<a href="' . url('reseteksportir/' . $pesan->ida) . '" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
					';
					} else {
						return '<a href="' . url('profil/' . $pesan->id_role . '/' . $pesan->ida) . '" class="btn btn-sm btn-success" title="Verify"><i class="fa fa-check text-white"></i></a>
					<a Onclick="return ConfirmDelete();" href="' . url('hapuseksportir/' . $pesan->ida) . '" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
					<a href="' . url('reseteksportir/' . $pesan->ida) . '" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
					';
					}
				}
			})
			->addColumn('ceklis', function ($pesan) {
				return '<input type="checkbox" name="deletion[]" form="form-multidelete" value="' . Crypt::encryptString($pesan->ida) . '">';
			})
			->rawColumns(['action', 'company', 'email', 'name', 'phone', 'keterangan', 'npwp', 'ceklis'])
			->make(true);
	}

	public function getpw()
	{
		$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from itdp_admin_users where id_group IN (4,5) order by id desc");
		return DataTables::of($pesan)
			->addColumn('f1', function ($pesan) {
				return '<div align="left">' . $pesan->name . '</div>';
			})
			->addColumn('f2', function ($pesan) {
				return $pesan->email;
			})
			->addColumn('f3', function ($pesan) {
				return $pesan->website;
			})
			->addColumn('f6', function ($pesan) {
				if ($pesan->id_group == 4 || $pesan->id_admin_ln != 0) {
					return "<center>Overseas</center>";
				} else {
					return "<center>Domestic</center>";
				}
			})
			->addColumn('f7', function ($pesan) {
				return "<center>" . $pesan->type . "</center>";
			})
			->addColumn('action', function ($pesan) {


				return '<center>
				 
				<a class="btn btn-sm btn-info" href="' . url('viewperwakilan/' . $pesan->id) . '"  title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;
			    <a class="btn btn-sm btn-success" href="' . url('editperwakilan/' . $pesan->id) . '"  title="Edit"><i class="fa fa-edit"></i></a>
			    <a class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" href="' . url('hapusperwakilan/' . $pesan->id) . '"  title="Delete"><i class="fa fa-trash"></i></a>
			   
			   </center>';
			})
			->rawColumns(['action', 'f6', 'f7', 'f1'])
			->make(true);
	}


	public function type(Request $request)
	{
		$type = DB::table('mst_catper')
			->select('id', 'type')
			->orderby('type', 'asc');
		if (isset($request->q)) {
			//          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
			$type->where('type', 'ILIKE', '%' . $request->q . '%'); //ini untuk carinya pake desc_eng
		} else if (isset($request->code)) {
			$type->where('type', $request->code);
		} else {
			$type->limit(10);
		}
		return response()->json($type->get());
	}

	public function index3()
	{
		//        dd("mantap");die();
		$pageTitle = "Representative";
		$data = DB::select("select * from itdp_admin_users where id_group in (4,5) order by id desc ");
		return view('verifyuser.index3', compact('pageTitle', 'data'))->with('success');
	}

	public function hapusimportir($id)
	{
		$delete = DB::select("delete from itdp_company_users where id='" . $id . "'");
		return redirect('verifyimportir')->with('error', 'Success Delete Data');
	}

	public function hapuseksportir($id)
	{
		$delete = DB::select("delete from itdp_company_users where id='" . $id . "'");
		return redirect('verifyuser')->with('error', 'Success Delete Data');
	}

	public function resetimportir($id)
	{
		$ei = DB::select("select * from itdp_company_users where id='" . $id . "'");

		foreach ($ei as $ie) {
			$d1 = $ie->id;
			$d2 = $ie->username;
			$d3 = $ie->email;
		}
		$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

		Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
			$mail->to($data['email'], $data['username']);
			$mail->subject('Forget Password');
		});


		return redirect('verifyimportir')->with('success', 'Ask User to Check Email');
	}

	public function reseteksportir($id)
	{
		$ei = DB::select("select * from itdp_company_users where id='" . $id . "'");

		foreach ($ei as $ie) {
			$d1 = $ie->id;
			$d2 = $ie->username;
			$d3 = $ie->email;
		}
		$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

		Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
			$mail->to($data['email'], $data['username']);
			$mail->subject('Forget Password');
		});


		return redirect('verifyuser')->with('success', 'Ask User to Check Email');
	}

	public function hapusperwakilan($id)
	{
		$delete = DB::select("delete from itdp_admin_users where id='" . $id . "'");
		return redirect('profilperwakilan')->with('error', 'Success Delete Data');
	}

	public function bacanotif($id)
	{
		$update = DB::select("update notif set status_baca='1' where id_notif='" . $id . "'");
	}

	public function tambahperwakilan()
	{
		$pageTitle = "Add Representative";
		$country = DB::select("select id,mst_country_group_id,country from mst_country order by country asc ");
		$benua = DB::select("select * from mst_group_country order by group_country asc");
		$city = DB::select("select * from mst_city order by city asc");
		return view('verifyuser.tambahperwakilan', compact('pageTitle', 'country', 'benua', 'city'));
	}

	public function viewperwakilan($id)
	{
		$pageTitle = "View Representative";
		$country = DB::select("select id,mst_country_group_id,country from mst_country order by country asc ");
		$benua = DB::select("select * from mst_group_country order by group_country asc");
		$city = DB::select("select * from mst_city order by city asc");
		return view('verifyuser.viewperwakilan', compact('pageTitle', 'id', 'benua', 'country', 'city'));
	}

	public function editperwakilan($id)
	{
		$pageTitle = "Edit Representative";
		$mst = DB::select("select * from mst_province order by province_en asc");
		$benua = DB::select("select * from mst_group_country order by group_country asc");

		$city = '';
		$country = '';
		$qe = DB::select("select * from itdp_admin_users where id='" . $id . "'");
		foreach ($qe as $eq) {
			if ($eq->type == "DINAS PERDAGANGAN") {
				$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='" . $id . "' ");
			} else {
				$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_ln b where a.id_admin_ln = b.id and a.id='" . $id . "' ");
			}
			foreach ($tq as $qt) {
				if ($eq->type == "DINAS PERDAGANGAN") {
					$city = DB::select("select * from mst_province where id=$qt->id_country order by province_in asc");
					$country = DB::select("select id,mst_country_group_id,country from mst_country order by country asc");
				} else {
					$city = DB::select("select * from mst_city where id_mst_country=$qt->country order by city asc");
					$country = DB::select("select id,mst_country_group_id,country from mst_country where mst_country_group_id=$qt->id_country order by country asc");
				}
			}
		}
		return view('verifyuser.editperwakilan', compact('pageTitle', 'id', 'country', 'benua', 'mst', 'city'));
	}

	public function editperwakilans($id)
	{
		$pageTitle = "Representative";

		return view('verifyuser.editperwakilans', compact('pageTitle', 'id'));
	}

	public function detailverify($id)
	{
		$pageTitle = 'Detail User';
		$data = DB::table('itdp_company_users')
			->where('id', '=', $id)
			->get();
		return view('verifyuser.edit', compact('pageTitle', 'data'));
	}

	public function saveverify($id)
	{
		$update = DB::select("update itdp_company_users set status='1' where id='" . $id . "'");
		return redirect('verifyuser');
	}

	public function profil($id, $id2)
	{
		if (Auth::guard('eksmp')->user() || Auth::user()) {
			if ($id == 2) {
				$pageTitle = "Exporter Profile";
				$tx = "Exporter";
			} else if ($id == 3) {
				$pageTitle = "Importer Profile";
				$tx = "Importer";
			} else {
				$pageTitle = "Profile ";
				$tx = "";
			}
			$ida = $id;
			$idb = $id2;

			return view('verifyuser.profil', compact('pageTitle', 'tx', 'ida', 'idb'));
		} else {
			return redirect('/login');
		}
	}

	public function profil_front($id, $id2)
	{
		$pageTitle = "Exporter Profile";
		$tx = "Exporter";
		$ida = $id;
		$idb = $id2;
		return view('verifyuser.profil_front', compact('pageTitle', 'tx', 'ida', 'idb'));
	}

	public function profilb()
	{
		if (Auth::guard('eksmp')->user() || Auth::user()) {
			$id = Auth::guard('eksmp')->user()->id_role;
			$id2 = Auth::guard('eksmp')->user()->id;
			if ($id == 2) {
				$pageTitle = "Exporter Profile";
				$tx = "Exporter";
			} else if ($id == 3) {
				$pageTitle = "Importer Profile";
				$tx = "Importer";
			} else {
				$pageTitle = "Profile ";
				$tx = "";
			}
			$ida = $id;
			$idb = $id2;
			$user = DB::table('itdp_contact_eks')
				->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
				->get();
			$url = '/eksportir/contact_save';

			return view('verifyuser.profilb', compact('user', 'pageTitle', 'tx', 'ida', 'idb', 'url'));
		} else {
			return redirect('/login');
		}
	}

	public function profildocb()
	{
		if (Auth::guard('eksmp')->user() || Auth::user()) {
			$id = Auth::guard('eksmp')->user()->id_role;
			$id2 = Auth::guard('eksmp')->user()->id;
			if ($id == 2) {
				$pageTitle = "Exporter Document";
				$tx = "Exporter";
			} else if ($id == 3) {
				$pageTitle = "Importer Document";
				$tx = "Importer";
			} else {
				$pageTitle = "Profile ";
				$tx = "";
			}
			$ida = $id;
			$idb = $id2;

			return view('verifyuser.profildoc', compact('pageTitle', 'tx', 'ida', 'idb'));
		} else {
			return redirect('/login');
		}
	}

	public function profil2($id, $id2)
	{
		if ($id == 2) {
			$pageTitle = "Exporter Profile";
			$tx = "Eksportir";
		} else if ($id == 3) {
			$pageTitle = "Buyer Profile";
			$tx = "Importir";
		} else {
			$pageTitle = "Profil ";
			$tx = "";
		}
		$ida = $id;
		$idb = $id2;
		return view('verifyuser.profil2', compact('pageTitle', 'tx', 'ida', 'idb'));
	}

	public function simpanperwakilan(Request $request)
	{
		DB::beginTransaction();

		try {
			// dd($request->all());
			$country = $request->country_id_arr;
			$each_country = implode(',', (array)$country);

			$data = [
				'email' => "",
				'email1' => $request->email,
				'username' => $request->username,
				'password' => $request->password,
				'main_messages' => "",
				'id' => 0,
			];

			//		dd($data);
			Mail::send('UM.user.sendpw', $data, function ($mail) use ($data) {
				$mail->to($data['email1'], $data['username']);
				$mail->subject('Admin Had Created and Set you as Representative');
			});

			//		$data22 = [
			//            'email' => $request->email,
			//            'email1' => "kementerianperdagangan.max@gmail.com",
			//            'username' => $request->username,
			//            'password' => $request->password,
			//            'main_messages' => "",
			//            'id' => 0
			//			];
			//		Mail::send('UM.user.sendpw2', $data22, function ($mail) use ($data22) {
			//        $mail->to($data22['email1'], $data22['username']);
			//        $mail->subject('You Had Created and Set Representative');
			//		});
			// echo "hello";die();
			if ($request->type == "DINAS PERDAGANGAN") {

				$insert1 = DB::select("
				insert into itdp_admin_dn (nama,id_country,email,web,telp,kepala,username,password,status) values
				('" . $request->nama . "','" . $request->province . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
				,'" . $request->kepala . "','" . $request->username . "','" . bcrypt($request->password) . "','" . $request->status . "')
				");
				$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_dn");
				foreach ($ambilmaxid as $rt) {
					$id1 = $rt->maxid;
				}
				$insert2 = DB::select("
				insert into itdp_admin_users (name,email,password,password_real,id_group,created_at,id_admin_dn,type,website) values
				('" . $request->username . "','" . $request->email . "','" . bcrypt($request->password) . "','-','5'
				,'" . Date('Y-m-d H:m:s') . "','" . $id1 . "','" . $request->type . "','" . $request->web . "')
				");
			} else {
				$carigroup = DB::select("select mst_country_group_id from mst_country where id='" . $request->country . "'");
				if (count($carigroup) == 0) {
					$ic = 0;
				} else {
					foreach ($carigroup as $cg) {
						$ic = $cg->mst_country_group_id;
					}
				}
				if ($request->has('main_country_id')) {
					$selected_country = $request->main_country_id;
				} else {
					$selected_country = $request->country;
				}
				$insert1 = DB::select("
				insert into itdp_admin_ln (nama,id_country,email,web,telp,kepala,username,password,status,country,city,country_tambahan) values
				('" . $request->nama . "','" . $ic . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
				,'" . $request->kepala . "','" . $request->username . "','" . bcrypt($request->password) . "','" . $request->status . "','" . $selected_country . "','" . $request->city . "','" . $each_country . "')
				");

				$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_ln");
				foreach ($ambilmaxid as $rt) {
					$id1 = $rt->maxid;
				}

				$insert2 = DB::select("
				insert into itdp_admin_users (name,email,password,password_real,id_group,created_at,id_admin_ln,type,website) values
				('" . $request->username . "','" . $request->email . "','" . bcrypt($request->password) . "','-','4'
				,'" . Date('Y-m-d H:m:s') . "','" . $id1 . "','" . $request->type . "','" . $request->web . "')
				");
			}
			DB::commit();
			return redirect('profilperwakilan')->with('success', 'Success Add Data!');
		} catch (\Exception $e) {

			DB::rollback();
			return $e->getMessage();
		}
	}

	public function updateperwakilan(Request $request)
	{
		DB::beginTransaction();

		try {
			// dd($request->all());

			$check_type = ItdpAdminUser::where('id', $request->ida)->first();
			if ($request->type == "DINAS PERDAGANGAN") {

				if ($check_type->id_admin_dn != 0) {
					// Jika sebelumnya memang Type nya  "DINAS PERDAGANGAN"
					if (empty($request->password) || $request->password == null) {
						$update1 = DB::select("
					update itdp_admin_dn set nama='" . $request->nama . "', id_country ='" . $request->province . "', email ='" . $request->email . "', web='" . $request->web . "'
					, telp='" . $request->phone . "', kepala='" . $request->kepala . "', username='" . $request->username . "', status='" . $request->status . "'
					where id='" . $request->idb . "'
					");

						$update2 = DB::select("
				update itdp_admin_users set 
					type='" . $request->type . "', 
					name='" . $request->username . "', 
					email ='" . $request->email . "', 
					id_group ='5', 
					website='" . $request->web . "'
				where id='" . $request->ida . "'
				");
					} else {
						$update1 = DB::select("
				update itdp_admin_dn set nama='" . $request->nama . "', id_country ='" . $request->province . "', email ='" . $request->email . "', web='" . $request->web . "'
				, telp='" . $request->phone . "', kepala='" . $request->kepala . "', username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->status . "'
				where id='" . $request->idb . "'
				");

						$update2 = DB::select("
				update itdp_admin_users set 
					type='" . $request->type . "', 
					name='" . $request->username . "', 
					email ='" . $request->email . "', 
					id_group ='5', 
					password ='" . bcrypt($request->password) . "',
					website='" . $request->web . "'
				where id='" . $request->ida . "'
				");
					}
				} else {
					// Jika sebelunya Type nya SELAIN "DINAS PERDAGANGAN"
					if (empty($request->password) || $request->password == null) {
						$last_password = ItdpAdminLn::where('id', $request->idb)->first()->password;
						$insert1 = DB::select("
						insert into itdp_admin_dn (nama,id_country,email,web,telp,kepala,username,status, password) values
						('" . $request->nama . "','" . $request->province . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
						,'" . $request->kepala . "','" . $request->username . "','" . $request->status . "','" . $last_password . "')
						");


						// delete old data
						ItdpAdminLn::where('id', $request->idb)->delete();

						$id1 = '';
						$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_dn");
						foreach ($ambilmaxid as $rt) {
							$id1 = $rt->maxid;
						}

						$update2 = DB::select("
				update itdp_admin_users set 
				type='" . $request->type . "', 
				name='" . $request->username . "', 
				email ='" . $request->email . "', 
				website='" . $request->web . "',
				id_admin_ln='0',
				id_group ='5', 
				id_admin_dn='" . $id1 . "'
				where id='" . $request->ida . "'
				");
					} else {
						$insert1 = DB::select("
						insert into itdp_admin_dn (nama,id_country,email,web,telp,kepala,username,password,status) values
						('" . $request->nama . "','" . $request->province . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
						,'" . $request->kepala . "','" . $request->username . "','" . bcrypt($request->password) . "','" . $request->status . "')
						");

						// delete old data
						ItdpAdminLn::where('id', $request->idb)->delete();

						$id1 = '';
						$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_dn");
						foreach ($ambilmaxid as $rt) {
							$id1 = $rt->maxid;
						}

						$update2 = DB::select("
				update itdp_admin_users set 
				type='" . $request->type . "', 
				name='" . $request->username . "', 
				email ='" . $request->email . "', 
				password ='" . bcrypt($request->password) . "', 
				website='" . $request->web . "',
				id_admin_ln='0',
				id_group ='5', 
				id_admin_dn='" . $id1 . "'
				where id='" . $request->ida . "'
				");
					}
				}

				DB::commit();
				return redirect('profilperwakilan')->with('success', 'Success Update Data!');
			} else {
				$country = $request->country_id_arr;
				$each_country = implode(',', (array)$country);
				$carigroup = DB::select("select mst_country_group_id from mst_country where id='" . $request->country . "'");
				if (count($carigroup) == 0) {
					$ic = 0;
				} else {
					foreach ($carigroup as $cg) {
						$ic = $cg->mst_country_group_id;
					}
				}


				if ($check_type->id_admin_ln != 0) {
					// Jika sebelumnya memang Type nya  SELAIN "DINAS PERDAGANGAN"
					if (empty($request->password) || $request->password == null) {
						

						$update1 = DB::select("
					update itdp_admin_ln set nama='" . $request->nama . "', id_country ='" . $ic . "', email ='" . $request->email . "', web='" . $request->web . "'
					, telp='" . $request->phone . "', kepala='" . $request->kepala . "', username='" . $request->username . "', status='" . $request->status . "', country='" . $request->country . "', 
					city='" . $request->city . "', country_tambahan='" . $each_country . "'
					where id='" . $request->idb . "'
					");

						$update2 = DB::select("
					update itdp_admin_users set type='" . $request->type . "', name='" . $request->username . "', email ='" . $request->email . "', website='" . $request->web . "', id_group='4'
					where id='" . $request->ida . "'
					");
					} else {
						$update1 = DB::select("
					update itdp_admin_ln set nama='" . $request->nama . "', id_country ='" . $ic . "', email ='" . $request->email . "', web='" . $request->web . "'
					, telp='" . $request->phone . "', kepala='" . $request->kepala . "', username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->status . "',
					country='" . $request->country . "', city='" . $request->city . "', country_tambahan='" . $each_country . "'
					where id='" . $request->idb . "'
					");

						$update2 = DB::select("
					update itdp_admin_users set type='" . $request->type . "', name='" . $request->username . "', email ='" . $request->email . "', password ='" . bcrypt($request->password) . "', website='" . $request->web . "', id_group='4'
					where id='" . $request->ida . "'
					");
					}
				} else {
					// Jika sebelumnya memang Type nya "DINAS PERDAGANGAN"
					if (empty($request->password) || $request->password == null) {
						$last_password = ItdpAdminDn::where('id', $request->idb)->first()->password;
						$insert1 = DB::select("
				insert into itdp_admin_ln (nama,id_country,email,web,telp,kepala,username,status,country,city,country_tambahan, password) values
				('" . $request->nama . "','" . $ic . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
				,'" . $request->kepala . "','" . $request->username . "','" . $request->status . "','" . $request->country . "','" . $request->city . "','" . $each_country . "','" . $last_password . "')
				");

						// delete old data
						ItdpAdminDn::where('id', $request->idb)->delete();

						$id1 = '';
						$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_ln");
						foreach ($ambilmaxid as $rt) {
							$id1 = $rt->maxid;
						}


						$update2 = DB::select("
					update itdp_admin_users set 
					type='" . $request->type . "', 
					name='" . $request->username . "', 
					email ='" . $request->email . "', 
					website='" . $request->web . "',
					id_admin_ln='" . $id1 . "',
					id_group ='4', 
					id_admin_dn='0'
					where id='" . $request->ida . "'
					");
					} else {
						$insert1 = DB::select("
				insert into itdp_admin_ln (nama,id_country,email,web,telp,kepala,username,password,status,country,city,country_tambahan) values
				('" . $request->nama . "','" . $ic . "','" . $request->email . "','" . $request->web . "','" . $request->phone . "'
				,'" . $request->kepala . "','" . $request->username . "','" . bcrypt($request->password) . "','" . $request->status . "','" . $request->country . "','" . $request->city . "','" . $each_country . "')
				");

						// delete old data
						ItdpAdminDn::where('id', $request->idb)->delete();

						$id1 = '';
						$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_ln");
						foreach ($ambilmaxid as $rt) {
							$id1 = $rt->maxid;
						}

						$update2 = DB::select("
					update itdp_admin_users set 
					type='" . $request->type . "', 
					name='" . $request->username . "', 
					email ='" . $request->email . "', 
					password ='" . bcrypt($request->password) . "', 
					website='" . $request->web . "',
					id_group ='4', 
					id_admin_ln='" . $id1 . "',
					id_admin_dn='0'
					where id='" . $request->ida . "'
					");
					}
				}
				DB::commit();
				return redirect('profilperwakilan')->with('success', 'Success Update Data!');
			}
		} catch (\Exception $e) {

			DB::rollback();
			return $e->getMessage();
		}
	}

	public function updateperwakilans(Request $request)
	{
		if ($request->types == "DINAS PERDAGANGAN") {
			if (empty($request->password) || $request->password == null) {
				$update1 = DB::select("
			update itdp_admin_dn set nama='" . $request->pejabat . "', id_country ='" . $request->country . "', email ='" . $request->email . "', web='" . $request->web . "'
			, telp='" . $request->phone . "', kepala='" . $request->username . "', username='" . $request->username . "', status='" . $request->status . "'
			where id='" . $request->idb . "'
			");

				$update2 = DB::select("
			update itdp_admin_users set type='" . $request->types . "', name='" . $request->username . "', email ='" . $request->email . "', website='" . $request->web . "'
			where id='" . $request->ida . "'
			");
			} else {
				$update1 = DB::select("
			update itdp_admin_dn set nama='" . $request->pejabat . "', id_country ='" . $request->country . "', email ='" . $request->email . "', web='" . $request->web . "'
			, telp='" . $request->phone . "', kepala='" . $request->username . "', username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->status . "'
			where id='" . $request->idb . "'
			");

				$update2 = DB::select("
			update itdp_admin_users set type='" . $request->types . "', name='" . $request->username . "', email ='" . $request->email . "', password ='" . bcrypt($request->password) . "', website='" . $request->web . "'
			where id='" . $request->ida . "'
			");
			}
		} else {
			// echo "b";die();
			if (empty($request->password) || $request->password == null) {

				$carigroup = DB::select("select mst_country_group_id from mst_country where id='" . $request->country . "'");
				if (count($carigroup) == 0) {
					$ic = 0;
				} else {
					foreach ($carigroup as $cg) {
						$ic = $cg->mst_country_group_id;
					}
				}
				$update1 = DB::select("
			update itdp_admin_ln set nama='" . $request->pejabat . "', id_country ='" . $ic . "', email ='" . $request->email . "', web='" . $request->web . "'
			, telp='" . $request->phone . "', kepala='" . $request->username . "', username='" . $request->username . "', status='" . $request->status . "', country='" . $request->country[$i] . "'
			where id='" . $request->idb . "'
			");

				$update2 = DB::select("
			update itdp_admin_users set type='" . $request->types . "', name='" . $request->username . "', email ='" . $request->email . "', website='" . $request->web . "'
			where id='" . $request->ida . "'
			");
			} else {
				$update1 = DB::select("
			update itdp_admin_ln set nama='" . $request->pejabat . "', id_country ='" . $request->country[$i] . "', email ='" . $request->email . "', web='" . $request->web . "'
			, telp='" . $request->phone . "', kepala='" . $request->username . "', username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->status . "'
			where id='" . $request->idb . "'
			");

				$update2 = DB::select("
			update itdp_admin_users set type='" . $request->types . "', name='" . $request->username . "', email ='" . $request->email . "', password ='" . bcrypt($request->password) . "', website='" . $request->web . "'
			where id='" . $request->ida . "'
			");
			}
		}
		return redirect('editperwakilans/' . $request->ida)->with('success', 'Success Update Data!');
	}
	public function simpan_profil(Request $request)
	{
		// DB::beginTransaction();


		// try {
		// dd($request->idu);
		$this->validate($request, [
			'email' => 'required|email|unique:itdp_company_users,email,' . $request->idu . ',id_profil,status,1,id_role,2',
			'staim' => 'required',
			'id_user' => 'required',
			'npwpfile' => 'mimes:jpg,jpeg,png,pdf',
            'tdpfile' => 'mimes:jpg,jpeg,png,pdf',
            'image_1' => 'mimes:jpg,jpeg,png',
		],
		[
			'tdpfile.mimes' => 'The Dokumen Nomor Induk Berusaha\'s type allowed only JPG, JPEG, PNG or PDF',
			'npwpfile.mimes' => 'The Dokumen NPWP\'s type allowed only JPG, JPEG, PNG or PDF',
			'image_1.mimes' => 'The Document Company Logo\'s type allowed only JPG, JPEG or PNG ',
		]);

		// untuk simpan profil dari admin
		date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		// dd($id_user_b);
		$ent = explode(",", $request->badanusaha);
		// dd($ent);
		// dd($ent);
		$destination = 'uploads\Profile\Eksportir\\' . $id_user;
		if ($request->hasFile('image_1')) {
			$file1 = $request->file('image_1');
			$nama_file1 = time() . '_' . $request->file('image_1')->getClientOriginalName();
			Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
			$updfoto = DB::table('itdp_company_users')->where('id', $id_user)->update([
				"foto_profil" => $nama_file1,
			]);
		}

		if (Auth::guard('eksmp')->user()) {
			//di edit indonesian exporter
			//ini yang masih mau di edit
			if (empty($request->file('doc'))) {
				$file = "";
			} else {
				$file = $request->file('doc')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('doc')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set doc='" . $file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('npwpfile'))) {
				$file = "";
			} else {
				$file = $request->file('npwpfile')->getClientOriginalName();
				$filename = pathinfo($file, PATHINFO_FILENAME);
				$extension = pathinfo($file, PATHINFO_EXTENSION);
				$new_file = $filename . '_' . round(microtime(true) * 1000) . '.' . $extension;

				$destinationPath = public_path() . "/eksportir";
				$request->file('npwpfile')->move($destinationPath, $new_file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadnpwp='" . $new_file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('tdpfile'))) {
				$file = "";
			} else {
				$file = $request->file('tdpfile')->getClientOriginalName();
				$filename = pathinfo($file, PATHINFO_FILENAME);
				$extension = pathinfo($file, PATHINFO_EXTENSION);
				$new_file = $filename . '_' . round(microtime(true) * 1000) . '.' . $extension;
				$destinationPath = public_path() . "/eksportir";
				$request->file('tdpfile')->move($destinationPath, $new_file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadtdp='" . $new_file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('siupfile'))) {
				$file = "";
			} else {
				$file = $request->file('siupfile')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('siupfile')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadsiup='" . $file . "' where id='" . $id_user_b . "'");
			}

			$date = date('Y-m-d H:i:s');
			$notif = DB::table('notif')->insert([
				'dari_nama' => getCompanyName(auth::guard('eksmp')->user()->id),
				'dari_id' => auth::guard('eksmp')->user()->id,
				'untuk_nama' => "Super Admin",
				'untuk_id' => '1',
				'keterangan' => 'Exporter "' . getExBadan(auth::guard('eksmp')->user()->id) . getCompanyName(auth::guard('eksmp')->user()->id) . '" Update The Company Data',
				'url_terkait' => 'profil/2',
				'status_baca' => 0,
				'waktu' => $date,
				'id_terkait' => $id_user,
				'to_role' => "1",
			]);

			$admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
			foreach ($admin_all as $aa) {
				$data = [
					'email' => $aa->email,
					'email1' => $aa->email,
					'username' => $aa->name,
					'company' => getCompanyName(auth::guard('eksmp')->user()->id),
					'id' => $id_user,
					'bu' => getExBadan(auth::guard('eksmp')->user()->id),
				];
				Mail::send('UM.user.emailexupload', $data, function ($mail) use ($data) {
					$mail->to($data['email1'], $data['username']);
					$mail->subject('Exporter Update their Profile');
				});
			}

			//UPDATE TAB 3
			if ($id_role == 2) {
				if ($request->npwp == "null") {
				} else {

					$updatetab2 = ItdpProfilExp::whereId($id_user_b)->update([
						'npwp' => $request->npwp,
						'tdp' => $request->tanda_daftar,
						'siup' => $request->siup,
						'upduserid' => $request->situ,
						'id_eks_business_size' => $request->scoope,
						'id_business_role_id' => $request->tob,
						'year_establish' => $request->year_establish,
						'employe' => $request->employee
					]);

					// $updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "',
					//  	tdp='" . $request->tanda_daftar . "',
					// 	siup='" . $request->siup . "',
					// 	upduserid='" . $request->situ . "' , 
					// 	id_eks_business_size='" . $request->scoope . "', 
					// 	id_business_role_id='" . $request->tob . "', 
					// 	year_establish='" . $request->year_establish . "', 
					// 	employe='" . $request->employee . "'where id='" . $id_user_b . "'");
				}
			}


			//            if($request->file('doc') and $request->file('npwpfile') and $request->file('tdpfile') and $request->file('siupfile')){
			//
			//            }
		}

		//UPDATE TAB 1
		if ($request->password == null) {

			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "', status='" . $request->staim . "' where id='" . $request->id_user . "' ");
		} else {

			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', email='" . $request->email . "', status='" . $request->staim . "' where id='" . $request->id_user . "' ");
		}



		if ($request->staim == 1) {
			if (auth::user()) {
				$date = date('Y-m-d H:i:s');
				$updatetab1b = DB::select("update itdp_company_users set verified_by='" . auth::user()->id . "',verified_at='" . $date . "'   where id='" . $id_user . "' ");

				$data3 = ['username' => $request->username, 'id2' => 0, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'by' => auth::user()->name];
				Mail::send('UM.user.emailverif1', $data3, function ($mail) use ($data3) {
					$mail->to($data3['email'], $data3['username']);
					$mail->subject('Your Account Was Verifed');
				});

				$notif = DB::table('notif')->insert([
					'dari_nama' => auth::user()->name,
					'dari_id' => auth::id(),
					'untuk_nama' => $request->company,
					'untuk_id' => $id_user,
					'keterangan' => 'Your account is verified by "' . auth::user()->name . '"',
					'url_terkait' => 'profil/2',
					'status_baca' => 0,
					'waktu' => $date,
					'id_terkait' => $id_user,
					'to_role' => $id_role,
				]);
			}
		} else if ($request->staim == 3) {
			$date = date('Y-m-d H:i:s');

			$data3 = ['username' => $request->username, 'id2' => 0, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'by' => auth::user()->name];
			Mail::send('UM.user.emailverifditolak', $data3, function ($mail) use ($data3) {
				$mail->to($data3['email'], $data3['username']);
				$mail->subject('Your Account Was Rejected');
			});

			$notif = DB::table('notif')->insert([
				'dari_nama' => auth::user()->name,
				'dari_id' => auth::id(),
				'untuk_nama' => $request->company,
				'untuk_id' => $id_user,
				'keterangan' => 'Your account is rejected by "' . auth::user()->name . '"',
				'url_terkait' => 'profil/2',
				'status_baca' => 0,
				'waktu' => $date,
				'id_terkait' => $id_user,
				'to_role' => $id_role,
			]);
		}
		//UPDATE TAB 2
		if ($id_role == 2) {
			$badan_usaha = NULL;
			if (isset($ent[1])) {
				$badan_usaha = $ent[1];
			}
			// dd('a');
			// kalo yang tiga data yang awalnya ada di tab 3, dimasukin ke tab 2 yang ada di admin dan perubahan oleh admin di 3 file ini, bisa di save
			$updatetab2 = ItdpProfilExp::whereId($id_user_b)->update([
				"badanusaha" => $ent[0],
				"id_itdp_eks_business_entity" => $badan_usaha,
				"company" => $request->company,
				"description" => $request->description,
				"main_product" => $request->main_product,
				"addres" => $request->addres,
				"city" => $request->city,
				"id_mst_province" => $request->province,
				"id_incoterm" => $request->incoterm,
				"id_payment" => $request->payment,
				"postcode" => $request->postcode,
				"fax" => $request->fax,
				"website" => $request->website,
				"phone" => $request->phone,
				"email" => $request->email1,
				"id_eks_business_size" => $request->scoope,
				"id_business_role_id" => $request->tob,
				"employe" => $request->employee,
				"link_gmap" => $request->map_link,
				"lat" => $request->lat,
				"long" => $request->long,
				"npwp" => $request->npwp,
				"tdp" => $request->tanda_daftar,
				"year_establish" => $request->year_establish
			]);

			// $updatetab2 = DB::select("update itdp_profil_eks set badanusaha='" . $ent[0] . "', 
			// id_itdp_eks_business_entity ='" . $badan_usaha  . "', 
			// company='" . $request->company . "', 
			// description='" . $request->description . "', 
			// main_product='" . $request->main_product . "', 
			// addres='" . $request->addres . "', 
			// city='" . $request->city . "' , 
			// id_mst_province='" . $request->province . "' , 
			// id_incoterm='" . $request->incoterm . "' , 
			// id_payment='" . $request->payment . "' , 
			// postcode='" . $request->postcode . "', 
			// fax='" . $request->fax . "', 
			// website='" . $request->website . "', 
			// phone='" . $request->phone . "', 
			// email='" . $request->email1 . "', 
			// id_eks_business_size='" . $request->scoope . "', 
			// id_business_role_id='" . $request->tob . "', 
			// employe='" . $request->employee . "',
			// link_gmap='" . $request->map_link . "',
			// lat='" . $request->lat . "',
			// long='" . $request->long . "',
			// npwp='" . $request->npwp . "',
			// tdp='" . $request->tanda_daftar . "',
			// year_establish='" . $request->year_establish . "'
			// where id='" . $id_user_b . "'");


			// delete old data if exist
			$cek_contact_exist = ItdpContactEks::where('id_itdp_profil_eks', $id_user_b)->first();
			if ($cek_contact_exist != null) {
				ItdpContactEks::where('id_itdp_profil_eks', $id_user_b)->delete();
			}
			if (isset(($request->name_c))) {
				foreach ($request->name_c as $key => $val) {
					$data3 = ItdpContactEks::create([
						'id_itdp_profil_eks' => $id_user_b,
						'name' => $request->name_c[$key],
						'job_title' => $request->position_c[$key],
						'phone' => $request->phone_c[$key],
					]);
				}
			}
		} else {
			$badan_usaha = NULL;
			if (isset($ent[1])) {
				$badan_usaha = $ent[1];
			}

			$updatetab2 = DB::select("update itdp_profil_imp set badanusaha='" . $ent[0] . "', id_itdp_eks_business_entity ='" . $badan_usaha . "', company='" . $request->company . "', description='" . $request->description . "', main_product='" . $request->main_product . "', addres='" . $request->addres . "', city='" . $request->city . "' 
			, province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' 
			where id='" . $id_user_b . "'");
		}

		// DB::commit();
		if (Auth::guard('eksmp')->user()) {
			//            return redirect('profil/'.$id_role.'/'.$id_user)->with('success','Success Update Data');
			return redirect('/profil')->with('success', 'Success Update Data');
		} else {
			return redirect('/verifyuser')->with('success', 'Success Update Data');
		}
		// } catch (Exception $e) {
		// 	DB::rollback();
		// 	return $e->getMessage();
		// }
	}

	public function simpan_profilb(Request $request)
	{
		// untuk simpan profil di eksportir
		date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		$email_profil = $request->email1;
		$ent = explode(",", $request->badanusaha);

		$destination = 'uploads\Profile\Eksportir\\' . $id_user;
		if ($request->hasFile('image_1')) {
			$file1 = $request->file('image_1');
			$nama_file1 = time() . '_' . $request->file('image_1')->getClientOriginalName();
			Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
			$updfoto = DB::table('itdp_company_users')->where('id', $id_user)->update([
				"foto_profil" => $nama_file1,
			]);
		}

		//UPDATE TAB 1
		if ($request->password == null) {
			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "' where id='" . $request->id_user . "' ");
		} else {
			// , status='".$request->staim."'
			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', email='" . $request->email . "' where id='" . $request->id_user . "' ");
		}

		//UPDATE TAB 2
		$badan_usaha = NULL;
		if (isset($ent[1])) {
			$badan_usaha = $ent[1];
		}
		if ($id_role == 2) {
			$updatetab2 = DB::select("update itdp_profil_eks set badanusaha='" . $ent[0] . "', id_itdp_eks_business_entity ='" . $badan_usaha . "', company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' 
		, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "', email='" . $email_profil . "', id_eks_business_size='" . $request->scoope . "',
		 id_business_role_id='" . $request->tob . "', employe='" . $request->employee . "' where id='" . $id_user_b . "'");
		} else {
			$updatetab2 = DB::select("update itdp_profil_imp set badanusaha='" . $ent[0] . "', id_itdp_eks_business_entity ='" . $badan_usaha . "', company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' 
		, province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' , id_eks_business_size='" . $request->scoope . "',
		 id_business_role_id='" . $request->tob . "', employe='" . $request->employee . "' where id='" . $id_user_b . "'");
		}

		//
		if (Auth::guard('eksmp')->user()) {
			//            return redirect('profil/'.$id_role.'/'.$id_user)->with('success','Success Update Data');
			return redirect('/home')->with('success', 'Success Update Data');
		} else {
			return redirect('/verifyuser')->with('success', 'Success Update Data');
		}
	}

	public function simpan_dokumenb(Request $request)
	{
		$this->validate($request, [
			'npwpfile' => 'mimes:jpg,jpeg,png,pdf',
            'tdpfile' => 'mimes:jpg,jpeg,png,pdf',
            'doc' => 'mimes:jpg,jpeg,png,pdf',
            'siupfile' => 'mimes:jpg,jpeg,png,pdf',
		],
		[
			'tdpfile.mimes' => 'The Dokumen Nomor Induk Berusaha\'s type allowed only JPG, JPEG, PNG or PDF',
			'npwpfile.mimes' => 'The Dokumen NPWP\'s type allowed only JPG, JPEG, PNG or PDF',
			'doc.mimes' => 'The Surat Izin Tanda Usaha\'s type allowed only JPG, JPEG, PNG or PDF',
			'siupfile.mimes' => 'The Surat Izin Usaha Perdagangan\'s type allowed only JPG, JPEG, PNG or PDF',
		]);
		
		// untuk simpan dari data perusahaan dokumen di exportir
		date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		if (Auth::guard('eksmp')->user()) {
			//di edit indonesian exporter
			//ini yang masih mau di edit
			if (empty($request->file('doc'))) {
				$file = "";
			} else {
				$file = $request->file('doc')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('doc')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set doc='" . $file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('npwpfile'))) {
				$file = "";
			} else {
				$file = $request->file('npwpfile')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('npwpfile')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadnpwp='" . $file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('tdpfile'))) {
				$file = "";
			} else {
				$file = $request->file('tdpfile')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('tdpfile')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadtdp='" . $file . "' where id='" . $id_user_b . "'");
			}

			if (empty($request->file('siupfile'))) {
				$file = "";
			} else {
				$file = $request->file('siupfile')->getClientOriginalName();
				$destinationPath = public_path() . "/eksportir";
				$request->file('siupfile')->move($destinationPath, $file);
				$updatetabd = DB::select("update itdp_profil_eks set uploadsiup='" . $file . "' where id='" . $id_user_b . "'");
			}

			$date = date('Y-m-d H:i:s');
			$notif = DB::table('notif')->insert([
				'dari_nama' => getCompanyName(auth::guard('eksmp')->user()->id),
				'dari_id' => auth::guard('eksmp')->user()->id,
				'untuk_nama' => "Super Admin",
				'untuk_id' => '1',
				'keterangan' => 'Exporter "' . getExBadan(auth::guard('eksmp')->user()->id) . getCompanyName(auth::guard('eksmp')->user()->id) . '" Update The Company Data',
				'url_terkait' => 'profil/2',
				'status_baca' => 0,
				'waktu' => $date,
				'id_terkait' => $id_user,
				'to_role' => "1",
			]);

			$admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
			foreach ($admin_all as $aa) {
				$data = [
					'email' => $aa->email,
					'email1' => $aa->email,
					'username' => $aa->name,
					'company' => getCompanyName(auth::guard('eksmp')->user()->id),
					'id' => $id_user,
					'bu' => getExBadan(auth::guard('eksmp')->user()->id),
				];
				Mail::send('UM.user.emailexupload', $data, function ($mail) use ($data) {
					$mail->to($data['email1'], $data['username']);
					$mail->subject('Exporter Update their Profile');
				});
			}

			$datanya = DB::table('itdp_company_users')->where('id', auth::guard('eksmp')->user()->id)->first();
			if ($datanya->status == 3) {
				$id = auth::guard('eksmp')->user()->id;
				$update = DB::select("update itdp_company_users set status='0' where id='" . $id . "'");
			}

			//untuk aktifin otomatis kalo udah masukin NPWP. Tapi karna gak cek NPWP, Jadinya belum di aktifin dulu
			//if($request->staim == null){
			//    $staim = 0;
			//}else{
			//    $staim =1;
			//}

			//UPDATE TAB 3
			if ($id_role == 2) {
				if ($request->npwp == "null") {
					//                    ini kalo di
					//                    $updatetab2 = DB::select("update itdp_profil_eks set tdp='".$request->tanda_daftar."', siup='".$request->siup."'
					//				, upduserid='".$request->situ."' , id_eks_business_size='".$request->scoope."', id_business_role_id='".$request->tob."', employe='".$request->employee."', status='".$staim."'
					//				where id='".$id_user_b."'");
					$updatetab2 = DB::select("update itdp_profil_eks set tdp='" . $request->tanda_daftar . "', siup='" . $request->siup . "' 
				, upduserid='" . $request->situ . "' where id='" . $id_user_b . "'");
				} else {
					//                    $updatetab2 = DB::select("update itdp_profil_eks set npwp='".$request->npwp."', tdp='".$request->tanda_daftar."', siup='".$request->siup."'
					//				, upduserid='".$request->situ."' , id_eks_business_size='".$request->scoope."', id_business_role_id='".$request->tob."', employe='".$request->employee."', status='".$staim."'
					//				where id='".$id_user_b."'");
					$updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "', tdp='" . $request->tanda_daftar . "', siup='" . $request->siup . "' 
				, upduserid='" . $request->situ . "' where id='" . $id_user_b . "'");
					//                    $updatecompus = DB::select("update itdp_company_users set status='".$staim."', verified_by ='".Auth::guard('eksmp')->user()->id."', verified_at = '".$date."' where id='".$id_user."'") ;
					$updatecompus = DB::select("update itdp_company_users set verified_by ='" . Auth::guard('eksmp')->user()->id . "', verified_at = '" . $date . "' where id='" . $id_user . "'");
				}
			}


			//            if($request->file('doc') and $request->file('npwpfile') and $request->file('tdpfile') and $request->file('siupfile')){
			//
			//            }
		}

		if (Auth::guard('eksmp')->user()) {
			//            return redirect('profil/'.$id_role.'/'.$id_user)->with('success','Success Update Data');
			return redirect('/home')->with('success', 'Success Update Data');
		} else {
			return redirect('/verifyuser')->with('success', 'Success Update Data');
		}
	}

	public function simpan_kontak(Request $request)
	{
		$insert = DB::select("insert into itdp_contact_imp (name,email,phone,id_user) values
		('" . $request->name . "','" . $request->email . "','" . $request->phone . "','" . $request->idb . "')
		");
		return redirect('profil2/3/' . $request->idb);
	}

	public function simpan_profil2(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		$date = date('Y-m-d H:i:s');
		if (empty($request->file('foto_profil'))) {
			$file = "";
		} else {
			$file = $request->file('foto_profil')->getClientOriginalName();
			$destinationPath = public_path() . "/image/fotoprofil";
			$request->file('foto_profil')->move($destinationPath, $file);
			$updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $request->id_user . "' ");
			$updatetab22 = DB::select("update itdp_profil_imp set logo='" . $file . "' where id='" . $id_user_b . "'");
		}

		//UPDATE TAB 1
		if ($request->password == null) {
			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "', status='" . $request->staim . "'  where id='" . $request->id_user . "' ");
		} else {
			$updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "' ,  email='" . $request->email . "' where id='" . $request->id_user . "' ");
		}
		if ($request->staim == 1) {
			$updatetab1b = DB::select("update itdp_company_users set verified_by='" . auth::user()->id . "',verified_at='" . $date . "'   where id='" . $request->id_user . "' ");

			if (auth::user()) {
				$data3 = ['username' => $request->username, 'id2' => 0, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'by' => auth::user()->name];

				Mail::send('UM.user.emailverif2', $data3, function ($mail) use ($data3) {
					$mail->to($data3['email'], $data3['username']);
					$mail->subject('Your Account Was Verifed');
				});
				$notif = DB::table('notif')->insert([
					'dari_nama' => auth::user()->name,
					'dari_id' => auth::id(),
					'untuk_nama' => $request->company,
					'untuk_id' => $id_user,
					'keterangan' => 'Your account is verified by "' . auth::user()->name . '"',
					'url_terkait' => 'profile',
					'status_baca' => 0,
					'waktu' => $date,
					'to_role' => $id_role,
				]);
			}
		}
		//UPDATE TAB 2
		$updatetab2 = DB::select("update itdp_profil_imp set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' ,email='" . $request->email . "'
		, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' , status='" . $request->staim . "'
		where id='" . $id_user_b . "'");

		if ($request->staim == 2) {
			if ($request->template_reject == 1) {
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "', keterangan_reject='" . $request->txtreject . "'  where id='" . $request->id_user . "' ");
			} else {
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "'  where id='" . $request->id_user . "' ");
			}
		}
		//		if($request->staim == 1){
		//			$it = "3".$id_user_b;
		//			$data = [
		//            'email' => "",
		//            'email1' => $request->email,
		//            'username' => $request->username,
		//            'main_messages' => "",
		//            'id' => $it
		//			];
		//		Mail::send('UM.user.sendverif', $data, function ($mail) use ($data) {
		//        $mail->to($data['email1'], $data['username']);
		//        $mail->subject('Your account had Verified');
		//		});
		//		}

		return redirect('verifyimportir')->with('success', 'Success Update Data');
		//		return redirect('profil2/'.$id_role.'/'.$id_user);


	}

	public function ceknpwp()
	{
		$npwpz =	str_replace(".", "", $_GET['id']);
		$npwpx =	str_replace("-", "", $npwpz);
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://perizinan.kemendag.go.id/index.php/website_api/kswp/153/" . $npwpx,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: f3e1235e-d688-a840-efd7-c7eb19691494",
				"x-api-key: kpzgMbTYlv2VmXSeOf03KxirsyBIGt48LcRPd7nN"
			),
		));
		/*
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
*/
		/*
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
*/
		$server_output = curl_exec($curl);

		curl_close($curl);

		// print  $server_output ;
		$r = json_decode($server_output);
		echo json_encode(array('status' => $r->status, 'nama' => $r->nama));
		//die('asd');
		/*
		define('API_KEY', '2F0WpJ9Ija4VksioxSlc3tUywdzD7X8uMLbQHEGP');
		define('SECRET_KEY', 'MY_SECRET_KEY');

		$Sig = base64_encode(hash_hmac('sha256', 'date: "'.gmdate('D, d M Y H:i:s T').'"', SECRET_KEY, true));

		$ch = curl_init();
		$npwpz =	str_replace(".","",$_GET['id']);
		$npwpx =	str_replace("-","",$npwpz);
		
		curl_setopt($ch, CURLOPT_URL,"http://www.kemendag.go.id/addon/api/website_api/kswp/153/".$npwpx);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
			//'Accept: application/json',
			//'Accept-Encoding: gzip, deflate',
			//'Cache-Control: no-cache',
			//'Content-Type: application/json; charset=utf-8',
			//'Host: localhost',
			//'Date: "'.gmdate('D, d M Y H:i:s T').'"',
			'X-Api-Key: '.API_KEY,
			//'Authorization: Signature keyId="'.API_KEY.'",algorithm="hmac-sha256",headers="date",signature="'.$Sig.'"'
		];
		//var_dump($headers);die();

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

		// print  $server_output ;
		$r = json_decode($server_output);
		// echo json_decode($server_output);
		//var_dump($r);die();
		echo json_encode(array('status'=> $r->status,'nama'=> $r->nama));
		// var_dump($r->status);
		*/
	}

	public function qrcode(Request $request)
	{
		//        {{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css
		File::delete(public_path('uploads/qrcode/qrcode_2_' . $request->code . '.png'));
		QrCode::format('png')->margin(0)->size(100)->generate(url('/perusahaan/' . $request->code . ''), '../public/uploads/qrcode/qrcode_2_' . $request->code . '.png');
		//        QrCode::format('png')->margin(0)->size(100)->generate('tokopedia.com','C:\Users\Programmer-16\Desktop\mindy\dokumen kemendag\backup sementara\event');

	}

	public function getscoope(Request $request)
	{
		$scoope = DB::table('eks_business_size')->where('id', $request->id)->select('nmsize_ind')->first();

		echo json_encode($scoope);
	}

	public function gettob(Request $request)
	{
		$tob = DB::table('eks_business_role')->where('id', $request->id)->select('nmtype_ind')->first();

		echo json_encode($tob);
	}

	public function addbuyer()
	{
		$pageTitle = "Add Buyer";
		return view('verifyuser.addbuyer', compact('pageTitle'));
	}

	public function savebuyer(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		$country[] = DB::table('itdp_admin_ln')->where('id', Auth::user()->id_admin_ln)->first()->country;
		$buyer = [
			'company' => $request->company,
			'addres' => $request->alamat,
			'postcode' => $request->postcode,
			'phone' => $request->phone,
			'fax' => $request->fax,
			'email' => $request->email,
			'website' => $request->website,
			'created' => $date,
			'status' => 1,
			'city' => $request->city,
			'id_mst_country' => $country,
		];
		$profil_imp = DB::table('itdp_profil_imp')
			->insert($buyer);
		$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_imp");
		foreach ($ambilmaxid as $rt) {
			$id1 = $rt->maxid;
		}
		$insert2 = DB::select("
			insert into itdp_company_users (id_profil,password,email,status,id_role,type,created_at,newsletter) values
			('" . $id1 . "','" . bcrypt($request->password) . "','" . $request->email . "','0','3','Dalam Negeri','" . $date . "',$request->ckk2send)
		");

		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach ($ambilmaxid2 as $rt2) {
			$id2 = $rt2->maxid2;
		}
		// notif 
		$id_terkait = "3/" . $id2;
		$ket = "New user Buyer with name " . $request->company;
		$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','" . $request->company . "','" . $id1 . "','Super Admin','1','" . $ket . "','profil2','" . $id_terkait . "','" . $date . "','0')
		");

		$buyer['password'] = $request->password;
		Mail::send('UM.user.buyer', $buyer, function ($mail) use ($buyer) {
			$mail->to($buyer['email']);
			$mail->subject('New Account From A representative');
		});
	}

	public function addexpor()
	{
		$pageTitle = "Add Exporter";
		return view('verifyuser.addexpor', compact('pageTitle'));
	}

	public function saveexpor(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		$province = DB::table('itdp_admin_dn')->where('id', Auth::user()->id_admin_dn)->first()->id_country;
		$insert1 = DB::select("
			insert into itdp_profil_eks (company,addres,postcode,phone,fax,email,website,created,status,city,id_mst_province) values
			('" . $request->company . "','" . $request->alamat . "','" . $request->postcode . "','" . '+62' . $request->phone . "','" . '+62' . $request->fax . "'
			,'" . $request->email . "','" . $request->website . "','" . Date('Y-m-d H:m:s') . "','1','" . $request->city . "','" . $province . "')
		");
		$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_eks");
		foreach ($ambilmaxid as $rt) {
			$id1 = $rt->maxid;
		}
		$insert2 = DB::select("
			insert into itdp_company_users (id_profil,type,password,email,status,id_role,created_at,newsletter) values
			('" . $id1 . "','Luar Negeri','" . bcrypt($request->password) . "','" . $request->email . "','0','2','" . date('Y-m-d H:m:s') . "',$request->ckk2send)
		");
		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach ($ambilmaxid2 as $rt2) {
			$id2 = $rt2->maxid2;
		}

		$expor['company'] = $request->company;
		$expor['email'] = $request->email;
		$expor['password'] = $request->password;
		Mail::send('UM.user.expor', $expor, function ($mail) use ($expor) {
			$mail->to($expor['email']);
			$mail->subject('New Account From A representative');
		});
	}

	public function getBenua()
	{
		$id_benua = $_GET['benua'];

		$get_country = DB::table('mst_country')->where('mst_country_group_id', $id_benua)->orderBy('country')->get();
		// dd($get_country);
		echo json_encode($get_country);
	}

	public function getCountry()
	{
		$id_country = $_GET['country'];

		$get_city = DB::table('mst_city')->where('id_mst_country', $id_country)->orderBy('city')->get();
		// dd($get_country);
		echo json_encode($get_city);
	}

	public function multipleDeletion(Request $req)
	{

		$deletion = $req->deletion;
		foreach ($deletion as $d) {
			$id = Crypt::decryptString($d);
			$delete = DB::select("delete from itdp_company_users where id='" . $id . "'");
		}
		return redirect('verifyuser')->with('error', 'Success deleting ' . count($deletion) . ' data');
	}
}
