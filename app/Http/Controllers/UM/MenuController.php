<?php

namespace App\Http\Controllers\UM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;
use Session;

class MenuController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $pageTitle = 'Menus';
      $menu = DB::table('menu')->get();
      return view('UM.menu.index', compact('pageTitle', 'menu'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $pageTitle = 'Menus';
      $url = "/menu_save";
      return view('UM.menu.form', compact('url', 'pageTitle'));
   }

   public function create_submenu($id)
   {
      $pageTitle = 'Menus';
      $url = "/submenu_save";
      $menu = DB::table('menu')->where('parent', null)->get();
      $res = DB::table('menu')->where('id_menu', $id)->first();
      $parent = DB::table('menu')->where('id_menu', $res->parent)->first();
      return view('UM.menu.add2', compact('url', 'pageTitle', 'res', 'parent', 'menu'));
   }


   public function store_submenu(Request $request)
   {
      $messages = [
         'required' => ':attribute wajib diisi'
      ];

      $this->validate($request, [
         'nama_submenu' => 'required',
         'url' => 'required',
         'menu_induk' => 'required'
      ], $messages);

      $insert = DB::table('menu')->insert([
         "menu_name" => $request->nama_submenu,
         "url" => $request->url,
         "order" => $request->urutan,
         "icon" => $request->icon,
         "ket" => $request->ket,
         "parent" => $request->menu_induk
      ]);

      if ($insert) {
         Session::flash('success', 'Menambah Data');
         return redirect('/menus');
      } else {
         Session::flash('failed', 'Menambah Data');
         return redirect('/menus');
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $insert = DB::table('menu')->insert([
         "menu_name" => $request->nama_menu,
         "url" => $request->url,
         "order" => $request->urutan,
         "icon" => $request->icon,
         "ket" => $request->ket,
         "parent" => $request->menu_induk
      ]);


      if ($insert) {
         Session::flash('success', 'Menambah Data');
         return redirect('/menus');
      } else {
         Session::flash('failed', 'Menambah Data');
         return redirect('/menus');
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $pageTitle = "Menus";
      $url = "/menu_update/" . $id;
      $res = DB::table('menu')->where('id_menu', $id)->first();
      $parent = DB::table('menu')->where('id_menu', $res->parent)->first();
      return view('UM.menu.addm', compact('id', 'url', 'res', 'pageTitle', 'parent'));
   }

   public function edit_submenu($id)
   {
      // echo "a";die();
      $pageTitle = "Menus";
      $url = "/submenu_update/" . $id;
      $menu = DB::table('menu')->where('parent', null)->get();
      $res = DB::table('menu')->where('id_menu', $id)->first();
      $parent = DB::table('menu')->where('id_menu', $res->parent)->first();
      return view('UM.menu.add2', compact('url', 'res', 'pageTitle', 'parent', 'menu'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      $update = DB::table('menu')->where('id_menu', $id)->update([
         "menu_name" => $request->nama_menu,
         "url" => $request->url,
         "order" => $request->urutan,
         "icon" => $request->icon,
         "ket" => $request->ket
      ]);


      if ($update) {
         Session::flash('success', 'Mengupdate Data');
         return redirect('/menus');
      } else {
         Session::flash('failed', 'Mengupdate Data');
         return redirect('/menus');
      }
   }

   public function update_submenu(Request $request, $id)
   {
      //  dd($request->all());
      $update = DB::table('menu')->where('id_menu', $id)->update([
         "menu_name" => $request->nama_submenu,
         "url" => $request->url,
         "order" => $request->urutan,
         "icon" => $request->icon,
         "ket" => $request->ket,
         "parent" => $request->menu_induk
      ]);

      if ($update) {
         Session::flash('success', 'Mengupdate Data');
         return redirect('/menus');
      } else {
         Session::flash('failed', 'Mengupdate Data');
         return redirect('/menus');
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $delete = DB::table('menu')->where('id_menu', $id)->delete();

      if ($delete) {
         Session::flash('success', 'Menghapus Data');
         return redirect('/menus');
      } else {
         Session::flash('failed', 'Menghapus Data');
         return redirect('/menus');
      }
   }

   public function search_menu(Request $req)
   {
      $pageTitle = "Menus";
      $q = $req->q;
      if ($q != "") {
         $menu = DB::table('menu')->where('menu_name', 'ILIKE', '%' . $q . '%')->orderby('id_menu', 'asc')->paginate(12)->setPath('');

         $pagination = $menu->appends(array('q' => $req->q));
         $menu->appends($req->only('q'));
         if (count($menu) > 0) {
            return view('UM.menu.index', compact('pageTitle', 'menu'));
         } else {
            return view('UM.menu.index', compact('pageTitle', 'menu'))->withMessage('No Details found. Try to search again !');
         }
      } else {
         return redirect('/menus');
      }
   }
}
