<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\LinkTutorial;
use App\Models\LinkTutorialUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Error;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class LinkTutorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['pageTitle'] = "Link Tutorial | List";

        if (Auth::guard('eksmp')->user()) {
            return redirect('login');
        } else {

            return view('master.link_tutorial.index', $data);
        }
    }

    public function getData(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = DB::table('link_tutorial')
                ->select('link_tutorial.*', 'link_tutorial_user_type.user_type')
                ->leftjoin('link_tutorial_user_type', 'link_tutorial_user_type.id', '=', 'link_tutorial.link_tutorial_user_type_id')
                ->get();
            DB::commit();
            return \Yajra\DataTables\DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('user_type', function ($value) {
                    return $value->user_type;
                })
                ->addColumn('link', function ($value) {
                    $link = '';
                    $separate_link = explode('%#%', $value->link);
                    $separate_title = explode('%#%', $value->title);
                    foreach ($separate_link as $key => $val) {
                        $link .= $separate_title[$key]. "<br/><a href='" . $val . "' target='_blank'>(" . $val . ")</a><br/><br/>";
                    }
                    return $link;
                })
                ->addColumn('action', function ($value) {
                    return '<div class="float-center">
            <div class="btn-group">
                <a href="' . route('master.link_tutorial.view', $value->id) . '" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                  <a href="' . route('master.link_tutorial.edit', $value->id) . '" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('master.link_tutorial.destroy', $value->id) . '" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
            </div>
            </div>';
                })
                ->rawColumns(['action', 'link'])
                ->make(true);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function create()
    {
        $data['pageTitle'] = "Link Tutorial | Create";
        $data['page'] = "create";
        $data['url'] = "link-tutorial/store/create";
        $data['view'] = "";
        $data['user_types'] = LinkTutorialUserType::all();
        return view('master.link_tutorial.form', $data);
    }

    public function store(Request $request, $param)
    {
        date_default_timezone_set('Asia/Jakarta');
        // Validasi jika user menginsert comma, maka berikan keterangan kalau tidak boleh menginsert dengan character comma
        if ($param == 'create') {
            // Create action
            //Validation 
            $validatedData = $request->validate(
                [
                    'link_tutorial_user_type_id' => ['required', 'unique:link_tutorial,link_tutorial_user_type_id'],
                ],
                [
                    'link_tutorial_user_type_id.unique' => 'The User Type has already been taken.'
                ]
            );
        } else {
            // Update action
            $explode_param = explode('_', $param);
            $param = $explode_param[0];
            $id = $explode_param[1];

            //Validation 
            $validatedData = $request->validate(
                [
                    'link_tutorial_user_type_id' => ['required', 'unique:link_tutorial,link_tutorial_user_type_id,' . $id],
                ],
                [
                    'link_tutorial_user_type_id.unique' => 'The User Type has already been taken.'
                ]
            );
        }

        $links = '';
        $titles = '';
        $separator = '%#%';
        foreach ($request->link as $link) {
            if (count($request->link) > 1) {
                $links .= $link . '' . $separator;
            } else {
                $links .= $link;
            }
        }

        foreach ($request->title as $title) {
            if (count($request->title) > 1) {
                $titles .= $title . '' . $separator;
            } else {
                $titles .= $title;
            }
        }
        $lastCharLink = substr($links, -3);
        $lastCharTitle = substr($titles, -3);
        
        
        $new_link = '';
        $new_title = '';
        if ($lastCharLink == '%#%') {
            $new_link = substr_replace($links, "", -3);
        } else {
            $new_link = $links;
        }
        if ($lastCharTitle == '%#%') {
            $new_title = substr_replace($titles, "", -3);
        } else {
            $new_title = $titles;
        }
        
        // Delete old data if exist
        LinkTutorial::where('link_tutorial_user_type_id', $request->link_tutorial_user_type_id)->delete();

        // Insert new data
        $data = LinkTutorial::insert([
            'link_tutorial_user_type_id' => $request->link_tutorial_user_type_id,
            'link' => $new_link,
            'title' => $new_title,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($data) {
            $request->session()->now('success', 'Success ' . $param . ' Data');
            return redirect('/link-tutorial/')->with('success', 'Success ' . $param . ' Data!');
        } else {
            $request->session()->now('failed', 'Failed ' . $param . ' Data');
            return redirect('/link-tutorial/')->with('error', 'Failed ' . $param . ' Data!');
        }
    }

    public function view(Request $request, $id)
    {
        $data['pageTitle'] = "Link Tutorial | View";
        $data['page'] = "view";
        $data['view'] = "disabled";
        $data['user_types'] = LinkTutorialUserType::all();
        $data['data'] = LinkTutorial::find($id);

        return view('master.link_tutorial.form', $data);
    }
    public function edit(Request $request, $id)
    {
        $data['pageTitle'] = "Link Tutorial | Edit";
        $data['page'] = "edit";
        $data['url'] = "link-tutorial/store/update_" . $id;
        $data['data'] = LinkTutorial::find($id);
        $data['view'] = "";
        $data['user_types'] = LinkTutorialUserType::all();

        return view('master.link_tutorial.form', $data);
    }
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = LinkTutorial::find($id);
            $data->delete();
            DB::commit();
            return redirect('/link-tutorial')->with(['success' => 'Deleted successfully']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/link-tutorial')->with(['error' => $th->getMessage()]);
        }
    }
}
