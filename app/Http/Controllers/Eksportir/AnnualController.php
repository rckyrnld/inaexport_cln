<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PDF;

class AnnualController extends Controller
{
    public function index()
    {
        //        $id_user = Auth::guard('eksmp')->user()->id_profil;
        //        dd($id_user);die();
        $pageTitle = "Penjualan";
        return view('eksportir.annual_sales.index', compact('pageTitle'));
    }

    public function tambah()
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/annual_save';
        $pageTitle = 'Form Tambah Penjualan';
        return view('eksportir.annual_sales.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_sales')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'nilai' => $request->value,
            'nilai_persen' => str_replace(",", ".", $request->persen),
            'nilai_ekspor' => $request->nilai_ekspor,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/annual_sales')->with('success', 'Success Add Data');
    }

    public function datanya()
    {
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">' . $mjl->tahun . '</div>';
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-success"title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('sales.delete', $mjl->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tahun'])
            ->make(true);
    }


    public function edit($id)
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Edit Penjualan';
        $url = '/eksportir/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Penjualan';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
        DB::table('itdp_eks_sales')->where('id', $id)
            ->delete();
        return redirect('eksportir/annual_sales')->with('error', 'Success Delete Data');
    }

    public function update(Request $request)
    {
        DB::table('itdp_eks_sales')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->year,
                'nilai' => $request->value,
                'nilai_persen' => str_replace(",", ".", $request->persen),
                'nilai_ekspor' => $request->nilai_ekspor,
            ]);
        return redirect('eksportir/annual_sales')->with('success', 'Succes Update Data');
    }

    public function indexadminannualsales($id)
    {
        //        dd($id);
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.indexadminannualsales', compact('pageTitle', 'id'));
    }

    public function indexadmin(Request $request)
    {
        if (Auth::user() == null) {
            return redirect('/admin');
        }
        // dd(Auth::user());
        $getdinas = DB::table('itdp_admin_users')
            ->join('itdp_admin_dn', 'itdp_admin_dn.id', '=', 'itdp_admin_users.id_admin_dn')
            ->where('itdp_admin_users.id', Auth::user()->id)
            ->first();

        $getperwadag = DB::table('itdp_admin_users')
            ->join('itdp_admin_ln', 'itdp_admin_ln.id', '=', 'itdp_admin_users.id_admin_ln')
            ->where('itdp_admin_users.id', Auth::user()->id)
            ->first();

        $categoryutama = DB::table('csc_product')
            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->select(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->groupby(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->where('csc_product_single.status', 2)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();

        $pageTitle = "List Exporter";
        // Admin or Admin Data
        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');
        if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8) {
            //admin
            $provinsi = ($request->cari_provinsi) ? $request->cari_provinsi : null;
            $kategori = ($request->cari_kategori) ? $request->cari_kategori : null;
            $q = ($request->q_hidden) ? $request->q_hidden : null;

            if ($provinsi != "" || $kategori != "") {

                $copesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                    ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
                if ($provinsi != "") {
                    $copesan = $copesan->where('id_mst_province', $provinsi);
                }
                if ($kategori != "") {
                    $copesan = $copesan->where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                }

                $copesan = $copesan->where('itdp_company_users.status', '1');
                if ($q != '') {
                    $copesan = $copesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $copesan = $copesan->groupBy(
                    'itdp_profil_eks.id',
                    'itdp_profil_eks.company',
                    'itdp_profil_eks.addres',
                    'mst_province.province_en',
                    'itdp_profil_eks.fax',
                    'itdp_company_users.status',
                    'itdp_company_users.verified_at',
                    'itdp_company_users.email',
                    'itdp_company_users.id',
                    'eks_business_entity.nmbadanusaha'
                );
                $copesan = $copesan->distinct()
                    ->get()
                    ->count('itdp_profil_eks.id');
                // dd($copesan);

                $pesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                    ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
                if ($provinsi != "") {
                    $pesan = $pesan->where('id_mst_province', $provinsi);
                }
                if ($kategori != "") {
                    $pesan = $pesan->where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                }
                $pesan = $pesan->where('itdp_company_users.status', '1');
                if ($q != '') {
                    $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $pesan = $pesan->groupBy(
                    'itdp_profil_eks.id',
                    'itdp_profil_eks.company',
                    'itdp_profil_eks.addres',
                    'mst_province.province_en',
                    'itdp_profil_eks.fax',
                    'itdp_company_users.status',
                    'itdp_company_users.verified_at',
                    'itdp_company_users.email',
                    'itdp_company_users.id',
                    'eks_business_entity.nmbadanusaha'
                );
                $pesan = $pesan->distinct()->paginate(12);
                $pesan->appends(['cari_kategori' => $kategori, 'q_hidden' => $q]);
                $pesan->appends(['cari_provinsi' => $provinsi != null ? $provinsi : ""]);
            } else {
                $copesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->where('itdp_company_users.status', '1');
                if ($q != '') {
                    $copesan = $copesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $copesan = $copesan->groupBy(
                    'itdp_profil_eks.id',
                    'itdp_profil_eks.company',
                    'itdp_profil_eks.addres',
                    'mst_province.province_en',
                    'itdp_profil_eks.fax',
                    'itdp_company_users.status',
                    'itdp_company_users.verified_at',
                    'itdp_company_users.email',
                    'itdp_company_users.id',
                    'eks_business_entity.nmbadanusaha',
                    'eks_business_entity.nmbadanusaha'
                );
                $copesan = $copesan->distinct()
                    ->get()
                    ->count('itdp_profil_eks.id');

                $pesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->where('itdp_company_users.status', '1');
                if ($q != '') {
                    $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $pesan = $pesan->groupBy(
                    'itdp_profil_eks.id',
                    'itdp_profil_eks.company',
                    'itdp_profil_eks.addres',
                    'mst_province.province_en',
                    'itdp_profil_eks.fax',
                    'itdp_company_users.status',
                    'itdp_company_users.verified_at',
                    'itdp_company_users.email',
                    'itdp_company_users.id',
                    'eks_business_entity.nmbadanusaha',
                    'eks_business_entity.nmbadanusaha'
                );
                $pesan = $pesan->distinct()->paginate(12);
                $pesan->appends(['cari_kategori' => $kategori, 'q_hidden' => $q]);
                $pesan->appends(['cari_provinsi' => $provinsi != null ? $provinsi : ""]);
            }

            return view('eksportir.annual_sales.indexadmin', compact('provinsi', 'kategori', 'categoryutama', 'pageTitle', 'pesan', 'copesan', 'q'));
        } elseif (Auth::user()->id_group == 4 || Auth::user()->id_group == 5 || Auth::user()->id_group == 11) {
            if (Auth::user()->id_admin_dn == 0 || Auth::user()->id_group == 11) {
                $q = ($request->q_hidden) ? $request->q_hidden : null;
                $provinsi = ($request->cari_provinsi) ? $request->cari_provinsi : null;
                $kategori = ($request->cari_kategori) ? $request->cari_kategori : null;
                // dd(Auth::user());

                if ($provinsi != "" || $kategori != "") {
                    $copesan = DB::table('itdp_profil_eks')
                        ->select(
                            'itdp_profil_eks.id',
                            'itdp_profil_eks.company',
                            'itdp_profil_eks.addres',
                            'mst_province.province_en',
                            'itdp_profil_eks.fax',
                            'itdp_company_users.status',
                            'itdp_company_users.verified_at',
                            'itdp_company_users.email',
                            'itdp_company_users.id as id_user',
                            'eks_business_entity.nmbadanusaha',
                            'eks_business_entity.nmbadanusaha'
                        )
                        ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                        ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                        ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
                    if ($provinsi != "") {
                        $copesan = $copesan->where('id_mst_province', $provinsi);
                    }
                    if ($kategori != "") {
                        $copesan = $copesan->where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                    }

                    $copesan = $copesan->where('itdp_company_users.status', '1');
                    if ($q != '') {
                        $copesan = $copesan->where('company', 'ILIKE', '%' . $q . '%');
                    }
                    $copesan = $copesan->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );
                    $copesan = $copesan->distinct()
                        ->get()
                        ->count('itdp_profil_eks.id');
                    // dd($copesan);

                    $pesan = DB::table('itdp_profil_eks')
                        ->select(
                            'itdp_profil_eks.id',
                            'itdp_profil_eks.company',
                            'itdp_profil_eks.addres',
                            'mst_province.province_en',
                            'itdp_profil_eks.fax',
                            'itdp_company_users.status',
                            'itdp_company_users.verified_at',
                            'itdp_company_users.email',
                            'itdp_company_users.id as id_user',
                            'eks_business_entity.nmbadanusaha',
                            'eks_business_entity.nmbadanusaha'
                        )
                        ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                        ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                        ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')
                        ->distinct();
                    if ($provinsi != "") {
                        $pesan = $pesan->where('id_mst_province', $provinsi);
                    }
                    if ($kategori != "") {
                        $pesan = $pesan->where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                    }
                    $pesan = $pesan->where('itdp_company_users.status', '1');
                    if ($q != '') {
                        $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
                    }
                    $pesan = $pesan->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );
                    $pesan = $pesan->paginate(12);
                    $pesan->appends(['cari_kategori' => $kategori, 'q_hidden' => $q]);
                    $pesan->appends(['cari_provinsi' => $provinsi != null ? $provinsi : ""]);
                } else {
                    $copesan = DB::table('itdp_profil_eks')
                        ->select(
                            'itdp_profil_eks.id',
                            'itdp_profil_eks.company',
                            'itdp_profil_eks.addres',
                            'mst_province.province_en',
                            'itdp_profil_eks.fax',
                            'itdp_company_users.status',
                            'itdp_company_users.verified_at',
                            'itdp_company_users.email',
                            'itdp_company_users.id as id_user',
                            'eks_business_entity.nmbadanusaha',
                            'eks_business_entity.nmbadanusaha'
                        )
                        ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                        ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->where('itdp_company_users.status', '1');
                    if ($q != '') {
                        $copesan = $copesan->where('company', 'ILIKE', '%' . $q . '%');
                    }
                    $copesan = $copesan->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );
                    $copesan = $copesan->distinct()
                        ->get()
                        ->count('itdp_profil_eks.id');

                    $pesan = DB::table('itdp_profil_eks')
                        ->select(
                            'itdp_profil_eks.id',
                            'itdp_profil_eks.company',
                            'itdp_profil_eks.addres',
                            'mst_province.province_en',
                            'itdp_profil_eks.fax',
                            'itdp_company_users.status',
                            'itdp_company_users.verified_at',
                            'itdp_company_users.email',
                            'itdp_company_users.id as id_user',
                            'eks_business_entity.nmbadanusaha',
                            'eks_business_entity.nmbadanusaha'
                        )
                        ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                        ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                        ->distinct()
                        ->where('itdp_company_users.status', '1');
                    if ($q != '') {
                        $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
                    }
                    $pesan = $pesan->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );
                    $pesan = $pesan->paginate(12);
                    $pesan->appends(['cari_kategori' => $kategori, 'q_hidden' => $q]);
                    $pesan->appends(['cari_provinsi' => $provinsi != null ? $provinsi : ""]);
                }

                // dd($pesan);
                return view('eksportir.annual_sales.indexperwadag', compact('provinsi', 'categoryutama', 'pageTitle', 'pesan', 'copesan', 'kategori', 'q'));
            } else {
                $q = ($request->q_hidden) ? $request->q_hidden : null;
                //DINAS
                $kategori = ($request->cari_kategori) ? $request->cari_kategori : null;

                $provinsi = DB::table('itdp_admin_dn')
                    ->where('itdp_admin_dn.id', '=', Auth::user()->id_admin_dn)
                    ->value('id_country');
                $pesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                    ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')
                    ->distinct()
                    ->where('itdp_profil_eks.id_mst_province', '=', $provinsi);

                if ($kategori != "") {
                    $pesan = $pesan->Where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                }
                if ($q != '') {
                    $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $pesan = $pesan->where('itdp_company_users.status', '1')
                    ->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );

                $pesan = $pesan->paginate(12);
                $pesan->appends(['cari_kategori' => $request->cari_kategori]);

                $copesan = DB::table('itdp_profil_eks')
                    ->select(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id as id_user',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    )
                    ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                    ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                    ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                    ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                    ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')
                    ->distinct()
                    ->where('itdp_profil_eks.id_mst_province', '=', $provinsi);

                if ($kategori != "") {
                    $copesan = $copesan->Where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
                }
                if ($q != '') {
                    $copesan = $copesan->where('company', 'ILIKE', '%' . $q . '%');
                }
                $copesan = $copesan->where('itdp_company_users.status', '1')
                    ->groupBy(
                        'itdp_profil_eks.id',
                        'itdp_profil_eks.company',
                        'itdp_profil_eks.addres',
                        'mst_province.province_en',
                        'itdp_profil_eks.fax',
                        'itdp_company_users.status',
                        'itdp_company_users.verified_at',
                        'itdp_company_users.email',
                        'itdp_company_users.id',
                        'eks_business_entity.nmbadanusaha',
                        'eks_business_entity.nmbadanusaha'
                    );
                $copesan = $copesan
                    ->get()
                    ->count('itdp_profil_eks.id');

                return view('eksportir.annual_sales.indexdinas', compact('categoryutama', 'pageTitle', 'pesan', 'copesan', 'kategori', 'provinsi', 'q'));
            }
        }
    }

    public function perwakilanBuyerIndex(Request $request)
    {

        $pageTitle = "List buyer";

        if (Auth::user()->id_group == 11) {

            $co_datanya_buyer = DB::table('itdp_company_users')
                ->select('*')
                ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                ->where('itdp_company_users.id_role', '3')
                ->paginate(12);

            $datanya_buyer = DB::table('itdp_company_users')
                ->select('*')
                ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                ->where('itdp_company_users.id_role', '3')
                ->count();
            $q = '';
            return view('eksportir.annual_sales.indexbuyer', compact('datanya_buyer', 'co_datanya_buyer', 'pageTitle', 'q'));
        } else {
            $data_perwakilan = DB::table('itdp_admin_users')
                ->select(
                    'mst_country.country as cn',
                    'mst_country.id',
                    'itdp_admin_users.*',
                    'itdp_admin_ln.country'
                )
                ->join('itdp_admin_ln', 'itdp_admin_users.id_admin_ln', '=', 'itdp_admin_ln.id')
                ->join('mst_country', 'itdp_admin_ln.country', '=', 'mst_country.id')
                ->where('itdp_admin_users.id', Auth::user()->id)
                ->first();
            // dd($data_perwakilan);

            $co_datanya_buyer = DB::table('itdp_company_users')
                ->select('*')
                ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                ->where('itdp_profil_imp.id_mst_country', $data_perwakilan->country)
                ->where('itdp_company_users.id_role', '3')
                ->paginate(12);

            $datanya_buyer = DB::table('itdp_company_users')
                ->select('*')
                ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                ->where('itdp_profil_imp.id_mst_country', $data_perwakilan->country)
                ->where('itdp_company_users.id_role', '3')
                ->count();
            // dd($co_datanya_buyer);
            $q = '';
            return view('eksportir.annual_sales.indexbuyer', compact('datanya_buyer', 'co_datanya_buyer', 'data_perwakilan', 'pageTitle', 'q'));
        }
    }
    public function searchBuyer(Request $req)
    {
        // dd('asd');
        $pageTitle = "List buyer";
        $q = $req->q;
        if ($q != "") {
            if (Auth::user()->id_group == 11) {

                $co_datanya_buyer = DB::table('itdp_company_users')
                    ->select('*')
                    ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                    ->where('company', 'ILIKE', '%' . $q . '%')
                    ->paginate(12);

                $datanya_buyer = DB::table('itdp_company_users')
                    ->select('*')
                    ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                    ->where('company', 'ILIKE', '%' . $q . '%')
                    ->count();
                $pagination = $co_datanya_buyer->appends(array('q' => $req->q));
                $co_datanya_buyer->appends($req->only('q'));
                if (count($co_datanya_buyer) > 0) {
                    return view('eksportir.annual_sales.indexbuyer', compact('pageTitle', 'co_datanya_buyer', 'datanya_buyer', 'q'));
                } else {
                    return view('eksportir.annual_sales.indexbuyer', compact('pageTitle', 'co_datanya_buyer', 'datanya_buyer', 'q'))->withMessage('No Details found. Try to search again !');
                }
            } else {
                $data_perwakilan = DB::table('itdp_admin_users')
                    ->select(
                        'mst_country.country as cn',
                        'mst_country.id',
                        'itdp_admin_users.*',
                        'itdp_admin_ln.country'
                    )
                    ->join('itdp_admin_ln', 'itdp_admin_users.id_admin_ln', '=', 'itdp_admin_ln.id')
                    ->join('mst_country', 'itdp_admin_ln.country', '=', 'mst_country.id')
                    ->where('itdp_admin_users.id', Auth::user()->id)
                    ->first();

                $co_datanya_buyer = DB::table('itdp_company_users')
                    ->select('*')
                    ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                    ->where('itdp_profil_imp.id_mst_country', $data_perwakilan->country)
                    ->where('company', 'ILIKE', '%' . $q . '%')
                    ->paginate(12);

                $datanya_buyer = DB::table('itdp_company_users')
                    ->select('*')
                    ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                    ->where('itdp_profil_imp.id_mst_country', $data_perwakilan->country)
                    ->where('company', 'ILIKE', '%' . $q . '%')
                    ->count();
                $pagination = $co_datanya_buyer->appends(array('q' => $req->q));
                $co_datanya_buyer->appends($req->only('q'));
                if (count($co_datanya_buyer) > 0) {
                    return view('eksportir.annual_sales.indexbuyer', compact('pageTitle', 'data_perwakilan', 'co_datanya_buyer', 'datanya_buyer', 'q'));
                } else {
                    return view('eksportir.annual_sales.indexbuyer', compact('pageTitle', 'data_perwakilan', 'co_datanya_buyer', 'datanya_buyer', 'q'))->withMessage('No Details found. Try to search again !');
                }
            }
        } else {
            return redirect('/eksportir/buyer/admin');
        }
    }

    public function search(Request $req)
    {
        $pageTitle = "Supplier Report";
        $q = $req->q;
        $provinsi = ($req->idProvinsi) ? $req->idProvinsi : null;
        $kategori = ($req->idKategori) ? $req->idKategori : null;
        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');

        // if ($q != "") {
        $pesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
            ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->distinct();

        if ($provinsi != "") {
            $pesan = $pesan
                ->Where('id_mst_province', '=', $provinsi);
        }

        if ($kategori != "") {
            $pesan = $pesan
                ->Where('id_csc_product', $kategori)
                ->whereIn('itdp_profil_eks.id', $arrayexporter);
        }
        $pesan = $pesan
            ->where('itdp_company_users.status', '1');

        if ($q != '') {
            $pesan = $pesan->where('company', 'ILIKE', '%' . $q . '%');
        }


        $pesan = $pesan->groupBy(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email',
            'itdp_company_users.id',
            'eks_business_entity.nmbadanusaha',
            'eks_business_entity.nmbadanusaha'
        );

        $pesan = $pesan->paginate(12)
            ->setPath('');

        $copesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
            ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');

        if ($provinsi != "") {
            $copesan = $copesan
                ->Where('itdp_profil_eks.id_mst_province', '=', $provinsi);
        }
        if ($kategori != "") {
            // $testpesan = $pesan->Where('csc_product_single.id_csc_product', $kategori)->distinct()->count();
            $copesan = $copesan->Where('id_csc_product', $kategori)
                ->whereIn('itdp_profil_eks.id', $arrayexporter);
        }

        $copesan = $copesan->where('itdp_company_users.status', '1');
        if ($q != '') {
            $copesan = $copesan
                ->where('company', 'ILIKE', '%' . $q . '%');
        }

        $copesan = $copesan->distinct()->get()->count('itdp_profil_eks.id');
        // dd($copesan);
        $pagination = $pesan->appends(array(
            'q' => $req->q,
            'q_hidden' => $q,
            'kategori' => $req->idKategori,
            'cari_kategori' => $req->idKategori,
            'idKategori' => $req->idKategori,
            'provinsi' => $req->idProvinsi,
            'cari_provinsi' => $req->idProvinsi,
            'idProvinsi' => $req->idProvinsi,
        ));
        // $pesan->appends($req->only('q'));
        $categoryutama = DB::table('csc_product')
            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->select(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->groupby(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->where('csc_product_single.status', 2)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        if (count($pesan) > 0) {
            return view('eksportir.annual_sales.indexadmin', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'));
        } else {
            return view('eksportir.annual_sales.indexadmin', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'))->withMessage('No Details found. Try to search again !');
        }
        // } else {
        //     return redirect('/eksportir/admin');
        // }
    }

    public function perwadag_search(Request $req)
    {
        $pageTitle = "Supplier Report";
        $q = $req->q;
        $provinsi = ($req->idProvinsi) ? $req->idProvinsi : null;
        $kategori = ($req->idKategori) ? $req->idKategori : null;

        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');

        // if ($q != "") {
        $pesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->distinct()
            ->where('itdp_company_users.status', '1')
            ->where('company', 'ILIKE', '%' . $q . '%');
        if ($kategori != "") {
            $pesan = $pesan->join('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->join('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
        }

        if ($provinsi != "") {
            $pesan = $pesan
                ->Where('itdp_profil_eks.id_mst_province', '=', $provinsi);
        }

        if ($kategori != "") {
            // $testpesan = $pesan->Where('csc_product_single.id_csc_product', $kategori)->distinct()->count();
            $pesan = $pesan->Where('id_csc_product', $kategori)
                ->whereIn('itdp_profil_eks.id', $arrayexporter);
        }

        $pesan = $pesan->groupBy(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email',
            'itdp_company_users.id',
            'eks_business_entity.nmbadanusaha',
            'eks_business_entity.nmbadanusaha'
        );

        $pesan = $pesan->paginate(12)
            ->setPath('');

        $copesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->distinct()
            ->where('itdp_company_users.status', '1')
            ->where('company', 'ILIKE', '%' . $q . '%');
        if ($kategori != "") {
            $copesan = $copesan->join('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->join('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
        }

        if ($provinsi != "") {
            $copesan = $copesan
                ->Where('itdp_profil_eks.id_mst_province', '=', $provinsi);
        }
        if ($kategori != "") {
            // $testpesan = $pesan->Where('csc_product_single.id_csc_product', $kategori)->distinct()->count();
            $copesan = $copesan->Where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
        }

        $copesan = $copesan->count('itdp_profil_eks.id');
        $pagination = $pesan->appends(array(
            'q' => $req->q,
            'q_hidden' => $q,
            'kategori' => $req->idKategori,
            'cari_kategori' => $req->idKategori,
            'idKategori' => $req->idKategori,
            'provinsi' => $req->idProvinsi,
            'cari_provinsi' => $req->idProvinsi,
            'idProvinsi' => $req->idProvinsi,
        ));
        // $pesan->appends($req->only('q'));
        $categoryutama = DB::table('csc_product')
            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->select(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->groupby(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->where('csc_product_single.status', 2)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        if (count($pesan) > 0) {
            return view('eksportir.annual_sales.indexperwadag', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'));
        } else {
            return view('eksportir.annual_sales.indexperwadag', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'))->withMessage('No Details found. Try to search again !');
        }
        // } else {
        //     return redirect('/eksportir/admin');
        // }
    }

    public function dinas_search(Request $req)
    {
        $pageTitle = "Supplier Report";
        $q = $req->q;
        $provinsi = DB::table('itdp_admin_dn')
            // ->select('itdp_admin_ln.id_country')
            ->where('itdp_admin_dn.id', '=', Auth::user()->id_admin_dn)
            ->value('id_country');
        $kategori = ($req->idKategori) ? $req->idKategori : null;

        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');

        // if ($q != "") {
        $pesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->distinct()
            ->where('itdp_company_users.status', '1')
            ->Where('itdp_profil_eks.id_mst_province', '=', $provinsi)
            ->where('company', 'ILIKE', '%' . $q . '%');
        if ($kategori != "") {
            $pesan = $pesan->join('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->join('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
        }

        if ($kategori != "") {
            // $testpesan = $pesan->Where('csc_product_single.id_csc_product', $kategori)->distinct()->count();
            $pesan = $pesan->Where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
        }

        $pesan = $pesan->groupBy(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email',
            'itdp_company_users.id',
            'eks_business_entity.nmbadanusaha',
            'eks_business_entity.nmbadanusaha'
        );

        $pesan = $pesan->paginate(12)
            ->setPath('');
        $copesan = DB::table('itdp_profil_eks')
            ->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
            ->distinct()
            ->where('itdp_company_users.status', '1')
            ->Where('itdp_profil_eks.id_mst_province', '=', $provinsi)
            ->where('company', 'ILIKE', '%' . $q . '%');
        if ($kategori != "") {
            $copesan = $copesan->join('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->join('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product');
        }

        if ($kategori != "") {
            // $testpesan = $pesan->Where('csc_product_single.id_csc_product', $kategori)->distinct()->count();
            $copesan = $copesan->Where('id_csc_product', $kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
        }

        $copesan = $copesan->count('itdp_profil_eks.id');
        $pagination = $pesan->appends(array(
            'q' => $req->q,
            'q_hidden' => $q,
            'kategori' => $req->idKategori,
            'cari_kategori' => $req->idKategori,
            'idKategori' => $req->idKategori,
            'provinsi' => $req->idProvinsi,
            'cari_provinsi' => $req->idProvinsi,
            'idProvinsi' => $req->idProvinsi,
        ));
        // $pesan->appends($req->only('q'));
        $categoryutama = DB::table('csc_product')
            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
            ->select(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->groupby(
                'csc_product.id',
                'csc_product.level_1',
                'csc_product.level_2',
                'csc_product.nama_kategori_en',
                'csc_product.nama_kategori_in',
                'csc_product.nama_kategori_chn',
                'csc_product.created_at',
                'csc_product.updated_at',
                'csc_product.type',
                'csc_product.logo'
            )
            ->where('csc_product_single.status', 2)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        if (count($pesan) > 0) {
            return view('eksportir.annual_sales.indexdinas', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'));
        } else {
            return view('eksportir.annual_sales.indexdinas', compact('pageTitle', 'kategori', 'provinsi', 'pesan', 'copesan', 'categoryutama', 'q'))->withMessage('No Details found. Try to search again !');
        }
        // } else {
        //     return redirect('/eksportir/admin');
        // }
    }

    public function datanyaadmin($id)
    {
        //        dd('hahahaha');
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getreporteksportir(Request $request)
    {
        // dd('tes');
        // dd($request->'search'));
        // dd($request);
        $pesan = DB::table('itdp_profil_eks')->select(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email'
        )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')->where('itdp_company_users.status', '1');

        // ->orderby('itdp_profil_eks.id','desc');
        // $pesan = DB::select("SELECT itdp_profil_eks.ID,itdp_profil_eks.company, itdp_profil_eks.addres, mst_province.province_en,
        //  itdp_profil_eks.fax, itdp_company_users.status, itdp_company_users.verified_at,itdp_company_users.email
        // FROM itdp_profil_eks JOIN itdp_company_users ON itdp_company_users.id_profil = itdp_profil_eks.id  
        // JOIN mst_province ON mst_province.id = itdp_profil_eks.id_mst_province 
        // WHERE itdp_company_users.status = '1' ORDER BY itdp_profil_eks.ID DESC ");
        // $pesan = DB::select("SELECT ID, company,addres,postcode,phone,fax FROM itdp_profil_eks ORDER BY ID DESC ");
        //    dd($pesan);

        // if ($request->filled('search')) {
        // dd($request->search);
        // $pesan->where('itdp_profil_eks.company', 'LIKE', "%{$request->get('search')}%")
        //         ->or;
        // }else{
        //     dd($request->search);

        // }
        // return Datatables::of($pesan)->filter(function ($query) use ($request) {

        //     if ($request->filled('search')) {
        //         $query->where('itdp_profil_eks.company', 'LIKE', "%{$request->get('search')}%")
        //             ->or;
        //     }

        // })->make(true);

        return DataTables::of($pesan)
            ->addColumn('company', function ($pesan) {
                return '<div align="left">' . $pesan->company . '</div>';
            })
            ->addColumn('addres', function ($pesan) {
                return '<div align="left">' . $pesan->addres . '</div>';
            })
            ->addColumn('province', function ($pesan) {
                return '<div align="left">' . $pesan->province_en . '</div>';
            })
            // ->addColumn('province', function ($pesan) {
            //     $provinsi = DB::table('mst_province')->where('mst_province.id', $pesan->id)->select ('province_en')->get();
            //     return '<div align="left">'. $provinsi->province_en.'</div>';
            // })

            ->addColumn('email', function ($pesan) {
                return '<div align="left">' . $pesan->email . '</div>';
            })
            ->addColumn('pic_name', function ($pesan) {
                $namapicnya = '';
                $no = 0;
                $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks', $pesan->id)->get();
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
            ->addColumn('pic_telp', function ($pesan) {
                $telppicnya = '';
                $no2 = 0;

                $datapic2 = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks', $pesan->id)->get();
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

            // ->addColumn('f3', function ($pesan) {
            //     return $pesan->postcode;
            // })
            // ->addColumn('f4', function ($pesan) {
            //     return $pesan->phone;
            // }) 
            // ->addColumn('f5', function ($pesan) {
            //     return $pesan->fax;
            // })
            ->addColumn('verify_date', function ($pesan) {
                return date('d-m-Y', strtotime($pesan->verified_at));
            })
            ->addIndexColumn()
            ->addColumn('action', function ($pesan) {
                return '<a href="' . url('eksportir/listeksportir/' . $pesan->id) . '" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-list text-white"></i></a>';
            })
            ->rawColumns(['action', 'company', 'addres', 'province', 'email', 'pic_name', 'pic_telp'])
            ->make(true);
    }



    public function printexportirreport(Request $request)
    {
        // dd(Auth::user());
        $id = null;
        $cat = null;
        $cari_kategori = $request->kat;
        $cari_provinsi = $request->cari_provinsi;
        $cari_company = $request->cari_company;

        $arrayexporter = DB::table('csc_product_single')->groupby('id_itdp_profil_eks')->where('status', '2')->pluck('id_itdp_profil_eks');

        if ($cari_kategori != null) {
            $id = DB::table('csc_product_single')
                ->leftjoin('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                ->where('id_csc_product', $cari_kategori)
                ->where('csc_product_single.status', '2')
                ->groupBy('id_itdp_company_user')
                ->pluck('id_itdp_company_user');

            $cat = DB::table('csc_product')->where('id', $cari_kategori)->first();
        }

        // User Dinas
        if (Auth::user()->id_group == 5) {
            $provinsi = DB::table('itdp_admin_dn')
                ->where('itdp_admin_dn.id', '=', Auth::user()->id_admin_dn)
                ->value('id_country');

            $pesan = DB::table('itdp_profil_eks')->select(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id as id_user',
                'eks_business_entity.nmbadanusaha',
                'eks_business_entity.nmbadanusaha'
            )
                ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')

                ->where('itdp_company_users.status', '1')
                ->where('mst_province.id', $provinsi);
            if ($cari_provinsi != '') {
                $pesan = $pesan->where('id_mst_province', $cari_provinsi);
            }
            if ($cari_kategori != '') {
                $pesan = $pesan->where('id_csc_product', $cari_kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
            }
            if ($cari_company != '') {
                $pesan = $pesan->where('company', 'ILIKE', '%' . $cari_company . '%');
            }
            $pesan = $pesan->distinct()->get();
            // dd($pesan);
        } else {
            // User selain Dinas
            $pesan = DB::table('itdp_profil_eks')
                ->select(
                    'itdp_profil_eks.id',
                    'itdp_profil_eks.company',
                    'itdp_profil_eks.addres',
                    'mst_province.province_en',
                    'itdp_profil_eks.fax',
                    'itdp_company_users.status',
                    'itdp_company_users.verified_at',
                    'itdp_company_users.email',
                    'itdp_company_users.id as id_user',
                    'eks_business_entity.nmbadanusaha'
                )
                ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
                ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
                ->leftjoin('csc_product_single', 'csc_product_single.id_itdp_profil_eks', 'itdp_profil_eks.id')
                ->leftjoin('csc_product', 'csc_product.id', 'csc_product_single.id_csc_product')

                ->where('itdp_company_users.status', '1');
            if ($cari_provinsi != '') {
                $pesan = $pesan->where('id_mst_province', $cari_provinsi);
            }
            if ($cari_kategori != '') {
                $pesan = $pesan->where('id_csc_product', $cari_kategori)->whereIn('itdp_profil_eks.id', $arrayexporter);
            }
            if ($cari_company != '') {
                $pesan = $pesan->where('company', 'ILIKE', '%' . $cari_company . '%');
            }
            $pesan = $pesan->orderByRaw('itdp_company_users.verified_at DESC NULLS LAST')->groupBy(
                'itdp_profil_eks.id',
                'itdp_profil_eks.company',
                'itdp_profil_eks.addres',
                'mst_province.province_en',
                'itdp_profil_eks.fax',
                'itdp_company_users.status',
                'itdp_company_users.verified_at',
                'itdp_company_users.email',
                'itdp_company_users.id',
                'eks_business_entity.nmbadanusaha'
            );
            $pesan = $pesan->distinct()->get();
        }

        // dd($pesan);
        return view('eksportir.annual_sales.printexcel', compact('pesan', 'cat'));
    }


    // $start = 0;

    // $spreadsheet = new Spreadsheet();
    // $sheet = $spreadsheet->getActiveSheet();

    // $styleArray = [
    //     'borders' => [
    //         'allBorders' => [
    //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //             'color' => ['argb' => '000000'],
    //         ],
    //     ],
    // ];
    // $sheet->getStyle('A1:I4')->getAlignment()->setHorizontal('center');

    // $sheet->getColumnDimension('A')->setWidth(8);
    // $sheet->getColumnDimension('B')->setWidth(40);
    // $sheet->getColumnDimension('C')->setWidth(40);
    // $sheet->getColumnDimension('D')->setWidth(30);
    // $sheet->getColumnDimension('E')->setWidth(30);
    // $sheet->getColumnDimension('F')->setWidth(30);
    // $sheet->getColumnDimension('G')->setWidth(30);
    // $sheet->getColumnDimension('H')->setWidth(30);
    // $sheet->getColumnDimension('I')->setWidth(30);

    // $sheet->setCellValue('A1', 'Data Exporter Report');


    // $sheet->setCellValue('A3', 'NO');
    // $sheet->setCellValue('B3', 'COMPANY');
    // $sheet->setCellValue('C3', 'ADDRESS');
    // $sheet->setCellValue('D3', 'PROVINCE');
    // $sheet->setCellValue('E3', 'EMAIL');
    // $sheet->setCellValue('F3', 'PIC NAME');
    // $sheet->setCellValue('G3', 'PIC TELEPHONE');
    // $sheet->setCellValue('H3', 'VERIFY DATE');

    // $spreadsheet->getActiveSheet()->mergeCells('A1:H1');

    // $rows = 4;
    // $no = $start + 1;
    // foreach ($datapic as $detail) {
    //     $hitung = 0;
    //     $namapicnya = '';
    //     $telppicnya = '';
    //     $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks', $detail->id)->get();
    //     if (count($datapic) > 0) {
    //         foreach ($datapic as $pic) {
    //             if ($hitung == 0) {
    //                 $namapicnya .=  $pic->name;
    //                 $telppicnya .= $pic->phone;
    //             } else {
    //                 $namapicnya .= ',' . $pic->name;
    //                 $telppicnya .= ',' . $pic->phone;
    //             }
    //             $hitung++;
    //         }
    //     }

    //     $sheet->setCellValue('A' . $rows, $no);
    //     $sheet->setCellValue('B' . $rows, $detail->company);
    //     $sheet->setCellValue('C' . $rows, $detail->addres);
    //     $sheet->setCellValue('D' . $rows, $detail->province_en);
    //     $sheet->setCellValue('E' . $rows, $detail->email);
    //     $sheet->setCellValue('F' . $rows, $namapicnya);
    //     $sheet->setCellValue('G' . $rows, $telppicnya);
    //     $sheet->setCellValue('H' . $rows, date('d-m-Y', strtotime($detail->verified_at)));
    //     $rows++;
    //     $no++;
    // }

    // $length = $rows - 1;
    // $sheet->getStyle('A3:H' . $length)->applyFromArray($styleArray);
    // $sheet->getStyle('A4:H' . $length)->getAlignment()->setHorizontal('left');
    // $sheet->getStyle('A3:H' . $length)->getAlignment()->setVertical('center');


    // $sheet->getStyle('A3:A' . $length)->getAlignment()->setHorizontal('center');

    // $sheet->getStyle('H3:H' . $length)->getAlignment()->setHorizontal('center');

    // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
    // $file_name = public_path() . "/excel/ExporterReport.xlsx";
    // $writer->save($file_name);

    // return response()->download($file_name);



    public function printpdfeksportir($id)
    {

        $pageTitle = "";
        $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('itdp_company_users.id_profil', $id)
            ->orderBy('csc_product_single.created_at', 'DESC')
            ->get();
        $annual = DB::table('itdp_profil_eks')->select(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email'
        )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->where('itdp_company_users.status', '1')
            ->where('itdp_profil_eks.id', '=', $id)
            ->get();
        $brand = DB::table('itdp_eks_product_brand')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $country = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->where('itdp_eks_country_patents.id_itdp_profil_eks', '=', $id)
            ->get();
        $procap = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $exdes = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $id)
            ->get();
        $portland = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->leftjoin('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $id)
            ->get();
        $exhib = DB::table('itdp_eks_event_participants')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $capacity = DB::table('itdp_production_capacity')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $raw = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', $id)
            ->get();
        $labor = DB::table('itdp_eks_labor')
            ->where('itdp_eks_labor.id_itdp_profil_eks', '=', $id)
            ->get();
        $consultan = DB::table('itdp_eks_consultation')
            ->where('id_profil_eks', '=', $id)
            ->get();
        $training = DB::table('itdp_eks_training')
            ->where('itdp_eks_training.id_itdp_profil_eks', '=', $id)
            ->get();
        $data = DB::table('itdp_profil_eks')
            ->where('id', '=', $id)
            ->get();
        $tax = DB::table('itdp_eks_taxes')
            ->where('itdp_eks_taxes.id_itdp_profil_eks', '=', $id)
            ->get();
        $contact = DB::table('itdp_contact_eks')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $service = DB::table('itdp_service_eks as a')->where('id_itdp_profil_eks', $id)->where('status', '!=', 0)->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadview('eksportir.annual_sales.cetakpdfnew', compact(
            'pageTitle',
            'id',
            'product',
            'annual',
            'brand',
            'country',
            'procap',
            'exdes',
            'portland',
            'exhib',
            'capacity',
            'raw',
            'labor',
            'consultan',
            'training',
            'tax',
            'contact',
            'service',
            'data'
        ));
        return $pdf->stream('Detail Eksportir.pdf');
    }

    public function listeksportir($id)
    {
        $data = DB::table('itdp_profil_eks')
            ->where('id', '=', $id)
            ->get();
        $id_profil = $id;
        foreach ($data as $datanya) {
            $company = $datanya->company;
        }
        //        dd($data);
        $pageTitle = "List Exporter";
        $id_profil = $id;

        $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('itdp_company_users.id_profil', $id)
            ->orderBy('csc_product_single.created_at', 'DESC')
            ->get();
        $annual = DB::table('itdp_profil_eks')->select(
            'itdp_profil_eks.id',
            'itdp_profil_eks.company',
            'itdp_profil_eks.addres',
            'mst_province.province_en',
            'itdp_profil_eks.fax',
            'itdp_company_users.status',
            'itdp_company_users.verified_at',
            'itdp_company_users.email'
        )
            ->leftjoin('itdp_company_users', 'itdp_company_users.id_profil', 'itdp_profil_eks.id')
            ->leftjoin('mst_province', 'mst_province.id', 'itdp_profil_eks.id_mst_province')
            ->where('itdp_company_users.status', '1')
            ->where('itdp_profil_eks.id', '=', $id)
            ->get();
        // $user = DB::table('itdp_eks_sales')
        //     ->where('id_itdp_profil_eks', '=', $id)
        //     ->get();
        $brand = DB::table('itdp_eks_product_brand')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $country = DB::table('itdp_eks_country_patents')
            ->select('itdp_eks_country_patents.id', 'itdp_eks_country_patents.bulan', 'itdp_eks_country_patents.tahun', 'mst_country.country', 'itdp_eks_product_brand.merek')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_country_patents.id_mst_country')
            ->leftjoin('itdp_eks_product_brand', 'itdp_eks_product_brand.id', '=', 'itdp_eks_country_patents.id_itdp_eks_product_brand')
            ->where('itdp_eks_country_patents.id_itdp_profil_eks', '=', $id)
            ->get();
        $procap = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $exdes = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', $id)
            ->get();
        $portland = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->leftjoin('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $id)
            ->get();
        $exhib = DB::table('itdp_eks_event_participants')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $capacity = DB::table('itdp_production_capacity')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $raw = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', $id)
            ->get();
        $labor = DB::table('itdp_eks_labor')
            ->where('itdp_eks_labor.id_itdp_profil_eks', '=', $id)
            ->get();
        $consultan = DB::table('itdp_eks_consultation')
            ->where('id_profil_eks', '=', $id)
            ->get();
        $training = DB::table('itdp_eks_training')
            ->where('itdp_eks_training.id_itdp_profil_eks', '=', $id)
            ->get();
        $tax = DB::table('itdp_eks_taxes')
            ->where('itdp_eks_taxes.id_itdp_profil_eks', '=', $id)
            ->get();
        $contact = DB::table('itdp_contact_eks')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
        $service = DB::table('itdp_service_eks as a')->where('id_itdp_profil_eks', $id)->where('status', '!=', 0)->orderBy('created_at', 'desc')->get();

        if (Auth::user()->id_group == 4) {
            return view('eksportir.annual_sales.listeksportir-backup', compact('id', 'pageTitle', 'company', 'data', 'id_profil'));
        } else {
            return view('eksportir.annual_sales.listeksportir', compact(
                'id',
                'pageTitle',
                'company',
                'data',
                'id_profil',
                'product',
                'annual',
                'brand',
                'country',
                'procap',
                'exdes',
                'portland',
                'exhib',
                'capacity',
                'raw',
                'labor',
                'consultan',
                'training',
                'tax',
                'contact',
                'service'
            ));
        }
    }
}
