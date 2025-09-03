<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;
use Mail;

class TicketingSupportController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = 'Customer Support';
//        dd(Auth::guard('eksmp')->user());
        return view('ticketingsupport.index', compact('pageTitle'));
    }

    public function create()
    {
        return view('frontend.ticketing.create');
    }

    public function store(Request $req)
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $date = date('Y-m-d H:i:s');
        $type = Auth::guard('eksmp')->user()->type;

        $store = TicketingSupportModel::create([
            'id_pembuat' => $id_user,
            'name' => $req->name,
            'type' => $type,
            'email' => $req->email,
            'subyek' => $req->subject,
            'main_messages' => $req->messages,
            'status' => 1,
            'created_at' => $date
        ]);

        $id_ticketing = $store->id;

        //Tinggal Ganti Email1 dengan email kemendag
        $data = [
            'email' => $req->email,
            'email1' => 'yossandiimran02@gmail.com',
            'username' => $req->name,
            'main_messages' => $req->messages,
            'id' => $id_ticketing
        ];

        Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Requesting Customer Support');
        });

        return redirect('/ticketing');
    }

    public function getData()
    {

        $id_user = Auth::guard('eksmp')->user()->id;

        $type = Auth::guard('eksmp')->user()->type;

        $tick = TicketingSupportModel::from('ticketing_support as ts')
            ->where('ts.id_pembuat', $id_user)
            ->get();

        return \Yajra\DataTables\DataTables::of($tick)
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'No Respone';
                } else if ($data->status == 2) {
                    return 'Respone';
                } else if ($data->status == 3) {
                    return 'Closed';
                }
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 1) {
                    return '
							<center>
							<div class="btn-group">
								<a href="' . route('ticket_support.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
							</div>
							</center>
							';
                } else if ($data->status == 2) {
                    return '
              <center>
              <div class="btn-group">
								<a href="' . route('ticket_support.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a href="' . route('ticket_support.vchat', $data->id) . '" class="btn btn-sm btn-warning">&nbsp;<i class="fa fa-envelope text-white"></i>&nbsp;Chat&nbsp;</a>&nbsp;&nbsp;
              </div>
              </center>
              ';
                } else if ($data->status == 3) {
                    return '
              <center>
              <div class="btn-group">
								<a href="' . route('ticket_support.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Chat Ini ?\')" href="' . route('ticket_support.delete', $data->id) . '" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
              </div>
              </center>
              ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function vchat($id)
    {
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->orderby('cts.messages_send', 'asc')
            ->get();

        $users = TicketingSupportModel::where('id', $id)->first();

        $pageTitle = "Chat Customer Support";
        $jenis = 'chat';

        return view('ticketingsupport.vchat', compact('jenis', 'pageTitle', 'users', 'messages'));

    }

    public function sendchat(Request $req)
    {
		date_default_timezone_set('Asia/Jakarta');
        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('ticketing/chatview/' . $req->id);
    }

    public function view($id)
    {
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->orderby('cts.messages_send', 'asc')
            ->get();

        $users = TicketingSupportModel::where('id', $id)->first();

        $pageTitle = "Chat Customer Support";
        $jenis = 'view';
        return view('ticketingsupport.vchat', compact('jenis', 'pageTitle', 'users', 'messages'));
    }

    public function destroy($id)
    {
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            Session::flash('error', 'Success Delete Data');
            return redirect('/ticketing');
        } else {
            Session::flash('error', 'Failed Delete Data');
            return redirect('/ticketing');
        }
    }

}
