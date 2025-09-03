<?php

namespace App\Http\Controllers\UM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;
use Session;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	/*
     public function __construct()
    {
        $this->middleware('bauth');
    } */

    public function index()
    {
		// echo "a";die();
        $pageTitle = 'Group';
        $label = 'Create Group Name';
        $group = DB::table('group')->get();
        $url = '/group_save';
        return view('UM.group.index',compact('pageTitle','group','url','label'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = Group::create(['group_name' => $request->group_name]);

        if($insert){
            Session::flash('success','Berhasil Menambah Data');
            return redirect('/group');
        }else{
            Session::flash('failed','Gagal Menambah Data');
            return redirect('/group');
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
        $pageTitle = 'Group';
        $label = 'Update Group Name';
        $group = DB::table('group')->get();
        $res = Group::find($id);
        $url = '/group_update/'.$id;
        return view('UM.group.index',compact('pageTitle','group','url','res','label'));
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
        $update = Group::where('id_group',$id)->update(['group_name' => $request->group_name]);

         if($update){
            Session::flash('success','Berhasil Mengubah Data');
            return redirect('/group');
        }else{
            Session::flash('failed','Gagal Mengubah Data');
            return redirect('/group');
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
        $delete = Group::destroy($id);

        if($delete){
            Session::flash('success','Berhasil Menghapus Data');
            return redirect('/group');
        }else{
            Session::flash('failed','Gagal Menghapus Data');
            return redirect('/group');
        }
    }
}
