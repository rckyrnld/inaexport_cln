<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;
class LoguserController extends Controller
{

	public function index()
	{
		$pageTitle = 'Log User';
		$nowmen = date('Y-m-d');
		$satker=DB::table('master_satker')->get();
		$senjata=DB::table('master_senjata')->get();
		$kategori=DB::table('kategori_senjata')->get();
		$lemari=DB::table('master_lemari')->get();
		$lokasi=DB::table('master_lokasi')->get();
		$data=DB::select('select a.*,b.* from log_user a, users b where a.email = b.email order by a.id_log_user desc');

		return view('satker.log',compact('data','satker','pageTitle','senjata','kategori','lemari','lokasi'));
	}

	public function addSenjata(Request $request)
	{
		// echo "b";die();
		$kerjasama = App\Master_senjata::create($request->input());
		$jumlah = count($request->noseri);
		// for($a=0; $a<$jumlah; $a++){
			
		$insert = DB::table('master_senjata_sub')->insert([
                'id_senjata' => 2,
                'no_seri' => $jumlah,
				'trx' => ''
				]);
		// }
		return response()->json($kerjasama);
	}
	
	
	public function simpansatker(Request $request)
	{
		$insert = DB::table('master_satker')->insert([
                'nama_satker' => $request->nama_satker,
                'keterangan' => $request->keterangan
				]);
		
		return redirect('/satker');
	}
	
	public function hapussatker($id)
	{   

		$a = DB::table('master_satker')->where('id_satker',$id)->delete();
		return redirect('/satker');
	}
	
	public function ambilsubsenjata(){
		if($_GET['jumlah_senjata'] == "" || $_GET['jumlah_senjata'] == NULL){
			$ul = 1;
		}else{
			$ul = $_GET['jumlah_senjata'];
		}
		$kaliber = $_GET['kaliber'];
		// echo $kaliber;
		return view('senjata.tambahsenjata',compact('ul','kaliber'));
	}


	public function ubahSenjata(Request $request,$id_senjata)
	{       

		$kerjasama = App\Master_senjata::find($id_senjata);

		return response()->json($kerjasama);
	}

	public function simpanSenjata(Request $request,$id_senjata)
	{  
	echo "a";die();
		$kerjasama = App\Master_senjata::find($id_senjata);

		$kerjasama->nama_senjata = $request->nama_senjata;
		$kerjasama->save();

		return response()->json($kerjasama);
	}


	public function delete_senjata(Request $request,$id_senjata)
	{   

		$a = DB::table('master_senjata')->where('id_senjata',$id_senjata)->delete();
		if ($request->ajax()) {
			return response()->json($id_senjata);

		}
	}
}