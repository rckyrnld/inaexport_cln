<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    //
    public function index()
    {
        $pageTitle = 'Publication';
        $data = DB::table('publication')->orderby('created_at', 'desc')->get();
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id_group == 1)
                return view('publication.index', compact('pageTitle', 'data'));
            else
                return redirect('/home');
        } else {
            return redirect('/');
        }
    }
    public function index_create()
    {
        $pageTitle = 'Publication';
        $page = 'create';
        $url = "/publication/store";
        if (Auth::user()->id_group == 1) {
            return view('publication.create', compact('url', 'pageTitle', 'page'));
        } else {
            return redirect('/perwakilan/research-corner');
        }
    }
    public function store(Request $request)
    {
        // dd($request->all()); 
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $destination = 'uploads\publication\cover\\';
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $nama_image = time() . '_Cover ' .'_' . $request->file('cover')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $cover, $nama_image);
        }

        $destination = 'uploads\publication\file\\';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $nama_file = time() . '_file ' . '_' . $request->file('file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
        } else {
            $nama_file = $request->lastest_file;
        }
        $data = DB::table('publication')->insert([
            'judul' => $request->title_in,
            'judul_en' => $request->title_en,
            'tipe' => $request->type,
            'publish_date' => $request->date,
            'cover' => $nama_image,
            'file' => $nama_file,
            'status' => True,
            'created_at' => $date
        ]);
        Session::flash('success', 'Data Tersimpan');
        return redirect('publication');

    }
    public function index_update($id)
    {
        $pageTitle = 'Publication || Update';
        $page = 'create';
        $data = DB::table('publication')->where('id',$id)->first();
        // dd($data);
        $url = "/publication/edit";
        if (Auth::user()->id_group == 1) {
            return view('publication.edit', compact('data','url', 'pageTitle', 'page'));
        } else {
            return redirect('/perwakilan/research-corner');
        }
    }
    public function edit(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $id = $request->idnya;
        $destination = 'uploads\publication\cover\\';
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $nama_image = time() . '_Cover ' .'_' . $request->file('cover')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $cover, $nama_image);
        }

        $destination = 'uploads\publication\file\\';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $nama_file = time() . '_file ' . '_' . $request->file('file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
        } else {
            $nama_file = $request->lastest_file;
        }
        $data = DB::table('publication')->where('id',$id)->update([
            'judul' => $request->title_in,
            'judul_en' => $request->title_en,
            'tipe' => $request->type,
            'publish_date' => $request->date,
            'cover' => $nama_image,
            'file' => $nama_file,
            'status' => True,
            'updated_at' => $date
        ]);
        Session::flash('success', 'Data Tersimpan');
        return redirect('publication');

    }
    public function destroy($id){
        
        $remove =  DB::table('publication')->where('id',$id)->delete();
        // dd($request);
        return redirect()->back();
    }  
}
