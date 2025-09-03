<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function loginadmin()
	{
		$pageTitle = "Log In Administrator";
		return view('auth.loginadmin', compact('pageTitle'));
	}

	public function pilihregister()
	{
		$pageTitle = "Choose Register";
		return view('auth.cr', compact('pageTitle'));
	}

	public function register_buyer()
	{
		$pageTitle = "Register for Buyers";
		return view('auth.register_buyer', compact('pageTitle'));
	}

	public function pilihregister_new()
	{
		$pageTitle = "Register for New Account";
		return view('auth.register_new', compact('pageTitle'));
	}

	public function forget_a()
	{
		$pageTitle = "Reset Password";
		return view('auth.forget', compact('pageTitle'));
	}

	public function resetpass_send()
	{
		$pageTitle = "Password Reset Link Successfully Sent";
		return view('auth.resetpass', compact('pageTitle'));
	}

	public function cekmail($id)
	{
		$cek = DB::select("select * from itdp_company_users where email='" . $id . "'");
		if (count($cek) == 0) {
			return "0";
		} else {
			return "1";
		}
	}
	public function gantipass1($id)
	{
		//echo "wkwkwk";die();
		// $ri = base64_decode($id);
		$ri = $id;
		$pageTitle = "Forget Password";
		return view('auth.forget_form', compact('pageTitle', 'ri', 'id'));
	}

	public function gantipass2($id)
	{
		$ri = base64_decode($id);
		$pageTitle = "Forget Password";
		return view('auth.forget_form2', compact('pageTitle', 'ri', 'id'));
	}

	public function set($lang)
	{
		session(['applocale' => $lang]);

		return back();
	}

	public function registrasi_penjual()
	{
		$pageTitle = "Registrasi Penjual";
		return view('auth.register_penjual', compact('pageTitle'));
	}

	public function simpan_rpembeli(Request $request)
	{
		$pageTitle = "Registrasi Penjual";

		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		if ($this->cekmail($request->email) == "0") {
			$insert1 = DB::select("
				insert into itdp_profil_imp (company,addres,postcode,phone,fax,email,website,created,status,city,id_mst_country) values
				('" . strtoupper($request->company) . "','" . $request->alamat . "','" . $request->postcode . "','" . $request->phone . "','" . $request->fax . "'
				,'" . $request->email . "','" . $request->website . "','" . $date . "','1','" . $request->city . "','" . $request->country . "')
			");
			$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_imp");
			foreach ($ambilmaxid as $rt) {
				$id1 = $rt->maxid;
			}
			$insert2 = DB::select("
				insert into itdp_company_users (id_profil,password,email,username,status,id_role,type,created_at,newsletter) values
				('" . $id1 . "','" . bcrypt($request->password) . "','" . $request->email . "','" . $request->username . "','0','3','Luar Negeri','" . $date . "',$request->ckk2send)
			");
			// dd($request->all());
			$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
			foreach ($ambilmaxid2 as $rt2) {
				$id2 = $rt2->maxid2;
			}

			$nambad = $request->nama_badan . " " . strtoupper($request->company);
			$help = $this->addclient($request->email, $request->password, $nambad);
			if ($help["meta"]["code"] == 200) {
				$id_helpdesk = $help["meta"]["details"];
				DB::table('itdp_company_users')->where('id', $id2)->update(['id_helpdesk' => $id_helpdesk]);
			}

			// dd($request->all());
			// notif
			$id_terkait = "3/" . $id2;
			$ket = "New user Buyer with name " . strtoupper($request->company);
			$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('1','" . strtoupper($request->company) . "','" . $id1 . "','Super Admin','1','" . $ket . "','profil2','" . $id_terkait . "','" . $date . "','0')
			");

			//notif untuk perwakilan
			// $carigc = DB::select("select * from mst_country where id='" . $request->country . "'");
			// foreach ($carigc as $gccari) {
			// 	$groupcountry = $gccari->mst_country_group_id;
			// }
			$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_ln b  where a.id_admin_ln = b.id and b.id_country='" . $request->country . "'");
			foreach ($qr as $rq) {
				$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('4','" . strtoupper($request->company) . "','" . $id1 . "','" . getAdminName($rq->id) . "','" . $rq->id . "','" . $ket . "','profil2','" . $id_terkait . "','" . $date . "','0')
				");
				$data3 = ['username' => getAdminName($rq->id), 'id2' => $id2, 'company' => strtoupper($request->company), 'password' => $request->password, 'email' => $rq->email, 'type' => 'Buyer'];

				Mail::send('UM.user.emailsperwakilan', $data3, function ($mail) use ($data3) {
					$mail->to($data3['email'], $data3['username']);
					$mail->subject('Account Activation Notification');
				});
			}

			$admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
			foreach ($admin_all as $aa) {
				$data = [
					'email' => $aa->email,
					'email1' => $aa->email,
					'username' => $aa->name,
					'company' => strtoupper($request->company),
					'type' => "Buyer",
					'bu' => "",
				];
				Mail::send('UM.user.emailsadmin', $data, function ($mail) use ($data) {
					$mail->to($data['email1'], $data['username']);
					$mail->subject('Account Activation Notification');
				});
			}

			$data = ['username' => $request->username, 'id2' => $id2, 'company' => strtoupper($request->company), 'password' => $request->password, 'email' => $request->email];

			Mail::send('UM.user.emailsuser2', $data, function ($mail) use ($data) {
				$mail->to($data['email'], $data['username'], $data['id2'], $data['company']);
				$mail->subject('Account Activation Notifications');
			});




			//			$data2 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => env('MAIL_USERNAME','no-reply@inaexport.id'),'type' => 'Exporter'];
			//
			//
			//                Mail::send('UM.user.emailsadmin', $data2, function ($mail) use ($data2) {
			//                    $mail->to($data2['email'], $data2['username']);
			//                    $mail->subject('Notifikasi Aktifasi Akun');
			//
			//                });

			return view('auth.waitmail', compact('pageTitle'));
		} else {
			// return redirect('createnewaccount');
			return response()->json(' Email already used', 422);
		}
	}

	public function simpan_rpenjual(Request $request)
	{
		$pageTitle = "sucses";
		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		//$cekemailhelp = $this->checkCient($request->email);
		if ($this->cekmail($request->email) == "0") {
			// dd($request->all());
			$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='" . $request->prov . "'");
			$insert1 = DB::select("
				insert into itdp_profil_eks (id_itdp_eks_business_entity,badanusaha,company,addres,postcode,phone,fax,email,website,created,status,city,id_mst_province) values
				('" . $request->badanusaha . "','" . $request->nama_badan . "','" . strtoupper($request->company) . "','" . $request->alamat . "','" . $request->postcode . "','" . '+62' . $request->phone . "','" . '+62' . $request->fax . "'
				,'" . $request->email . "','" . $request->website . "','" . Date('Y-m-d H:m:s') . "','1','" . $request->city . "','" . $request->prov . "')
			");
			$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_eks");
			foreach ($ambilmaxid as $rt) {
				$id1 = $rt->maxid;
			}
			$insert2 = DB::select("
				insert into itdp_company_users (id_profil,username,type,password,email,status,id_role,created_at,newsletter) values
				('" . $id1 . "','" . $request->pic . "','Dalam Negeri','" . bcrypt($request->password) . "','" . $request->email . "','0','2','" . date('Y-m-d H:m:s') . "',$request->ckk2send)
			");
			$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
			foreach ($ambilmaxid2 as $rt2) {
				$id2 = $rt2->maxid2;
			}

			$nambad = $request->nama_badan . " " . strtoupper($request->company);
			$help = $this->addclient($request->email, $request->password, $nambad);
			if ($help["meta"]["code"] == 200) {
				$id_helpdesk = $help["meta"]["details"];
				DB::table('itdp_company_users')->where('id', $id2)->update(['id_helpdesk' => $id_helpdesk]);
			}


			// notif
			$id_terkait = "2/" . $id2;
			$ket = "User baru Eksportir dengan nama " . strtoupper($request->company);

			$data = ['username' => $request->username, 'id2' => $id2, 'company' => strtoupper($request->company), 'password' => $request->password, 'email' => $request->email, 'user' => 'exporter', 'type' => 'Indonesian Exporter'];

			Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
				$mail->to($data['email'], $data['username']);
				$mail->subject('Notifikasi Aktifasi Akun');
			});

			//		//notif untuk perwakilan
			$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='" . $request->prov . "'");
			// echo "select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='".$request->prov."'";die();
			foreach ($qr as $rq) {
				$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('4','" . strtoupper($request->company) . "','" . $id1 . "','" . getAdminName($rq->id) . "','" . $rq->id . "','" . $ket . "','profil','" . $id_terkait . "','" . $date . "','0')
				");
				$data3 = ['username' => getAdminName($rq->id), 'id2' => $id2, 'company' => strtoupper($request->company), 'password' => $request->password, 'email' => $rq->email, 'type' => 'Exporter'];

				Mail::send('UM.user.emailsperwakilan', $data3, function ($mail) use ($data3) {
					$mail->to($data3['email'], $data3['username']);
					$mail->subject('Notifikasi Aktifasi Akun');
				});
			}

			return response()->json('ok', 200);
		} else {
			return response()->json('Email already used or taken helpdesk', 422);
		}
	}

	public function addclient($email, $password, $name)
	{

		$data["email"]    = $email;
		$data["password"] = $password;
		$data["name"]     = $name;

		$url = config("constants.HELPDESK_API_URL") . "client";
		$ch = curl_init($url);
		$username = config("constants.HELPDESK_API_USERNAME");
		$password = config("constants.HELPDESK_API_PASSWORD");
		// curl connection
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

		$hasil = curl_exec($ch);
		$error = curl_error($ch);
		$JSONdata = json_decode($hasil, true);
		return $JSONdata;
	}

	public function checkCient($email)
	{

		$data["email"] = $email;
		$url = config("constants.HELPDESK_API_URL") . "client/check";
		$ch = curl_init($url);
		$username = config("constants.HELPDESK_API_USERNAME");
		$password = config("constants.HELPDESK_API_PASSWORD");
		// curl connection
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

		$hasil = curl_exec($ch);
		$error = curl_error($ch);
		$JSONdata = json_decode($hasil, true);
		return $JSONdata;
	}

	public function data_br2()
	{

		$buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row,* from csc_buying_request");


		return DataTables::of($buy)
			->addColumn('row', function ($buy) {
				return "<center>" . $buy->row . "</center>";
			})
			->addColumn('col1', function ($buy) {
				return $buy->subyek;
			})
			->addColumn('col2', function ($buy) {
				$cr = explode(',', $buy->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for ($a = 0; $a < ($hitung - 1); $a++) {
					if ($cr[$a] != '') {
						$namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
						if (count($namaprod) != 0) {
							foreach ($namaprod as $prod) {
								$napro = $prod->nama_kategori_en;
							}
							$semuacat = $semuacat . "- " . $napro . "<br>";
						}
					}
				}
				return $semuacat;
			})
			->addColumn('col3', function ($buy) {
				return $buy->date;
			})
			->addColumn('col4', function ($buy) {
				return 'Valid ' . $buy->valid . " days";
			})
			->addColumn('col5', function ($buy) {
				if ($buy->deal == null || $buy->deal == 0 || empty($buy->deal)) {
					if (app()->getLocale() == "en") {
						return "Negotiation";
					} else if (app()->getLocale() == "in") {
						return "Negosiasi";
					} else if (app()->getLocale() == "ch") {
						return "谈判";
					} else {
						return "";
					}
				} else {
					if (app()->getLocale() == "en") {
						return "Deal";
					} else if (app()->getLocale() == "in") {
						return "Sepakat";
					} else if (app()->getLocale() == "ch") {
						return "成交";
					} else {
						return "";
					}
				}
				/*
				if($buy->deal == null || $buy->deal == 0 || empty($buy->deal)){
					return "Negosiation";
				 }else{
					return "Deal";
				 }
				 */
			})
			->addColumn('col6', function ($buy) {
				if ($buy->by_role == 3) {
					if (app()->getLocale() == "en") {
						return "Importer";
					} else if (app()->getLocale() == "in") {
						return "Importir";
					} else if (app()->getLocale() == "ch") {
						return "进口商";
					} else {
						return "";
					}
				} else if ($buy->by_role == 4) {
					if (app()->getLocale() == "en") {
						return "Representative";
					} else if (app()->getLocale() == "in") {
						return "Perwakilan";
					} else if (app()->getLocale() == "ch") {
						return "代表人物";
					} else {
						return "";
					}
				} else if ($buy->by_role == 1) {
					if (app()->getLocale() == "en") {
						return "Admin";
					} else if (app()->getLocale() == "in") {
						return "Admin";
					} else if (app()->getLocale() == "ch") {
						return "管理员";
					} else {
						return "";
					}
				} else {
					return "";
				}
			})


			->rawColumns(['col4', 'col5', 'col2', 'col6', 'row'])
			->make(true);
	}

	public function transaksibr()
	{
	}
	public function verifypembeli($id)
	{
		//dd($id);
		DB::table('itdp_company_users')->where('id', $id)->update([
			'agree' => 1,
			'status' => 1,
			'verified_at' => date('Y-m-d H:i:s')
		]);
		return redirect('login');
	}

	public function gantipass()
	{
		$idx = Auth::user()->id;
		$queryxp = DB::select("select * from users where id='" . $idx . "'");
		$pageTitle = "Ganti Password";
		return view('gantipass', compact('pageTitle', 'queryxp'));
	}

	public function resetpass(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$email = $request->email;
		if ($id_role == 1) {
			// $ei = DB::select("select a.id, a.username, a.email, b.company from itdp_company_users a left join itdp_profil_eks b on a.id_profil=b.id  where a.email='" . $email . "'");
			$ei = DB::select("select a.id, a.username, a.email, coalesce (b.company, c.company) as company from itdp_company_users a  left join itdp_profil_eks b on a.id_profil=b.id  left join itdp_profil_imp c on a.id_profil = c.id  where a.email= '" . $email . "'");
			// dd($ei);
			if (count($ei) != 0) {
				foreach ($ei as $ie) {
					$d1 = $ie->id;
					$d2 = $ie->username;
					$d3 = $ie->email;
					$d4 = $ie->company;
				}
				$data = ['username' => $d2, 'id2' => base64_encode($d1), 'nama' => $d4, 'email' => $d3];

				// dd($data);
				Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
					$mail->to($data['email']);
					$mail->subject('Reset Password');
				});
				// Mail::to('akbarfm19@gmail.com')->send('UM.user.emailforget');
				// Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
				// 	$mail->to($data['email'], $data['username']);
				// 	$mail->subject('Notifikasi Aktifasi Akun');
				// });
			}
		} else if ($id_role == 1) {
			$ei = DB::select("select * from itdp_admin_users where email='" . $email . "'");
			if (count($ei) != 0) {
				foreach ($ei as $ie) {
					$d1 = $ie->id;
					$d2 = $ie->name;
					$d3 = $ie->email;
				}
				$data = ['username' => $d2, 'id2' => base64_encode($d1), 'nama' => $d2, 'email' => $d3];

				Mail::send('UM.user.emailforget2', $data, function ($mail) use ($data) {
					$mail->to($data['email'], $data['username']);
					$mail->subject('Reset Password');
				});
			}
		}
		return redirect('resetpass_send');
	}

	public function updatepass1(Request $request, $id)
	{
		$update = DB::select("update itdp_company_users set password='" . bcrypt($request->password) . "' where id='" . base64_decode($request->ida) . "'");
		return redirect('login');
	}

	public function updatepass2(Request $request, $id)
	{
		$update = DB::select("update itdp_admin_users set password='" . bcrypt($request->password) . "' where id='" . $request->ida . "'");
		return redirect('login');
	}
	public function updatepass(Request $request)
	{
		// echo bcrypt($request->password);die();
		$queryxp = DB::select("
		update users set password='" . bcrypt($request->password) . "' , password_real='" . $request->password . "'
		where id='" . Auth::user()->id . "'
		");
		return redirect('');
	}
}
