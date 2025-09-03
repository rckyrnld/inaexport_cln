<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use App\Models\EventInterest;
use App\Models\TrainingInterest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mail;


class ManagementUserController extends Controller
{

    // use AuthenticatesUsers;
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    //     public function downloadResearch(Request $request)
    //     {
    //         date_default_timezone_set('Asia/Jakarta');
    //         $id_profil = $request->id_profil;
    //         $id_reseach = $request->id_research;
    //         $date = date('Y-m-d H:i:s');
    //         $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $id_reseach)->first();
    // //        dd($checking);
    //         if ($checking) {
    //             $research = DB::table('csc_research_corner')
    //                 ->where('id', '=', $id_reseach)
    //                 ->get();
    //             foreach ($research as $img) {
    //                 $coba = $img->exum;
    //             }
    //             $path = ($coba) ? url('uploads/Market Research/File/' . $coba) : url('image/nia3.png');
    //             $meta = [
    //                 'code' => 200,
    //                 'message' => 'Success',
    //                 'status' => 'OK'
    //             ];
    //             $data = $path;
    //             $res['meta'] = $meta;
    //             $res['data'] = $data;
    //             return response($res);
    //         } else {
    //             $research = DB::table('csc_research_corner')
    //                 ->where('id', '=', $id_reseach)
    //                 ->get();
    //             foreach ($research as $img) {
    //                 $coba = $img->exum;
    //             }
    //             $path = ($coba) ? url('uploads/Market Research/File/' . $coba) : url('image/nia3.png');
    // //            dd($path);
    //             $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
    //             if ($id) {
    //                 $id = $id->id + 1;
    //             } else {
    //                 $id = 1;
    //             }
    //             DB::table('csc_download_research_corner')->insert([
    //                 'id' => $id,
    //                 'id_itdp_profil_eks' => $id_profil,
    //                 'id_research_corner' => $id_reseach,
    //                 'id_mst_country' => '64',
    //                 'waktu' => $date
    //             ]);

    // //                $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
    // //                if ($notif) {
    // //                    DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
    // //                        'status_baca' => 1
    // //                    ]);
    // //                }

    //             $before = DB::table('csc_research_corner')->where('id', $id_reseach)->first();
    //             DB::table('csc_research_corner')->where('id', $id_reseach)->update([
    //                 'download' => $before->download + 1
    //             ]);
    //             $meta = [
    //                 'code' => 200,
    //                 'message' => 'Success',
    //                 'status' => 'OK'
    //             ];
    //             $data = $path;
    //             $res['meta'] = $meta;
    //             $res['data'] = $data;
    //             return response($res);
    //         }
    //     }
    public function downloadResearch(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_profil = $request->id_profil;
        $id_reseach = $request->id_research;
        $date = date('Y-m-d H:i:s');
        $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $id_reseach)->first();
        //        dd($checking);

        $rc = DB::table('csc_research_corner')->where('id', $id_reseach)->first();
        // $url = url('/') . '/uploads/Market Research/File/' . $rc->exum;
        $url = ($rc) ? url('uploads/Market Research/File/' . $rc->exum) : url('image/nia3.png');

        $arr = explode(',', $rc->category);
        $cat = (isset($arr[0]) && $arr[0] != '') ? $arr[0] : 0;
        $lvl1 = (isset($arr[1]) && $arr[1] != '') ? $arr[1] : 0;
        $lvl2 = (isset($arr[2]) && $arr[2] != '') ? $arr[2] : 0;


