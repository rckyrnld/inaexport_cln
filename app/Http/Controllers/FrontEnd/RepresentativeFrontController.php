<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class RepresentativeFrontController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index($tipe, Request $request)
    {
        if (Auth::guard('eksmp')->user() || Auth::user()) {

            //Category Utama
            if ($tipe == 'dn') {
                $query = DB::table('itdp_admin_users')
                    ->select('itdp_admin_users.id','itdp_admin_users.name', 'itdp_admin_dn.nama', 'itdp_admin_dn.email', 'itdp_admin_dn.web', 'itdp_admin_users.website', 'itdp_admin_dn.telp', 'itdp_admin_users.type', 'mst_province.province_en', 'itdp_admin_dn.kepala')
                    ->join('itdp_admin_dn', 'itdp_admin_dn.id', '=', 'itdp_admin_users.id_admin_dn')
                    ->leftJoin('mst_province', 'mst_province.id', '=', 'itdp_admin_dn.id_country')
                    // ->leftJoin('mst_city', 'mst_country.id', '=', 'mst_city.id_mst_country')
                    ->orderby('itdp_admin_users.name', 'asc')
                    ->where('id_group', 5);

                $query2 = DB::table('itdp_admin_users')
                    ->select('itdp_admin_users.name', 'itdp_admin_dn.nama', 'itdp_admin_dn.email', 'itdp_admin_dn.web', 'itdp_admin_users.website', 'itdp_admin_dn.telp', 'itdp_admin_users.type')
                    ->join('itdp_admin_dn', 'itdp_admin_dn.id', '=', 'itdp_admin_users.id_admin_dn')->orderby('itdp_admin_users.name', 'asc')
                    // ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_dn.country AS varchar(25))'))
                    ->where('id_group', 5);


                if ($request->nama) {
                    $query->where('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_dn.nama', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%');

                    $query2->where('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_dn.nama', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%');
                }
            } else {
                $query = DB::table('itdp_admin_users')
                    ->select('itdp_admin_users.id', 'itdp_admin_users.name', 'itdp_admin_ln.nama', 'itdp_admin_ln.email', 'itdp_admin_ln.web', 'itdp_admin_users.website', 'itdp_admin_ln.telp', 'itdp_admin_ln.country', 'itdp_admin_users.type', 'itdp_admin_ln.country_tambahan', 'itdp_admin_ln.kepala')
                    ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
                    ->orderby('itdp_admin_users.name', 'asc')
                    ->where('id_group', 4);

                $query2 = DB::table('itdp_admin_users')
                    ->select('itdp_admin_users.name', 'itdp_admin_ln.nama', 'itdp_admin_ln.email', 'itdp_admin_ln.web', 'itdp_admin_users.website', 'itdp_admin_ln.telp', 'itdp_admin_ln.country', 'itdp_admin_users.type', 'itdp_admin_ln.country_tambahan', 'itdp_admin_ln.kepala')
                    ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')->orderby('itdp_admin_users.name', 'asc')
                    // ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_ln.country AS varchar(25))'))
                    ->where('id_group', 4);

                if ($request->nama) {
                    $query->where('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_ln.nama', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%');

                    $query2->where('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_ln.nama', 'ILIKE', '%' . $request->nama . '%')
                        ->orWhere('itdp_admin_users.name', 'ILIKE', '%' . $request->nama . '%');
                }
            }
            // dd($query->get());
            $perwadags = $query->paginate(12);
            $coperwadag = $query2->count();
            // $countries = DB::table('itdp_admin_users')
            //     ->select('mst_country.id', 'mst_country.country', DB::raw('count(itdp_admin_users.id) AS jumlah'))
            //     ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
            //     ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_ln.country AS varchar(25))'))
            //     ->where('id_group', 4)
            //     ->groupBy('mst_country.id', 'mst_country.country')
            //     ->get();

            $jenisnya = "perwadag";
            $bgn = "list";

            $pageTitle = "Trade Representatives | Inaexport";
            $topMenu = "trade representatives";

            return view('frontend.representative.index', ['perwadags' => $perwadags->appends(Input::except('page'))], compact('jenisnya', 'bgn', 'pageTitle', 'topMenu', 'coperwadag', 'tipe'));
        } else {
            return redirect('/login');
        }
    }

    public function country($kode, Request $request)
    {
        $id = explode("_", $kode)[0];

        //Category Utama
        $perwadags = DB::table('itdp_admin_users')
            ->select('itdp_admin_users.name', 'itdp_admin_ln.web', 'itdp_admin_users.website', 'itdp_admin_ln.telp', 'mst_country.country', 'mst_country.kode_bps')
            ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
            ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_ln.country AS varchar(25))'))
            ->where('id_group', 4)
            ->where('mst_country.id', $id)
            ->paginate(12);

        $coperwadag = DB::table('itdp_admin_users')
            ->select('itdp_admin_users.name', 'itdp_admin_ln.web', 'itdp_admin_users.website', 'itdp_admin_ln.telp', 'mst_country.country', 'mst_country.kode_bps')
            ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
            ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_ln.country AS varchar(25))'))
            ->where('id_group', 4)
            ->where('mst_country.id', $id)
            ->count();

        $countries = DB::table('itdp_admin_users')
            ->select('mst_country.id', 'mst_country.country', DB::raw('count(itdp_admin_users.id) AS jumlah'))
            ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
            ->join('mst_country', DB::raw('CAST(mst_country.id AS varchar(25))'), '=', DB::raw('CAST(itdp_admin_ln.country AS varchar(25))'))
            ->where('id_group', 4)
            ->groupBy('mst_country.id', 'mst_country.country')
            ->get();

        $jenisnya = "perwadag";
        $bgn = "list";

        $pageTitle = "Trade Representatives | Inaexport";
        $topMenu = "trade representatives";

        return view('frontend.representative.index', ['perwadags' => $perwadags->appends(Input::except('page'))], compact('jenisnya', 'bgn', 'pageTitle', 'topMenu', 'coperwadag', 'countries'));
    }
}
