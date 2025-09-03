<?php

namespace App\Http\Controllers\VideoConference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItdpAdminUser;
use App\Models\ZoomParticipant;
use App\Models\ItdpCompanyUser;
use App\Models\MasterCountry;
use App\Models\VideoConference;
use App\Models\VideoConferenceParticipant;
use App\Models\ZoomRoom;
use App\Models\ZoomToken;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class VideoConferenceController extends Controller
{
    public function index(Request $request)
    {
        if (env('ZOOM_OWN_URL') == null) {
            return 'Can not read env file';
        }
        $data['ZOOM_CLIENT_ID'] = env('ZOOM_CLIENT_ID');
        $data['ZOOM_REDIRECT_URI'] = env('ZOOM_REDIRECT_URI');
        $data['ZOOM_OWN_URL'] = env('ZOOM_OWN_URL');

        if ($this->get_meetings() != 'Token Expired') {
            $data['origin_data'] = json_decode($this->get_meetings(), true);

            if ($data['origin_data'] != null) {
                $merge = [];
                // Merge data dari zoom dengan password yang tersimpan di local
                foreach ($data['origin_data']['meetings'] as $key => $d) {
                    $local_meeting_data = ZoomRoom::with('country')->where('meeting_id', $d['id'])->first();

                    $array_participants = [];
                    // Get only from database
                    if ($local_meeting_data != null) {
                        foreach ($local_meeting_data->itdp_company_user as $user_company) {
                            if ($user_company->id_role == 2) {
                                $array_participants['exportir'][] = $user_company->email;
                            }
                            if ($user_company->id_role == 3) {
                                $array_participants['buyer'][] = $user_company->email;
                            }
                        };

                        foreach ($local_meeting_data->itdp_admin_user as $user_admin) {
                            if ($user_admin->id_group == 4) {
                                $array_participants['perwadag'][] = $user_admin->email;
                            }
                        };
                        $merge['meetings'][] = array_merge($data['origin_data']['meetings'][$key], [
                            'password' => ($local_meeting_data != '') ? $local_meeting_data->password : '',
                            'perwadag_quota' => ($local_meeting_data != '') ? $local_meeting_data->perwadag_quota : 0,
                            'exportir_quota' => ($local_meeting_data != '') ? $local_meeting_data->exportir_quota : 0,
                            'buyer_quota' => ($local_meeting_data != '') ? $local_meeting_data->buyer_quota : 0,
                            'country' => ($local_meeting_data != '') ? $local_meeting_data->country->country : 0,
                            'is_passed' => (Carbon::parse($d['start_time']) > Carbon::now()) ? false : true,
                            'potential_transaction_value' => ($local_meeting_data != '') ? $local_meeting_data->potential_transaction_value : 0,
                            'need_approval' => ($local_meeting_data != '') ? $local_meeting_data->need_approval : '',
                            'participants' => $array_participants
                        ]);
                    }
                }
                unset($data['origin_data']['meetings']);
                $data['data'] = array_merge($data['origin_data'], $merge);

                // dd($data['data']['meetings']);

                // Jika setelah di merge datanya masih kosong maka buat array meeting kosong
                if (!isset($data['data']['meetings'])) {
                    $data['data']['meetings'] = [];
                } else {
                    // Sorting data yg lama di bawah
                    $start_time = array_column($data['data']['meetings'], 'start_time');
                    array_multisort($start_time, SORT_DESC, $data['data']['meetings']);
                }
            } else {
                // Jika memang belum ada data meeting
                $data['data']['meetings'] = [];
            }
            $data['is_login'] = (ZoomToken::first()  != null) ? true : false;
        } else {
            $data['data']['meetings'] = [];
            $data['is_login'] = false;
        }

        $data['country'] = MasterCountry::orderBy('country')->get();

        $data['pageTitle'] = "Business Matching";
        return view('event_zoom.index', $data);
    }
    // Get access token
    public function get_access_token()
    {
        $access_token = ZoomToken::all();
        return json_decode($access_token);
    }

    // Get referesh token
    public function get_refresh_token()
    {
        $result = $this->get_access_token();
        $refreshToken = $result[0]->refresh_token;
        return $refreshToken;
    }

    // Update access token
    public function update_access_token($token)
    {
        $check = ZoomToken::first();
        if ($check != null) {
            $id = ZoomToken::first()->id;
            ZoomToken::whereId($id)->update(
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'],
                    'token_type' => $token['token_type'],
                    'expires_in' => $token['expires_in'],
                    'scope' => $token['scope'],
                ]
            );
        } else {
            ZoomToken::create(
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'],
                    'token_type' => $token['token_type'],
                    'expires_in' => $token['expires_in'],
                    'scope' => $token['scope'],
                ]
            );
        }
    }

    public function callback(Request $request)
    {
        try {
            if (env('ZOOM_OWN_URL') == null) {
                return 'Can not read env file';
            }

            $client = new Client(['base_uri' => env('ZOOM_URI')]);

            $response = $client->request('POST', 'oauth/token', [
                "headers" => [
                    "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => env('ZOOM_REDIRECT_URI')
                ],
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            $this->update_access_token($token);

            session()->put('status', 'Login');
            return redirect('/event_zoom');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function get_meetings()
    {
        if (env('ZOOM_OWN_URL') == null) {
            return 'Can not read env file';
        }
        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        if (count($arr_token) == 0) {
            $data = "";
            return $data;
        } else {
            $accessToken = $arr_token[0]->access_token;

            try {
                $response = $client->request('GET', 'users/me/meetings', [
                    "headers" => [
                        "Authorization" => "Bearer $accessToken"
                    ]
                ]);

                $data = json_encode(json_decode($response->getBody()), true);
                return $data;
            } catch (Exception $e) {
                if (401 == $e->getCode()) {

                    return "Token Expired";

                    // $refresh_token = $this->get_refresh_token();

                    // $client = new Client(['base_uri' => env('ZOOM_URI')]);

                    // $response = $client->request('POST', 'oauth/token', [
                    //     "headers" => [
                    //         "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
                    //     ],
                    //     'form_params' => [
                    //         "grant_type" => "refresh_token",
                    //         "refresh_token" => $refresh_token
                    //     ],
                    // ]);
                    // $this->update_access_token($response->getBody());

                    // $this->create_meeting(30);
                } else {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function create_meeting(Request $request)
    {

        if (env('ZOOM_OWN_URL') == null) {
            return 'Can not read env file';
        }

        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        $accessToken = $arr_token[0]->access_token;

        DB::beginTransaction();

        try {
            //
            // The type of meeting:
            // * `1` — An instant meeting.
            // * `2` — A scheduled meeting.
            // * `3` — A recurring meeting with no fixed time.
            // * `8` — A recurring meeting with fixed time. (This can only be one of 1,2,3,8)

            // Pre Schedule Meeting
            // Whether to create a prescheduled meeting. This field only supports schedule meetings (`2`):
            // * `true` — Create a prescheduled meeting.
            // * `false` — Create a regular meeting.

            // json
            // * `topic` => The meeting's topic.
            // * `type` => The type of meeting (see above)
            $datetime = explode(" ", $request->start_time);
            $date =  date('Y-m-d', strtotime($datetime[0]));
            $time =  $datetime[1] . ":00";
            // if you have userid of user than change it with me in url
            $response = $client->request('POST', 'users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $request->topic,
                    "type" => 2, // a schedule meeting
                    "start_time" => $date . "T" . $time,    // meeting start time
                    "duration" => $request->duration,                       // 30 minutes                       // 30 minutes
                    "password" => $request->password,
                    "timezone" => "Asia/Jakarta",
                    "settings" => [
                        "approval_type" => ($request->need_approval == 'on') ? 1 : 2, //Manually approve registration or no approval,
                        "registrants_email_notification" => ($request->need_approval == 'on') ? true : false
                    ]
                ],
            ]);


            $data = json_decode($response->getBody());

            ZoomRoom::create(
                [
                    'meeting_id' => $data->id,
                    'host_id' => $data->host_id,
                    'host_email' => $data->host_email,
                    'topic' => $data->topic,
                    'status' => $data->status,
                    'start_time' => $data->start_time,
                    'duration' => $data->duration,
                    'timezone' => $data->timezone,
                    'start_url' => $data->start_url,
                    'join_url' => $data->join_url,
                    'password' => $data->password,
                    'h323_password' => $data->h323_password,
                    'pstn_password' => $data->pstn_password,
                    'encrypted_password' => $data->encrypted_password,
                    'pre_schedule' => $data->pre_schedule,
                    'id_country' => $request->buyer_country,
                    'perwadag_quota' => $request->perwadag_quota,
                    'buyer_quota' => $request->buyer_quota,
                    'exportir_quota' => $request->exportir_quota,
                    'need_approval' => $request->need_approval,
                ]
            );
            DB::commit();


            return redirect('/event_zoom');
        } catch (Exception $e) {
            DB::rollback();
            if (401 == $e->getCode()) {
                $refresh_token = $this->get_refresh_token();

                $client = new Client(['base_uri' => env('ZOOM_URI')]);
                $response = $client->request('POST', 'oauth/token', [
                    "headers" => [
                        "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
                    ],
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $refresh_token
                    ],
                ]);
                $this->update_access_token($response->getBody());

                // $this->create_meeting($duration);
            } else {
                echo $e->getMessage();
            }
        }
    }



    public function delete_meeting($meetingId)
    {
        if (env('ZOOM_OWN_URL') == null) {
            return 'Can not read env file';
        }

        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        $accessToken = $arr_token[0]->access_token;
        $meetingId = $meetingId;

        try {
            $response = $client->request('DELETE', "meetings/{$meetingId}", [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ]
            ]);
            $zoom_room = ZoomRoom::where('meeting_id', $meetingId)->first();
            ZoomRoom::where('meeting_id', $meetingId)->delete();
            ZoomParticipant::where('zoom_room_id', $zoom_room)->delete();
            return redirect('/event_zoom');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function dataAjaxUserExportir(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = ItdpCompanyUser::with('profile')
                ->where('id_role', 2)
                ->where('status', 1)
                ->where('email', 'ILIKE', "%$search%")
                ->whereHas('profile', function ($q) use ($search) {
                    $q->orWhere('company', 'ILIKE', "%$search%")
                        ->orWhere('badanusaha', 'ILIKE', "%$search%");
                })
                ->get();
        }
        return response()->json($data);
    }

    public function dataAjaxUserBuyer(Request $request)
    {
        $data = [];

        if ($request->has('search')) {
            $search = $request->search;
            $data = ItdpCompanyUser::with('profile_buyer')
                ->where('id_role', 3)
                ->where('status', 1)
                ->where('email', 'ILIKE', "%$search%")
                ->whereHas('profile_buyer', function ($q) use ($search) {
                    $q->orWhere('company', 'ILIKE', "%$search%")
                        ->orWhere('badanusaha', 'ILIKE', "%$search%");
                })
                ->get();
        }
        return response()->json($data);
    }

    public function dataAjaxUserPerwakilan(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = ItdpAdminUser::with('profile_perwadag_ln', 'profile_perwadag_dn')
                ->where('id_group', 4)
                ->where(function ($q) use ($search) {
                    $q->where('email', 'ILIKE', "%$search%")
                        ->orWhere('name', 'ILIKE', "%$search%");
                })
                ->get();
        }
        return response()->json($data);
    }

    public function add_invitation(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dataZoomRoom = ZoomRoom::where('meeting_id', $request->zoom_room_id)->first();
        $zoom_room_id = $dataZoomRoom->id;
        if ($request->has('zoom_room_id')) {
            $data_exportir_array = [];
            $data_buyer_array = [];
            $data_perwadag_array = [];

            if ($request->has('exportir_id')) {
                $dataItdpCompanyExportir = ItdpCompanyUser::with('profile')->whereIn('id', $request->exportir_id)->get();

                // Cek quota
                $quota_remaining_exportir = (int) $dataZoomRoom->exportir_quota - (int) $dataZoomRoom->itdp_company_user_exportir()->count() - count($request->exportir_id);
                if ($quota_remaining_exportir < 0) {
                    return response()->json([
                        'status' => 201,
                        'message' => 'supplier quota exceeded'
                    ]);
                }
                // $dataZoomRoom->itdp_company_user()->detach();
                if ($dataItdpCompanyExportir->count() > 0) {
                    foreach ($dataItdpCompanyExportir as $key => $d) {
                        $d->zoom_rooms()->attach($zoom_room_id, ['is_verified' => 1, 'user_type' => 'Supplier', 'created_at' => date('Y-m-d H:i:s')]);

                        $data_exportir_array[$key]['email'] = $d->email;
                        $data_exportir_array[$key]['user'] = ($d->profile != null) ? $d->profile->company : '';
                        $data_exportir_array[$key]['badanusaha'] = ($d->profile != null) ? $d->profile->badanusaha : '';
                        $data_exportir_array[$key]['meeting_id'] = $dataZoomRoom->meeting_id;
                        $data_exportir_array[$key]['topic'] = $dataZoomRoom->topic;
                        $data_exportir_array[$key]['password'] = $dataZoomRoom->password;
                        $data_exportir_array[$key]['time'] = strtoupper(date('d F Y', strtotime($dataZoomRoom->start_time))) . ' ' . date('H:i a', strtotime($dataZoomRoom->start_time));
                    }
                }
            }
            if ($request->has('buyer_id')) {
                $dataItdpCompanyBuyer = ItdpCompanyUser::with('profile_buyer')->whereIn('id', $request->buyer_id)->get();
                $quota_remaining_buyer = (int) $dataZoomRoom->buyer_quota - (int) $dataZoomRoom->itdp_company_user_buyer()->count() - count($request->buyer_id);
                if ($quota_remaining_buyer < 0) {
                    return response()->json([
                        'status' => 201,
                        'message' => 'buyer quota  exceeded'
                    ]);
                }
                if ($dataItdpCompanyBuyer->count() > 0) {
                    foreach ($dataItdpCompanyBuyer as $d) {
                        $d->zoom_rooms()->attach($zoom_room_id, ['is_verified' => 1, 'user_type' => 'Buyer', 'created_at' => date('Y-m-d H:i:s')]);

                        $data_buyer_array[$key]['email'] = $d->email;
                        $data_buyer_array[$key]['user'] = ($d->profile_buyer != null) ? $d->profile_buyer->company : '';
                        $data_buyer_array[$key]['badanusaha'] = ($d->profile_buyer != null) ? $d->profile_buyer->badanusaha : '';
                        $data_buyer_array[$key]['meeting_id'] = $dataZoomRoom->meeting_id;
                        $data_buyer_array[$key]['topic'] = $dataZoomRoom->topic;
                        $data_buyer_array[$key]['password'] = $dataZoomRoom->password;
                        $data_buyer_array[$key]['time'] = strtoupper(date('d F Y', strtotime($dataZoomRoom->start_time))) . ' ' . date('H:i a', strtotime($dataZoomRoom->start_time));
                    }
                }
            }
            if ($request->has('perwakilan_id')) {
                $dataItdpAdminPerwadag = ItdpAdminUser::whereIn('id', $request->perwakilan_id)->get();
                $quota_remaining_perwadag = (int) $dataZoomRoom->perwadag_quota - (int) $dataZoomRoom->itdp_admin_user()->count() - count($request->perwakilan_id);
                if ($quota_remaining_perwadag < 0) {
                    return response()->json([
                        'status' => 201,
                        'message' => 'perwadag quota exceeded'
                    ]);
                }

                if ($dataItdpAdminPerwadag->count() > 0) {
                    foreach ($dataItdpAdminPerwadag as $d) {
                        $d->zoom_rooms()->attach($zoom_room_id, ['is_verified' => 1, 'user_type' => 'Perwakilan', 'created_at' => date('Y-m-d H:i:s')]);

                        $data_perwadag_array[$key]['email'] = $d->email;
                        if ($d->id_admin_ln != 0 && $d->id_admin_dn == 0) {
                            $data_perwadag_array[$key]['user'] = ($d->profile_perwadag_ln != null) ? $d->profile_perwadag_ln->nama : '';
                        } else if ($d->id_admin_dn != 0 && $d->id_admin_ln == 0) {
                            $data_perwadag_array[$key]['user'] = ($d->profile_perwadag_dn != null) ? $d->profile_perwadag_dn->nama : '';
                        }
                        $data_perwadag_array[$key]['badanusaha'] = '';
                        $data_perwadag_array[$key]['meeting_id'] = $dataZoomRoom->meeting_id;
                        $data_perwadag_array[$key]['topic'] = $dataZoomRoom->topic;
                        $data_perwadag_array[$key]['password'] = $dataZoomRoom->password;
                        $data_perwadag_array[$key]['time'] = strtoupper(date('d F Y', strtotime($dataZoomRoom->start_time))) . ' ' . date('H:i a', strtotime($dataZoomRoom->start_time));
                    }
                }
            }

            // Update Zoom 
            if (env('ZOOM_OWN_URL') == null) {
                return 'Can not read env file';
            }

            $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

            $arr_token = $this->get_access_token();
            $accessToken = $arr_token[0]->access_token;

            DB::beginTransaction();

            try {

                if (count($data_exportir_array) > 0) {
                    foreach ($data_exportir_array as $dea) {
                        $response = $client->request('PATCH', 'meetings/' . $dataZoomRoom->meeting_id, [
                            "headers" => [
                                "Authorization" => "Bearer $accessToken"
                            ],
                            'json' => [
                                "settings" => [
                                    "meeting_invitess" => [
                                        "email" => $dea['email']
                                    ]
                                ]
                            ],
                        ]);
                        $data = [];
                        $data['email'] = $dea['email'];
                        $data['user'] = $dea['user'];
                        $data['badanusaha'] = $dea['badanusaha'];
                        $data['meeting_id'] = $dea['meeting_id'];
                        $data['topic'] = $dea['topic'];
                        $data['password'] = $dea['password'];
                        $data['time'] = $dea['time'];
                        // Mail Invitation to exporter
                        Mail::send('event_zoom.send_mail_invitation', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['user']);
                            $mail->subject('Business Matching Meeting Invitation');
                        });
                    }
                }

                if (count($data_buyer_array) > 0) {
                    foreach ($data_buyer_array as $dba) {
                        $response = $client->request('PATCH', 'meetings/' . $dataZoomRoom->meeting_id, [
                            "headers" => [
                                "Authorization" => "Bearer $accessToken"
                            ],
                            'json' => [
                                "settings" => [
                                    "meeting_invitess" => [
                                        "email" => $dba['email']
                                    ]
                                ]
                            ],
                        ]);
                        $data = [];
                        $data['email'] = $dea['email'];
                        $data['user'] = $dea['user'];
                        $data['badanusaha'] = $dea['badanusaha'];
                        $data['meeting_id'] = $dea['meeting_id'];
                        $data['topic'] = $dea['topic'];
                        $data['password'] = $dea['password'];
                        $data['time'] = $dea['time'];
                        // Mail Invitation to exporter
                        Mail::send('event_zoom.send_mail_invitation', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['user']);
                            $mail->subject('Business Matching Meeting Invitation');
                        });
                    }
                }

                if (count($data_perwadag_array) > 0) {
                    foreach ($data_perwadag_array as $dpa) {
                        $response = $client->request('PATCH', 'meetings/' . $dataZoomRoom->meeting_id, [
                            "headers" => [
                                "Authorization" => "Bearer $accessToken"
                            ],
                            'json' => [
                                "settings" => [
                                    "meeting_invitess" => [
                                        "email" => $dpa['email']
                                    ]
                                ]
                            ],
                        ]);
                        $data = [];
                        $data['email'] = $dea['email'];
                        $data['user'] = $dea['user'];
                        $data['badanusaha'] = $dea['badanusaha'];
                        $data['meeting_id'] = $dea['meeting_id'];
                        $data['topic'] = $dea['topic'];
                        $data['password'] = $dea['password'];
                        $data['time'] = $dea['time'];
                        // Mail Invitation to exporter
                        Mail::send('event_zoom.send_mail_invitation', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['user']);
                            $mail->subject('Business Matching Meeting Invitation');
                        });
                    }
                }


                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'ok'
                ]);
            } catch (Exception $e) {
                DB::rollback();
                if (401 == $e->getCode()) {
                    $refresh_token = $this->get_refresh_token();

                    $client = new Client(['base_uri' => env('ZOOM_URI')]);
                    $response = $client->request('POST', 'oauth/token', [
                        "headers" => [
                            "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
                        ],
                        'form_params' => [
                            "grant_type" => "refresh_token",
                            "refresh_token" => $refresh_token
                        ],
                    ]);
                    $this->update_access_token($response->getBody());

                    // $this->create_meeting($duration);
                } else {
                    echo $e->getMessage();
                }
            }
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'not ok'
            ]);
        }
    }

    public function view_invitation(Request $request)
    {
        $dataZoomRoom = ZoomRoom::with('itdp_company_user', 'itdp_admin_user', 'itdp_company_user_exportir', 'itdp_company_user_buyer')->where('meeting_id', $request->zoom_room_id)->first();
        $data = [];
        $maxKey = 0;
        foreach ($dataZoomRoom->itdp_company_user as $key => $d) {
            if ($d->id_role == 2) {
                // Supplier
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile->company;
                $data[$key]['type'] = 'Supplier';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            } else if ($d->id_role == 3) {
                // Buyer
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile_buyer->company;
                $data[$key]['type'] = 'Buyer';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            }

            $maxKey++;
        }

        foreach ($dataZoomRoom->itdp_admin_user as $key => $d) {
            // Perwadag
            if ($d->id_group == 4) {
                if ($d->id_admin_ln != 0 && $d->id_admin_dn == 0) {
                    // Perwadag Luar Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_ln->nama;
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                } else if ($d->id_admin_dn != 0 && $d->id_admin_ln == 0) {
                    // Perwadag Dalam Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_dn->nama;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                }
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data,
            'quota_exportir_remaining' => (int) $dataZoomRoom->exportir_quota - (int) $dataZoomRoom->itdp_company_user_exportir_verified()->count(),
            'quota_buyer_remaining' => (int) $dataZoomRoom->buyer_quota - (int) $dataZoomRoom->itdp_company_user_buyer_verified()->count(),
            'quota_perwadag_remaining' => (int) $dataZoomRoom->perwadag_quota - (int) $dataZoomRoom->itdp_admin_user_verified()->count(),
        ], 200);
    }

    public function delete_invitation(Request $request)
    {
        $dataZoomRoom = ZoomRoom::with('itdp_company_user', 'itdp_admin_user')->whereId($request->zoom_room_id)->first();

        if ($request->type == 'Supplier' || ($request->type == 'Buyer')) {
            $dataZoomRoom->itdp_company_user()->detach($request->user_id);
        } elseif ($request->type == 'Perwakilan') {
            $dataZoomRoom->itdp_admin_user()->detach($request->user_id);
        }
        $data = [];
        $maxKey = 0;
        $dataZoomRoom = $dataZoomRoom->fresh();
        foreach ($dataZoomRoom->itdp_company_user as $key => $d) {
            if ($d->id_role == 2) {
                // Supplier
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile->company;
                $data[$key]['type'] = 'Supplier';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            } else if ($d->id_role == 3) {
                // Buyer
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile_buyer->company;
                $data[$key]['type'] = 'Buyer';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            }

            $maxKey++;
        }

        foreach ($dataZoomRoom->itdp_admin_user as $key => $d) {
            // Perwadag
            if ($d->id_group == 4) {
                if ($d->id_admin_ln != '') {
                    // Perwadag Luar Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_ln->nama;
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                } else if ($d->id_admin_dn != '') {
                    // Perwadag Dalam Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_dn->nama;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ], 200);
    }

    public function verification(Request $request)
    {
        if ($request->type == 'Supplier') {
            ZoomParticipant::where('itdp_company_user_id', $request->user_id)->where('zoom_room_id', $request->zoom_room_id)->update(['is_verified' => $request->zoom_verification]);
        } else  if ($request->type == 'Buyer') {
            ZoomParticipant::where('itdp_company_user_id', $request->user_id)->where('zoom_room_id', $request->zoom_room_id)->update(['is_verified' => $request->zoom_verification]);
        } else  if ($request->type == 'Perwakilan') {
            ZoomParticipant::where('itdp_admin_user_id', $request->user_id)->where('zoom_room_id', $request->zoom_room_id)->update(['is_verified' => $request->zoom_verification]);
        }
        $dataZoomRoom = ZoomRoom::whereId($request->zoom_room_id)->first();
        $data = [];
        $maxKey = 0;
        foreach ($dataZoomRoom->itdp_company_user as $key => $d) {
            if ($d->id_role == 2) {
                // Supplier
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile->company;
                $data[$key]['type'] = 'Supplier';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            } else if ($d->id_role == 3) {
                // Buyer
                $data[$key]['zoom_room_id'] = $dataZoomRoom->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile_buyer->company;
                $data[$key]['type'] = 'Buyer';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            }

            $maxKey++;
        }

        foreach ($dataZoomRoom->itdp_admin_user as $key => $d) {
            // Perwadag
            if ($d->id_group == 4) {
                if ($d->id_admin_ln != '') {
                    // Perwadag Luar Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_ln->nama;
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                } else if ($d->id_admin_dn != '') {
                    // Perwadag Dalam Negeri
                    $data[$maxKey + $key + 1]['zoom_room_id'] = $dataZoomRoom->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['company'] = $d->profile_perwadag_dn->nama;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['is_verified'] = $d->pivot->is_verified;
                }
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ], 200);
    }

    public function check_remaining_quota(Request $request)
    {

        if ($request->has('zoom_room_id')) {
            $dataZoomRoom = ZoomRoom::with('itdp_company_user', 'itdp_admin_user_verified', 'itdp_company_user_exportir_verified', 'itdp_company_user_buyer_verified')->where('meeting_id', $request->zoom_room_id)->first();

            return response()->json([
                'status' => 200,
                'message' => 'ok',
                'quota_exportir_remaining' => (int) $dataZoomRoom->exportir_quota - (int) $dataZoomRoom->itdp_company_user_exportir_verified()->count(),
                'quota_buyer_remaining' => (int) $dataZoomRoom->buyer_quota - (int) $dataZoomRoom->itdp_company_user_buyer_verified()->count(),
                'quota_perwadag_remaining' => (int) $dataZoomRoom->perwadag_quota - (int) $dataZoomRoom->itdp_admin_user_verified()->count(),
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'nok',
            ], 404);
        }
    }


    public function video_conference_list()
    {
        $pageTitle = 'List Video Conference | Inaexport';
        $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
        $data = DB::table('video_conference_participants')
            ->select('video_conferences.*', 'video_conference_participants.*')
            ->join('video_conferences', 'video_conference_participants.video_conference_id', '=', 'video_conferences.id')
            ->where('itdp_company_user_id', $id_user)
            ->get();
        $data_perwadag = DB::table('video_conference_participants')
            ->select('video_conferences.*', 'video_conference_participants.*')
            ->join('video_conferences', 'video_conference_participants.video_conference_id', '=', 'video_conferences.id')
            ->where('itdp_admin_user_id', $id_user)
            ->get();
        $topMenu = "";
        $role_user = $role_user = (Auth::user() != '') ? 'perwadag' : (Auth::guard('eksmp')->user()->id_role == '2' ? 'exportir' : 'buyer');
        switch ($role_user) {
            case 'perwadag':
                # code...
                return view('video_conference.video_conference_list_perwadag', compact('data_perwadag', 'pageTitle', 'topMenu', 'data', 'id_user'));
                break;
            case 'exportir':
                # code...
                return view('video_conference.video_conference_list', compact('pageTitle', 'topMenu', 'data', 'id_user'));
                break;
            case 'buyer':

                return view('video_conference.video_conference_list_buyer', compact('pageTitle', 'topMenu', 'data', 'id_user'));
                break;

            default:
                return redirect('/');
                break;
        }
    }

    public function video_conference_data()
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
        $data = VideoConference::with('itdp_company_user_exportir', 'itdp_company_user_buyer', 'itdp_admin_user')
            ->orwherehas('itdp_company_user_exportir', function ($q) use ($id_user) {
                $q->where('itdp_company_users.id', $id_user);
            })
            ->orwherehas('itdp_company_user_buyer', function ($q) use ($id_user) {
                $q->where('itdp_company_users.id', $id_user);
            })
            ->orwherehas('itdp_admin_user', function ($q) use ($id_user) {
                $q->where('itdp_admin_users.id', $id_user);
            })
            ->orderBy('video_conferences.id', 'DESC')
            ->get();
        // dd($data);

        return DataTables::of($data)
            ->addColumn('col1', function ($data) {
                if ($data->video_conference->approve == 1) {
                    return $data->video_conference->meeting_id;
                } else {
                    return '';
                }
            })
            ->addColumn('col2', function ($data) {
                if ($data->video_conference->approve == 1) {
                    return $data->video_conference->password;
                } else {
                    return '';
                }
            })
            ->addColumn('col3', function ($data) {
                return $data->video_conference->topic;
            })
            ->addColumn('col4', function ($data) {
                return date('d F Y H:i:s', strtotime($data->video_conference->start_time));
            })
            ->addColumn('col5', function ($data) {
                return $data->video_conference->duration;
            })
            ->addColumn('col6', function ($data) {
                return '<center><a href="' . url('video_conference/add_update_video_conference_data/' . $data->id . '') . '" class="btn btn-sm btn-success">Edit</a></center>';
            })
            ->setRowClass(function ($data) {
                return ((Carbon::parse($data->start_time) > Carbon::now()) ? 'new' : 'passed');
            })
            ->rawColumns(['col1', 'col2', 'col3', 'col4', 'col5', 'col6'])
            ->addIndexColumn()
            ->make(true);
    }

    public function add_update_video_conference_data(Request $request, $id = null)
    {
        ini_set('memory_limit', '1024M');

        $data = [];
        $data['id'] = '';

        $data['url'] = "video_conference/store_video_conference_data";

        $data['data'] = '';
        $data['pageTitle'] = 'Tambah Data Video Conference';

        $data['data_eks'] = ItdpCompanyUser::with('profile')
            ->select('itdp_company_users.*')
            ->leftjoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('id_role', 2)
            ->where('itdp_company_users.status', 1)
            ->orderBy('itdp_profil_eks.company', 'asc')
            ->get();
        // dd($data['data_eks']);
        $data['data_buyer'] = ItdpCompanyUser::with('profile_buyer')
            ->leftjoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->select('itdp_company_users.*')
            ->where('id_role', 3)
            ->where('itdp_company_users.status', 1)
            ->orderBy('itdp_profil_imp.company', 'asc')
            ->get();
        $data['data_perwakilan'] = ItdpAdminUser::with('profile_perwadag_ln', 'profile_perwadag_dn')
            ->select('itdp_admin_users.*')
            ->where('id_group', 4)
            ->orderBy('name')
            ->get();
        // dd($data['data_perwakilan']);
        if ($id != null) {
            $data['id'] = $id;
            $data['data'] = VideoConference::with('video_conference_participants')->whereId($id)->first();

            $data['url'] = "video_conference/edit_video_conference_data";

            $data['data_eks'] = ItdpCompanyUser::with('profile')
                ->leftjoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                ->select('itdp_company_users.*')
                ->where('id_role', 2)
                ->where('itdp_company_users.status', 1)
                ->orderBy('itdp_profil_eks.company', 'asc')
                ->get();

            $data['data_buyer'] = ItdpCompanyUser::with('profile_buyer')
                ->leftjoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
                ->select('itdp_company_users.*')
                ->where('id_role', 3)
                ->where('itdp_company_users.status', 1)
                ->orderBy('itdp_profil_imp.company', 'asc')
                ->get();
            $data['data_perwakilan'] = ItdpAdminUser::with('profile_perwadag_ln', 'profile_perwadag_dn')
                ->select('itdp_admin_users.*')
                ->where('id_group', 4)
                ->orderBy('name')
                ->get();

            $data['pageTitle'] = 'Edit Data Video Conference';
        }
        return view('video_conference/add_update_video_conference', $data);
    }

    public function store_video_conference_data(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $datetime = explode(" ", $request->inputStartTime);
            $date =  date('Y-m-d', strtotime($datetime[0]));
            $time =  $datetime[1] . ":00";
            $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;

            $insert_1 = VideoConference::create([
                'topic'          => $request->inputMeetingTopic,
                'start_time'     => $date . "T" . $time,
                'duration'       => $request->inputMeetingDuration
            ]);
            $insert_exp = DB::table('video_conference_participants')->insert([
                'video_conference_id' => $insert_1->id,
                'user_type' => ($request->for_expo != '') ? $request->for_expo : 'Supplier',
                'itdp_company_user_id' => ($request->states_exportir != '') ? $request->states_exportir : $id_user,

            ]);

            $insert_buy = DB::table('video_conference_participants')->insert([
                'video_conference_id' => $insert_1->id,
                'user_type' => ($request->for_buyer != '') ? $request->for_buyer : 'Buyer',
                'itdp_company_user_id' => ($request->states_buyer != '') ? $request->states_buyer : $id_user,

            ]);

            $perwakilan =  DB::table('video_conference_participants')->insert([
                'video_conference_id' => $insert_1->id,
                'user_type' => ($request->for_wakil != '') ? $request->for_wakil : 'Perwakilan',
                'itdp_admin_user_id' => ($request->states_perwakilan != '') ? $request->states_perwakilan : $id_user,

            ]);

            Session::flash('success', 'Data Tersimpan');
            DB::commit();
            return redirect('video_conference/list');
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    // public function store_video_conference_data_pw(Request $request)
    // {
    //     $datetime = explode(" ", $request->inputStartTime);
    //     $date =  date('Y-m-d', strtotime($datetime[0]));
    //     $time =  $datetime[1] . ":00";
    //     $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;

    //     // dd($request->all());
    //     $insert_1 = VideoConference::create([
    //         'topic'              => $request->inputMeetingTopic,
    //         'start_time'     => $date . "T" . $time,
    //         'duration'       => $request->inputMeetingDuration
    //     ]);
    //     $insert_exp = DB::table('video_conference_participants')->insert([
    //         'video_conference_id' => $insert_1->id,
    //         'user_type' => $request->for_expo,
    //         'itdp_company_user_id' => $request->states_exportir

    //     ]);

    //     $insert_buy = DB::table('video_conference_participants')->insert([
    //         'video_conference_id' => $insert_1->id,
    //         'user_type' => $request->for_buyer,
    //         'itdp_company_user_id' => $request->states_buyer,

    //     ]);

    //     $perwakilan =  DB::table('video_conference_participants')->insert([
    //         'video_conference_id' => $insert_1->id,
    //         'user_type' => $request->for_wakil,
    //         'itdp_admin_user_id' => $id_user,

    //     ]);

    //     Session::flash('success', 'Data Tersimpan');
    //     return redirect('video_conference/list');
    // }
    public function edit_video_conference_data(Request $request)
    {
        DB::beginTransaction();
        try {

            $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
            $id = $request->id_busnisnya;
            $datetime = explode(" ", $request->inputStartTime);
            $date =  date('Y-m-d', strtotime($datetime[0]));
            $time =  $datetime[1] . ":00";
            $detail = VideoConference::where('id', $id)->update([
                'topic'          => $request->inputMeetingTopic,
                'start_time'     => $date . "T" . $time,
                'duration'       => $request->inputMeetingDuration
            ]);

            $update1 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_expo)->update([
                'itdp_company_user_id' => ($request->states_exportir != '') ? $request->states_exportir : $id_user,
            ]);
            $update2 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_buyer)->update([
                'itdp_company_user_id' => ($request->states_buyer != '') ? $request->states_buyer : $id_user,
            ]);
            $update3 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_wakil)->update([
                'itdp_admin_user_id' => ($request->states_perwakilan != '') ? $request->states_perwakilan : $id_user,
            ]);
            Session::flash('success', 'Data Tersimpan');
            DB::commit();
            return redirect('video_conference/list');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    // public function edit_video_conference_data_pw(Request $request)
    // {
    //     // dd($request->all());
    //     $id_user = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
    //     $id = $request->id_busnisnya;
    //     $detail = VideoConference::where('id', $id)->update([
    //         'topic'              => $request->inputMeetingTopic,
    //         'start_time'     => $request->inputStartTime,
    //         'duration'       => $request->inputMeetingDuration
    //     ]);
    //     $update1 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_expo)->update([
    //         'itdp_company_user_id' => $request->states_exportir,
    //     ]);
    //     $update2 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_buyer)->update([
    //         'itdp_company_user_id' => $request->states_buyer,
    //     ]);
    //     $update3 = VideoConferenceParticipant::where('video_conference_id', $id)->where('user_type', $request->for_wakil)->update([
    //         'itdp_admin_user_id' => $id_user,
    //     ]);
    //     Session::flash('success', 'Data Tersimpan');
    //     return redirect('video_conference/list');
    // }
    public function hapus_video_conference_data($id)
    {

        $remove = VideoConference::where('id', $id)->delete();
        // dd($request);
        return redirect()->back();
    }
}
