<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Error;

class EventOrganizerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['pageTitle'] = "Event Organizer | List";

        if (Auth::guard('eksmp')->user()) {
            return redirect('login');
        } else {

            return view('master.event_organizer.index', $data);
        }
    }

    public function getData(Request $request)
    {
        DB::beginTransaction();
        try {
            $event_organizer = EventOrganizer::all();
            DB::commit();
            return \Yajra\DataTables\DataTables::of($event_organizer)
                ->addIndexColumn()
                ->addColumn('name_en', function ($value) {
                    return '<div class="float-left">' . $value->name_en . '</div>';
                })
                ->addColumn('address_en', function ($value) {
                    return '<div class="float-left">' . mb_strimwidth($value->addres_en, 0, 97, '...') . '</div>';
                })
                ->addColumn('phone', function ($value) {
                    return $value->phone;
                })
                ->addColumn('mobile', function ($value) {
                    return $value->mobile;
                })
                ->addColumn('email_en', function ($value) {
                    return $value->email_en;
                })
                ->addColumn('contact_person', function ($value) {
                    return $value->contact_person;
                })
                ->addColumn('action', function ($value) {
                    return '<div class="float-center">
            <div class="btn-group">
                <a href="' . route('master.event_organizer.view', $value->id) . '" class="btn btn-sm btn-info" title="View">&nbsp;<i class="fa fa-eye text-white"></i></a>&nbsp;&nbsp;
                  <a href="' . route('master.event_organizer.edit', $value->id) . '" class="btn btn-sm btn-success" title="Edit">&nbsp;<i class="fa fa-edit text-white"></i></a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Are You Sure ?\')" href="' . route('master.event_organizer.destroy', $value->id) . '" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash text-white"></i></a>
            </div>
            </div>';
                })
                ->rawColumns(['action', 'name_en', 'address_en', 'phone', 'mobile', 'email_en', 'contact_person'])
                ->make(true);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function create()
    {
        $data['pageTitle'] = "Event Organizer | List";
        $data['page'] = "create";
        $data['url'] = "event-organizer/store/create";
        $data['view'] = "";
        return view('master.event_organizer.form', $data);
    }

    public function store(Request $request, $param)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = EventOrganizer::orderby('id', 'desc')->first();
        if ($id) {
            $id = $id->id + 1;
        } else {
            $id = 1;
        }

        if ($param == 'create') {
            $data = EventOrganizer::insert([
                'id' => $id,
                'name_en' => $request->name_en,
                'addres_en' => $request->addres_en,
                'mobile' => $request->mobile,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'email_en' => $request->email_en,
                'contact_person' => $request->contact_person,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $explode_param = explode('_', $param);
            $param = $explode_param[0];
            $data = EventOrganizer::where('id', $explode_param[1])->update($request->except(['_token']));
        }

        if ($data) {
            $request->session()->now('success', 'Success ' . $param . ' Data');
            return redirect('/event-organizer/')->with('success', 'Success ' . $param . ' Data!');
        } else {
            $request->session()->now('failed', 'Failed ' . $param . ' Data');
            return redirect('/event-organizer/')->with('error', 'Failed ' . $param . ' Data!');
        }
    }

    public function view(Request $request, $id)
    {
        $data['pageTitle'] = "Event Organizer | List";
        $data['page'] = "view";
        $data['view'] = "disabled";
        $data['data'] = EventOrganizer::find($id);

        return view('master.event_organizer.form', $data);
    }
    public function edit(Request $request, $id)
    {
        $data['pageTitle'] = "Event Organizer | List";
        $data['page'] = "edit";
        $data['url'] = "event-organizer/store/update_" . $id;
        $data['data'] = EventOrganizer::find($id);
        $data['view'] = "";
        return view('master.event_organizer.form', $data);
    }
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = EventOrganizer::find($id);
            $data->delete();
            DB::commit();
            return redirect('/event-organizer')->with(['success' => 'Deleted successfully']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/event-organizer')->with(['error' => $th->getMessage()]);
        }
    }
}