        $vibe = DB::table('csc_product_single')
            ->where('status', '2')
            ->where('id_itdp_company_user', $request->id_user)
            ->where(function ($q) use ($cat) {
                return $q->where('id_csc_product', $cat);
            })
            ->where(function ($q) use ($lvl1) {
                return $q->where('id_csc_product_level1', $lvl1);
            })
            ->where(function ($q) use ($lvl2) {
                return $q->where('id_csc_product_level2', $lvl2);
            })
            ->first();
        // dd($vibe);
        if ($checking && isset($vibe)) {
            $research = DB::table('csc_research_corner')
                ->where('id', '=', $id_reseach)
                ->get();
            foreach ($research as $img) {
                $coba = $img->exum;
            }
            $path = ($coba) ? url('uploads/Market Research/File/' . $coba) : url('image/nia3.png');
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
            $res['meta'] = $meta;
            $res['data'] = $data;
            $res['test'] = ["atas"];

            return response($res);
        } elseif (isset($vibe)) {
            //             $research = DB::table('csc_research_corner')
            //                 ->where('id', '=', $id_reseach)
            //                 ->get();
            //             foreach ($research as $img) {
            //                 $coba = $img->exum;
            //             }
            //             $path = ($coba) ? url('uploads/Market Research/File/' . $coba) : url('image/nia3.png');
            // //            dd($path);
            //             $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
            //             if ($id) {
            //                 $id = $id->id + 1;
            //             } else {
            //                 $id = 1;
            //             }
            //             DB::table('csc_download_research_corner')->insert([
            //                 'id' => $id,
            //                 'id_itdp_profil_eks' => $id_profil,
            //                 'id_research_corner' => $id_reseach,
            //                 'id_mst_country' => '64',
            //                 'waktu' => $date
            //             ]);

            // //                $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
            // //                if ($notif) {
            // //                    DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
            // //                        'status_baca' => 1
            // //                    ]);
            // //                }

            //             $before = DB::table('csc_research_corner')->where('id', $id_reseach)->first();
            //             DB::table('csc_research_corner')->where('id', $id_reseach)->update([
            //                 'download' => $before->download + 1
            //             ]);
            $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
            if ($id) {
                $id = $id->id + 1;
            } else {
                $id = 1;
            }
            DB::table('csc_download_research_corner')->insert([
                'id' => $id,
                'id_itdp_profil_eks' => $id_profil,
                'id_research_corner' => $id_reseach,
                'waktu' => $date
            ]);

            // incase error, id_terkait nya belum tau dapatnya darimana
            $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $request->id)->where('untuk_id',  $request->id_user)->first();
            if ($notif) {
                DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $request->id)->where('untuk_id',  $request->id_user)->update([
                    'status_baca' => 1
                ]);
            }

            $before = DB::table('csc_research_corner')->where('id', $id_reseach)->first();
            DB::table('csc_research_corner')->where('id', $id_reseach)->update([
                'download' => $before->download + 1
            ]);
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $url;
            $res['meta'] = $meta;
            $res['data'] = $data;
            $res['test'] = ["bawah"];
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = ["nope"];
            $res['meta'] = $meta;
            $res['data'] = $data;
            $res['test'] = ["nope"];
        }
        return response($res);
    }

    public function joinTraining(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $store = DB::table('training_join')->insert([
            'id_training_admin' => $request->id_training,
            'id_profil_eks' => $request->id_user,
            'date_join' => date('Y-m-d H:i:s'),
            'status' => 0
        ]);

        $notif = DB::table('notif')->insert([
            'dari_id' => $request->id_user,
            'untuk_id' => 1,
            'keterangan' => '<b>Request To Join Training',
            'waktu' => date('Y-m-d H:i:s'),
            'url_terkait' => 'admin/training/view',
            'status_baca' => 0,
            'id_terkait' => $request->id_training,
            'to_role' => 1
        ]);
        if (count($store) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function joinEvent(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        $id_user = $request->id_user;
        $event = DB::table('event_company_add')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_event_detail' => $request->id_event,
            'status' => 1,
            'waktu' => $datenow
        ]);
        if (count($event) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function createTicketing(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $store = TicketingSupportModel::create([
            'id_pembuat' => $request->id_user,
            'name' => $request->name,
            'type' => $request->type,
            'email' => $request->email,
            'subyek' => $request->subject,
            'main_messages' => $request->messages,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $id_ticketing = $store->id;

        //Tinggal Ganti Email1 dengan email kemendag
        //kementerianperdagangan.max@gmail.com
        $data = [
            'email' => $request->email,
            'email1' => env('MAIL_USERNAME', 'no-reply@inaexport.id'),
            'username' => $request->name,
            'main_messages' => $request->messages,
            'id' => $id_ticketing,
            'bu' => '',
            'company' => $request->name
        ];

        $ket = "Ticketing was created by " . $request->name;
        $ket2 = "You was create ticketing !";
        $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','" . $request->name . "','" . $request->id_user . "','Super Admin','1','" . $ket . "','admin/ticketing/chatview','" . $id_ticketing . "','" . date('Y-m-d H:i:s') . "','0')
		");

        Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Requesting Ticketing Support');
        });
        if (count($store) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function data_ticketing(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $tick = TicketingSupportModel::from('ticketing_support as ts')
            ->where('ts.id_pembuat', $id_user)
            ->orderby('ts.created_at', 'desc')
            ->get();

        if (count($tick) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $tick;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $tick;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function vchat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->id_tiketing;
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->selectRaw('cts.id as id_chating_tiketing, cts.id_ticketing_support, cts.sender, cts.reciver, cts.messages, cts.messages_send
            ,ts.id_pembuat,ts.type,ts.name,ts.email,ts.subyek,ts.main_messages,ts.status,ts.created_at,ts.updated_at, cts.file')
            ->orderby('cts.messages_send', 'asc')
            ->get();
        //        dd($messages);
        for ($i = 0; $i < count($messages); $i++) {
            $ext = pathinfo($messages[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg', 'PNG'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }
            $jsonResult[$i]["id"] = $messages[$i]->id_chating_tiketing;
            $jsonResult[$i]["id_ticketing_support"] = $messages[$i]->id_ticketing_support;
            $jsonResult[$i]["sender"] = $messages[$i]->sender;
            $jsonResult[$i]["reciver"] = $messages[$i]->reciver;
            $jsonResult[$i]["messages"] = $messages[$i]->messages;
            $jsonResult[$i]["messages_send"] = $messages[$i]->messages_send;
            $jsonResult[$i]["id_pembuat"] = $messages[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $messages[$i]->type;
            $jsonResult[$i]["name"] = $messages[$i]->name;
            $jsonResult[$i]["email"] = $messages[$i]->email;
            $jsonResult[$i]["subyek"] = $messages[$i]->subyek;
            $jsonResult[$i]["main_messages"] = $messages[$i]->main_messages;
            $jsonResult[$i]["status"] = $messages[$i]->status;
            $jsonResult[$i]["created_at"] = $messages[$i]->created_at->toDateTimeString();
            $jsonResult[$i]["updated_at"] = $messages[$i]->updated_at->toDateTimeString();
            $jsonResult[$i]["file"] = $path = ($messages[$i]->file) ? url('/uploads/ticketing/' . $messages[$i]->file) : "";
            $jsonResult[$i]["ext"] = $extension;
        }
        //        dd($jsonResult);
        $users = TicketingSupportModel::where('id', $id)->first();

        if (count($messages) > 0) {
            return response($jsonResult);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
    }

    public function count_tkt_chat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->id_tiketing;
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->orderby('cts.messages_send', 'asc')
            ->count();

        $users = TicketingSupportModel::where('id', $id)->first();

        /*
        if (count($messages) > 0) {
            return response($messages);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
        */
        if ($messages) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = [
                'count' => $messages
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
    }

    public function count_inq_chat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_inquiry = $request->id_inquiry;

        $user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $id_inquiry)
            ->where('type', 'importir')
            ->orderBy('created_at', 'desc')
            ->count();

        if ($user) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = [
                'count' => $user
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
    }

    public function count_notif_bb(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $id_role = $request->id_role;

        $user = DB::table('notif')
            ->where('untuk_id', $id_user)
            ->where('to_role', $id_role)
            ->where('status_baca', 0)
            ->orderBy('created_at', 'desc')
            ->count();

        if ($user) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = [
                'count' => $user
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
    }

    public function count_notif_all(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $id_role = $request->id_role;

        $user = DB::table('notif')
            ->where('untuk_id', $id_user)
            ->where('to_role', $id_role)
            ->orderBy('created_at', 'desc')
            ->count();

        if ($user) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = [
                'count' => $user
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
        }
    }

    public function sendchat(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');

        $destination = 'uploads\ticketing\\';
        if ($req->hasFile('upload_file')) {
            $file1 = $req->file('upload_file');
            $nama_file = $req->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file);
        } else {
            $nama_file = null;
        }
        $chat = ChatingTicketingSupportModel::insertGetId([
            'id_ticketing_support' => $req->id_tiketing,
            'sender' => $req->id_pembuat,
            'reciver' => '0',
            'file' => $nama_file,
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);

        $user = DB::table('chating_ticketing_support')
            ->where('id', '=', $chat)
            ->get();

        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg', 'PNG'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_ticketing_support"] = $user[$i]->id_ticketing_support;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $jsonResult[$i]["reciver"] = $user[$i]->reciver;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["messages_send"] = $user[$i]->messages_send;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ticketing/' . $user[$i]->file) : "";
            $jsonResult[$i]["ext"] = $extension;
        }
        //        dd($jsonResult);
        if (count($jsonResult) > 0) {
            return response($jsonResult);
        } else {
            return response($jsonResult);
        }
    }

    public function destroytiketing(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id = $request->id_tiketing;
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getTransaksi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($request->id_role == 2) {
            $data = DB::table('csc_transaksi')
                ->where('id_eksportir', $request->id_user)
                ->orderBy('id_transaksi', 'desc')
                ->get();
            $jsonResult = array();
            for ($i = 0; $i < count($data); $i++) {
                $jsonResult[$i]["id_transaksi"] = $data[$i]->id_transaksi;
                $jsonResult[$i]["id_pembuat"] = $data[$i]->id_pembuat;
                $jsonResult[$i]["by_role"] = $data[$i]->by_role;
                $jsonResult[$i]["id_eksportir"] = $data[$i]->id_eksportir;
                $jsonResult[$i]["id_terkait"] = $data[$i]->id_terkait;
                $jsonResult[$i]["origin"] = $data[$i]->origin;
                $jsonResult[$i]["type_tracking"] = $data[$i]->type_tracking;
                $jsonResult[$i]["no_tracking"] = $data[$i]->no_tracking;
                $jsonResult[$i]["created_at"] = $data[$i]->created_at;
                $jsonResult[$i]["status_transaksi"] = $data[$i]->status_transaksi;
                $jsonResult[$i]["eo"] = $data[$i]->eo;
                $jsonResult[$i]["neo"] = $data[$i]->neo;
                $jsonResult[$i]["ntp"] = $data[$i]->ntp;
                $jsonResult[$i]["total"] = $data[$i]->total;
                $by_role = $data[$i]->by_role;
                //                if ($by_role == 2 || 3) {
                ////                    $jsonResult[$i]["nama_pembeli"] = getCompanyNameImportir($data[$i]->id_pembuat);
                //                }
                if ($by_role == 1 || $by_role == 4) {
                    $jsonResult[$i]["nama_pembeli"] = getAdminName($data[$i]->id_pembuat);
                } else {
                    $jsonResult[$i]["nama_pembeli"] = getCompanyNameImportir($data[$i]->id_pembuat);
                }
            }
        } else if ($request->id_role == 3) {
            $data = DB::table('csc_transaksi')
                ->where('id_pembuat', $request->id_user)
                ->orderBy('id_transaksi', 'desc')
                ->get();
            $jsonResult = array();
            for ($i = 0; $i < count($data); $i++) {
                $jsonResult[$i]["id_transaksi"] = $data[$i]->id_transaksi;
                $jsonResult[$i]["id_pembuat"] = $data[$i]->id_pembuat;
                $jsonResult[$i]["by_role"] = $data[$i]->by_role;
                $jsonResult[$i]["id_eksportir"] = $data[$i]->id_eksportir;
                $jsonResult[$i]["id_terkait"] = $data[$i]->id_terkait;
                $jsonResult[$i]["origin"] = $data[$i]->origin;
                $jsonResult[$i]["type_tracking"] = $data[$i]->type_tracking;
                $jsonResult[$i]["no_tracking"] = $data[$i]->no_tracking;
                $jsonResult[$i]["created_at"] = $data[$i]->created_at;
                $jsonResult[$i]["status_transaksi"] = $data[$i]->status_transaksi;
                $jsonResult[$i]["eo"] = $data[$i]->eo;
                $jsonResult[$i]["neo"] = $data[$i]->neo;
                $jsonResult[$i]["ntp"] = $data[$i]->ntp;
                $jsonResult[$i]["total"] = $data[$i]->total;
                $by_role = $data[$i]->by_role;
                //                if ($by_role == 2 || 3) {
                ////                    $jsonResult[$i]["nama_pembeli"] = getCompanyNameImportir($data[$i]->id_pembuat);
                //                }
                if ($by_role == 1 || $by_role == 4) {
                    $jsonResult[$i]["nama_pembeli"] = getAdminName($data[$i]->id_pembuat);
                } else {
                    $jsonResult[$i]["nama_pembeli"] = getCompanyNameImportir($data[$i]->id_pembuat);
                }
            }
        }
        if (count($data) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function detailTransaksi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = DB::table('csc_transaksi')
            ->where('id_transaksi', $request->id_transaksi)
            ->first();

        if ($user->origin == 1) {

            if (empty($user->tp) || $user->tp == null) {
                $pricenya = "0";
            } else {
                $pricenya = number_format($user->tp, 0, ',', '.');
            }

            $user->sources = "Inquiry";

            if ($user->by_role == 1) {
                $user->created_by = "Admin";
            } else if ($user->by_role == 4) {
                $user->created_by = "Representative";
            } else if ($user->by_role == 3) {
                $carih = DB::select("select a.*,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil=b.id and a.id='" . $user->id_pembuat . "'");
                foreach ($carih as $ch) {
                    $user->created_by = " - " . $ch->badanusaha . " " . $ch->company . " (" . $ch->username . ")";
                }
            } else {
                $user->created_by = "Importer";
            }

            $user->addres = null; //
            $user->category_product = null; //
            $user->kind_of_subject = null; //
            $user->date = null; //
            $user->quantity = ($user->eo) ? $user->eo : 1; //
            $user->satuan = $user->neo; //
            $user->price = $pricenya; //
            $user->kurs = null; //
            $user->subject = null; //
            $user->messages = null; //
            $user->file = null; //
            $user->id_br = null; //

        } else if ($user->origin == 2) {
            $user->sources = "Buying Request"; //

            $r1 = DB::select("select * from csc_buying_request where id='" . $user->id_terkait . "'");
            foreach ($r1 as $ip1) {
                $id_buyingnya = $ip1->id;
                $by_role = $ip1->by_role;
                $id_pembuat = $ip1->id_pembuat;
                $cr = explode(',', $ip1->id_csc_prod);
                $hitung = count($cr);
                $datenya = $ip1->date;
                $quantitynya = $ip1->eo;
                $neonya = $ip1->neo;
                $kursnya = $ip1->ntp;
                $subjectnya = $ip1->subyek;
                $messagesnya = $ip1->spec;
                $filenya = $path = url('uploads/buy_request/' . $ip1->files);
                $pricenya = number_format($ip1->tp, 0, ',', '.');
                $semuacat = "";
                for ($a = 0; $a < ($hitung - 1); $a++) {
                    $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                    foreach ($namaprod as $prod) {
                        $napro = $prod->nama_kategori_en;
                    }
                    $semuacat = $semuacat . "- " . $napro;
                }
            }
            if ($by_role == 1) {
                $addres = "";
                $user->created_by = "Admin"; //
            } else if ($by_role == 4) {
                $addres = "";
                $user->created_by = "Perwakilan"; //
            } else if ($by_role == 3) {
                $usre = DB::select("select b.company,b.badanusaha,b.addres,b.city from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $id_pembuat . "'");
                foreach ($usre as $imp) {
                    $addres = $imp->addres . " , " . $imp->city;
                    $user->created_by = "Importir - " . $imp->badanusaha . " " . $imp->company; //
                }
            }

            $user->addres = $addres; //
            $user->category_product = $semuacat; //
            $user->kind_of_subject = "Offer to buy"; //
            $user->date = $datenya; //
            $user->quantity = $quantitynya; //
            $user->satuan = $neonya; //
            $user->price = $pricenya; //
            $user->kurs = $kursnya; //
            $user->subject = $subjectnya; //
            $user->messages = $messagesnya; //
            $user->file = ($filenya) ? $filenya : null; //
            $user->id_br = $id_buyingnya; //
        }

        //        $dataProduka->company_name = DB::table('itdp_profil_eks')->where('id', $dataProduka->id_itdp_profil_eks)->first()->company;
        //        $dataProduka->csc_product_desc = DB::table('csc_product')->where('id', $dataProduka->id_csc_product)->first()->nama_kategori_en;
        //        $dataProduka->csc_product_level1_desc = ($dataProduka->id_csc_product_level1) ? DB::table('csc_product')->where('id', $dataProduka->id_csc_product_level1)->first()->nama_kategori_en : null;
        //        $dataProduka->csc_product_level2_desc = ($dataProduka->id_csc_product_level2) ? DB::table('csc_product')->where('id', $dataProduka->id_csc_product_level2)->first()->nama_kategori_en : null;
        //        $dataProduka->link_image_1 = $path = ($dataProduka->image_1) ? url('uploads/buy_request/' . $dataProduka->id . '/' . $dataProduka->image_1) : url('image/nia3.png');
        //        $dataProduka->link_image_2 = $path = ($dataProduka->image_2) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_2) : url('image/nia3.png');
        //        $dataProduka->link_image_3 = $path = ($dataProduka->image_3) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_3) : url('image/nia3.png');
        //        $dataProduka->link_image_4 = $path = ($dataProduka->image_4) ? url('uploads/Eksportir_Product/Image/' . $dataProduka->id . '/' . $dataProduka->image_4) : url('image/nia3.png');
        //        $dataProduka->name_mst_hscodes = ($dataProduka->id_mst_hscodes) ? DB::table('mst_hscodes')->where('id', $dataProduka->id_mst_hscodes)->first()->desc_eng : "";

        //        for ($i = 0; $i < count($user); $i++) {
        //
        //            $jsonResult[$i]["id_transaksi"] = $user[$i]->id_transaksi;
        //            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_pembuat;
        //            $jsonResult[$i]["by_role"] = $user[$i]->by_role;
        //            $jsonResult[$i]["id_eksportir"] = $user[$i]->id_eksportir;
        //            $jsonResult[$i]["id_terkait"] = $user[$i]->id_terkait;
        //            $jsonResult[$i]["origin"] = $user[$i]->origin;
        //            $jsonResult[$i]["type_tracking"] = $user[$i]->type_tracking;
        //            $jsonResult[$i]["no_tracking"] = $user[$i]->no_tracking;
        //            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
        //            $jsonResult[$i]["status_transaksi"] = $user[$i]->status_transaksi;
        //            $jsonResult[$i]["eo"] = $user[$i]->eo;
        //            $jsonResult[$i]["neo"] = $user[$i]->neo;
        //            $jsonResult[$i]["tp"] = $user[$i]->tp;
        //            $jsonResult[$i]["ntp"] = $user[$i]->ntp;
        //            $jsonResult[$i]["total"] = $user[$i]->total;
        //
        //        }
        //        dd($user);
        //        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $user;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getNotif(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $id_role = $request->id_role;
        $offsite = $request->offsite;
        $querynotifa = DB::select("select * from notif where untuk_id='" . $id_user . "' order by id_notif desc LIMIT 10 OFFSET " . $offsite);
        if (count($querynotifa) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $querynotifa;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function updateNotif(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_notif = $request->id_notif;
        $update = DB::select("update notif set status_baca='1' where id='" . $id_notif . "'");
        if (count($update) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $update;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function save_trx(Request $request)
    {
        //        $id_br = $request->id_br;
        //        dd($id_br);
        date_default_timezone_set('Asia/Jakarta');
        $ch1 = str_replace(".", "", $request->tp);
        $ch2 = str_replace(",", ".", $ch1);
        if ($request->origin == 2) {
            $update = DB::select("update csc_buying_request set eo='" . $request->eo . "', neo='" . $request->neo . "',tp='" . $ch2 . "',ntp='" . $request->ntp . "' where id='" . $request->id_br . "' ");
        }
        if ($request->tipekirim == 1) {
            if ($request->by_role == 3) {
                $caripembuat = DB::select("select * from itdp_company_users where id='" . $request->id_pembuat . "'");
                foreach ($caripembuat as $cp) {
                    $mailimp = $cp->email;
                }
                $ket = "Transaction Created by " . $request->username;
                $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('3','Eksportir','" . $request->id_user . "','Importir','" . $request->id_pembuat . "','" . $ket . "','detailtrx','" . $request->id_transaksi . "','" . date('Y-m-d H:i:s') . "','0')
			");

                $ket2 = "Transaction Created by " . $request->username;
                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('1','Eksportir','" . $request->id_user . "','Super Admin','1','" . $ket2 . "','br_trx2','" . $request->id_transaksi . "','" . date('Y-m-d H:i:s') . "','0')
			");

                $data = [
                    'email' => "",
                    'email1' => $mailimp,
                    'username' => $request->username,
                    'main_messages' => "",
                    'bur' => "",
                    'receiver' => "",
                    'bu' => "",
                    'id' => $request->id_transaksi
                ];
                Mail::send('UM.user.sendtrx', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Transaction Created By ');
                });

                $data22 = [
                    'email' => "",
                    'email1' => env('MAIL_USERNAME', 'no-reply@inaexport.id'),
                    'username' => $request->username,
                    'main_messages' => "",
                    'admin' => "",
                    'bu' => "",
                    'company' => "",
                    'id' => $request->id_transaksi
                ];
                Mail::send('UM.user.sendtrx2', $data22, function ($mail) use ($data22) {
                    $mail->to($data22['email1'], $data22['username']);
                    $mail->subject('Transaction Created By ');
                });
            } else {
                $ket2 = "Transaction Created by " . $request->username;
                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('1','Eksportir','" . $request->id_user . "','Super Admin','1','" . $ket2 . "','br_trx2','" . $request->id_transaksi . "','" . date('Y-m-d H:i:s') . "','0')
			");

                $data22 = [
                    'email' => "",
                    'email1' => env('MAIL_USERNAME', 'no-reply@inaexport.id'),
                    'username' => $request->username,
                    'main_messages' => "",
                    'admin' => "",
                    'bu' => "",
                    'company' => "",
                    'id' => $request->id_transaksi
                ];
                Mail::send('UM.user.sendtrx2', $data22, function ($mail) use ($data22) {
                    $mail->to($data22['email1'], $data22['username']);
                    $mail->subject('Transaction Created By');
                });
            }

            $ket3 = "Transaction Created By You";
            $insertnotif3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('2','Eksportir','" . $request->id_user . "','Eksportir','" . $request->id_user . "','" . $ket3 . "','input_transaksi','" . $request->id_transaksi . "','" . date('Y-m-d H:i:s') . "','0')
			");
            $data33 = [
                'email' => "",
                'email1' => $request->email,
                'username' => $request->username,
                'main_messages' => "",
                'receiver' => "",
                'bu' => "",
                'sender' => "",
                'url' => "",
                'id' => $request->id_transaksi
            ];
            Mail::send('UM.user.sendtrx3', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject('Transaction Created By ');
            });
        }
        $update = DB::select("update csc_transaksi set total='" . ($request->eo * $ch2) . "' , eo='" . $request->eo . "', neo='" . $request->neo . "',tp='" . $ch2 . "',ntp='" . $request->ntp . "', status_transaksi='" . $request->tipekirim . "', type_tracking='" . $request->type_tracking . "',no_tracking='" . $request->no_track . "' where id_transaksi='" . $request->id_transaksi . "' ");
        if ($update) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = "";
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }


    public function eventInterest(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        $id_user = $request->id_user;
        $event = EventInterest::updateOrCreate(
            ['id_profile' => $id_user, 'id_event' => $request->id_event],
            ['created_at' => $datenow]
        );
        if (count($event) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function trainingInterest(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $store = TrainingInterest::updateOrCreate(
            ['id_profile' => $request->id_user, 'id_training' => $request->id_training],
            ['created_at' => date('Y-m-d H:i:s')]
        );

        if (count($store) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function read_all_notif(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = $request->id_user;
        $update = DB::select("update notif set status_baca='1' where untuk_id='" . $id_user . "' and to_role !='1' or to_role !='4'");

        if ($update) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            return $res;
        }
    }

    public function read_one_notif(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_notif = $request->id_notif;
        $update = DB::select("update notif set status_baca='1' where id_notif='" . $id_notif . "'");

        if ($update) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            return $res;
        }
    }

    public function aktifasiulang(Request $request)
    {

        $id_user = $request->id_user;
        $update = DB::select("update itdp_company_users set status='1' where id='" . $id_user . "'");
        if ($update) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            //$res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            //$res['data'] = $data;
            return $res;
        }
    }

    public function detail_dokumen(Request $request)
    {
        $id_user = $request->id_user;
        $cek = DB::table('itdp_company_users')
            ->where('id', $id_user)
            ->get();
        foreach ($cek as $jyp) {
            $rolenya = $jyp->id_role;
        }
        //2 eksportir & 3 importir
        if ($rolenya == 3) {
        } else {
            $data = DB::table('itdp_company_users')
                ->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                ->leftjoin('mst_province', 'mst_province.id', '=', 'itdp_profil_eks.id_mst_province')
                ->where('itdp_company_users.id', $id_user)
                ->get();


            $jsonResult = array();
            for ($i = 0; $i < count($data); $i++) {
                $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
                $jsonResult[$i]["email"] = $data[$i]->email;
                if ($data[$i]->badanusaha == null | empty($data[$i]->badanusaha)) {
                    $jsonResult[$i]["badanusaha"] = "";
                } else {
                    $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
                }
                $jsonResult[$i]["company"] = $data[$i]->company;
                $jsonResult[$i]["id_role"] = "2";
                $jsonResult[$i]["role_desc"] = "Seller/Eksportir";
                $jsonResult[$i]["addres"] = $data[$i]->addres;
                $jsonResult[$i]["city"] = $data[$i]->city;
                $jsonResult[$i]["postcode"] = $data[$i]->postcode;
                $jsonResult[$i]["phone"] = $data[$i]->phone;
                $jsonResult[$i]["fax"] = $data[$i]->fax;
                $jsonResult[$i]["website"] = $data[$i]->website;
                $jsonResult[$i]["province"] = $data[$i]->id_mst_province;
                $jsonResult[$i]["province_desc"] = $data[$i]->province_in;
                if ($data[$i]->doc == null | empty($data[$i]->doc)) {
                    $jsonResult[$i]["dokumen"] = "";
                } else {
                    $jsonResult[$i]["dokumen"] = url('eksportir/' . $data[$i]->doc);
                }
                if ($data[$i]->employe == null | empty($data[$i]->employe)) {
                    $jsonResult[$i]["employe"] = "";
                } else {
                    $jsonResult[$i]["employe"] = $data[$i]->employe;
                }
                if ($data[$i]->npwp == null | empty($data[$i]->npwp)) {
                    $jsonResult[$i]["npwp"] = "-";
                } else {
                    $jsonResult[$i]["npwp"] = $data[$i]->npwp;
                }
                if ($data[$i]->uploadnpwp == null | empty($data[$i]->uploadnpwp)) {
                    $jsonResult[$i]["uploadnpwp"] = "";
                } else {
                    $jsonResult[$i]["uploadnpwp"] = url('eksportir/' . $data[$i]->uploadnpwp);
                }
                if ($data[$i]->tdp == null | empty($data[$i]->tdp)) {
                    $jsonResult[$i]["tdp"] = "-";
                } else {
                    $jsonResult[$i]["tdp"] = $data[$i]->tdp;
                }
                if ($data[$i]->uploadtdp == null | empty($data[$i]->uploadtdp)) {
                    $jsonResult[$i]["uploadtdp"] = "";
                } else {
                    $jsonResult[$i]["uploadtdp"] = url('eksportir/' . $data[$i]->uploadtdp);
                }
                if ($data[$i]->siup == null | empty($data[$i]->siup)) {
                    $jsonResult[$i]["siup"] = "-";
                } else {
                    $jsonResult[$i]["siup"] = $data[$i]->siup;
                }
                if ($data[$i]->uploadsiup == null | empty($data[$i]->uploadsiup)) {
                    $jsonResult[$i]["uploadsiup"] = "";
                } else {
                    $jsonResult[$i]["uploadsiup"] = url('eksportir/' . $data[$i]->uploadsiup);
                }
                $jsonResult[$i]["situ"] = $data[$i]->situ;
                $jsonResult[$i]["scoope"] = $data[$i]->id_eks_business_size;
                $jsonResult[$i]["tob"] = $data[$i]->id_business_role_id;
                $jsonResult[$i]["status"] = $data[$i]->status;
                if ($data[$i]->status == 1) {
                    $jsonResult[$i]["status_desc"] = "Verified";
                } else if ($data[$i]->status == 2) {
                    $jsonResult[$i]["status_desc"] = "Not Verified";
                } else {
                    $jsonResult[$i]["status_desc"] = "-";
                }

                //$jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Importir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            

            }
        }

        if ($data) {
            // $countall = count($data2);
            // $bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            /*
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
            ];
			*/

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function ceknpwp(Request $request)
    {
        $npwpz =    str_replace(".", "", $request->npwp);
        $npwpx =    str_replace("-", "", $npwpz);
        $curl = curl_init();
        // dd($npwpx);die();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://perizinan.kemendag.go.id/index.php/website_api/kswp/153/" . $npwpx,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: f3e1235e-d688-a840-efd7-c7eb19691494",
                "x-api-key: kpzgMbTYlv2VmXSeOf03KxirsyBIGt48LcRPd7nN"
            ),
        ));

        $server_output = curl_exec($curl);

        curl_close($curl);

        $r = json_decode($server_output);
        // dd($r);
        // echo json_encode(array('status'=> $r->status,'nama'=> $r->nama));
        if ($r != null) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $r;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            //            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function published_br_join(Request $req)
    {
        // $q1 = DB::table('csc_buying_request_join')->where('id', $req->id_join)->first();
        // dd($q1);
        $q2 = DB::table('csc_buying_request')
            ->select('csc_buying_request.*', 'itdp_profil_imp.company', 'itdp_profil_imp.badanusaha')
            ->join('itdp_company_users', 'csc_buying_request.id_pembuat', '=', 'itdp_company_users.id')
            ->join('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('csc_buying_request.id', $req->id_br)->where('csc_buying_request.publish', true)->first();
        $cat1 = '';
        $cat2 = '';
        $cat3 = '';
        if (isset($q2)) {
            $lvl1 = $q2->id_csc_prod_cat_level1;
            $lvl2 = $q2->id_csc_prod_cat_level2;

            $vibe = DB::table('csc_product_single')
                ->where('id_itdp_company_user', $req->id_user)
                ->where('id_csc_product', $q2->id_csc_prod_cat)
                ->when(($lvl1 > 0), function ($q) use ($lvl1) {
                    return $q->where('id_csc_product_level1', $lvl1);
                })
                ->when(($lvl2 > 0), function ($q) use ($lvl2) {
                    return $q->where('id_csc_product_level2', $lvl2);
                })
                ->first();

            $cat1 = DB::table('csc_product')->where('id', $q2->id_csc_prod_cat)->first()->nama_kategori_en;
            $cat2 = ($lvl1 > 0) ? ' » ' . DB::table('csc_product')->where('id', $lvl1)->first()->nama_kategori_en : '';
            $cat3 = ($lvl2 > 0) ? ' » ' . DB::table('csc_product')->where('id', $lvl2)->first()->nama_kategori_en : '';
        } else {
            $vibe = null;
        }


        if (isset($vibe)) {
            $meta = [
                'code' => 200,
                'message' => 'Found',
                'status' => 'Success'
            ];
            $data = $q2;
            $res['meta'] = $meta;
            $res['data'] = $data;
            $res['data']->category_prod = $cat1 . $cat2 . $cat3;
            return $res;
        } else {
            $meta = [
                'code' => 500,
                'message' => 'Zero Vibes',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }
    }

    public function interest_process(Request $req)
    {
        $date = date('Y-m-d H:i:s');
        $id_eks = $req->id_user;
        $databr = DB::select("select * from csc_buying_request where id='" . $req->id . "'");
        if (isset($databr[0]->by_role) == 3) {
            $bentukpt = getExBadanImportir($databr[0]->id_pembuat);
            $namapembuat = getCompanyNameImportir($databr[0]->id_pembuat);
            // $namapembuat = getPerwakilanName($databr[0]->id_pembuat );
            $zzz = $databr[0]->id_pembuat;
        }

        if ($req->id_role == 2 && $databr[0]->publish) {
            $cekada = DB::select("select * from csc_buying_request_join where id_br='" . $req->id . "' and id_eks='" . $id_eks . "'");
            if (count($cekada) == 0) {
                $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
                    ('" . $req->id . "','" . (int)$id_eks . "','" . Date('Y-m-d H:m:s') . "')");

                //NOTIF
                $id_terkait = "";
                $ket = "Buying Request created by " . $bentukpt . $namapembuat;
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                    ('2','" . $namapembuat . "','" . $zzz . "','" . getCompanyName($id_eks) . "','" . (int)$id_eks . "','" . $ket . "','br_list','" . $id_terkait . "','" . $date . "','0')
                ");
                //END NOTIF

                //EMAIL
                $caridataeks = DB::select("select * from itdp_company_users where id ='" . $id_eks . "'");

                if (count($caridataeks) != 0) {
                    foreach ($caridataeks as $vm) {
                        $vc1 = $vm->email;
                    }
                    $datacomeks = DB::select("select * from itdp_profil_eks where id = '" . $vm->id_profil . "'");
                    $data = [
                        'username' => getCompanyName($zzz),
                        'id2' => '0',
                        'nama' => getCompanyNameImportir($zzz),
                        'company' => $datacomeks[0]->company,
                        'password' => '',
                        'email' => $vc1,
                        'bu' => $datacomeks[0]->badanusaha,
                        'bur' => getExBadanImportir($zzz)
                    ];
                    Mail::send('UM.user.emailbr2', $data, function ($mail) use ($data) {
                        $mail->to($data['email'], $data['username']);
                        $mail->subject('Buying Request Was Created');
                    });
                }
                //END EMAIL
            }
        }

        //log
        $insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('" . $req->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','" . $req->id_role . "'
			,'" . $id_eks . "','4','Published Inquiry')");
        //end log

        $baliknya = 'sukses';
        // return json_encode($baliknya);

        $meta = [
            'code' => 200,
            'message' => 'Ndak tau berhasil apa ndak',
            'status' => 'Success'
        ];
        $data = $insert;
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
    }

    public function checkProductSupllier(Request $request)
    {
        if ($request->id == '') {
            $meta = [
                'code' => 404,
                'message' => 'Kami tidak menemukan Event yang Anda cari',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        } else {
            $check_product = DB::table('csc_product_single')
                ->where('id_itdp_company_user', '=', Auth::user()->id)
                ->where('status', '=', 2)
                ->get();

            $id_profil = Auth::user()->id_profil;
            $cek = DB::table('event_interest')->where('id_profile', $id_profil)->where('id_event', $request->id)->first();

            if ($cek != null || $cek != '') {
                $meta = [
                    'code' => 201,
                    'message' => 'Anda sudah terdaftar di Trade Event ini',
                    'status' => 'Failed'
                ];
                $data = "unavailable";
                $res['meta'] = $meta;
                $res['data'] = $data;
                return $res;
            } else {
                if (count($check_product) > 0) {
                    $meta = [
                        'code' => 200,
                        'message' => 'Company has product has been verified',
                        'status' => 'Success'
                    ];
                    $data = "available";
                    $res['meta'] = $meta;
                    $res['data'] = $data;
                    return $res;
                } else {
                    $meta = [
                        'code' => 202,
                        'message' => 'Untuk mendaftar Anda harus mempunyai setidaknya 1 produk yang sudah diverifikasi oleh Admin',
                        'status' => 'Failed'
                    ];
                    $data = "unavailable";
                    $res['meta'] = $meta;
                    $res['data'] = $data;
                    return $res;
                }
            }
        }
    }
}
