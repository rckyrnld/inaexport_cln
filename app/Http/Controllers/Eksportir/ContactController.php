<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContactController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Contact";
        $url = '/eksportir/contact_save';
        return view('eksportir.contact.index', compact('pageTitle','url'));
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/contact_save';
        $pageTitle = 'Add Contact';
        return view('eksportir.contact.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_contact_eks')->insert([
            'id_itdp_profil_eks' => $id_user,
            'name' => $request->name,
            'job_title' => $request->position,
            'phone' => $request->phone,
        ]);
        return redirect('profil')->with('success','Success Add Data');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_contact_eks')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('contact.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                <a href="' . route('contact.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i>
                </a>
                <a href="' . route('contact.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        $pageTitle = 'Detail Contact';
        $url = '/eksportir/contact_update';

        $data = DB::table('itdp_contact_eks')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.contact.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
//        dd($id);
        $pageTitle = 'Detail Contact';
        $data = DB::table('itdp_contact_eks')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.contact.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_contact_eks')->where('id', $id)
            ->delete();
        return redirect('profil')->with('error','Success Delete Data');
    }

    public function update(Request $request)
    {
//        dd($request);
        DB::table('itdp_contact_eks')->where('id', $request->id_sales)
            ->update([
                'name' => $request->name,
                'job_title' => $request->position,
                'phone' => $request->phone,
            ]);
        return redirect('profil')->with('success','Success Update Data');
    }

    public function indexadmin($id)
    {
//        dd($id);
        $pageTitle = "Contact";
        return view('eksportir.contact.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
        $user = DB::table('itdp_contact_eks')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('name', function ($mjl) {
                return '<div align="left">'.$mjl->name. '</div>';
            })
            ->addColumn('job_title', function ($mjl) {
                return '<div align="left">'.$mjl->job_title. '</div>';
            })
			->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('contact.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
               
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action','name','job_title'])
            ->make(true);
    }
}
