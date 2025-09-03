<?php

namespace App\Http\Controllers\VideoConference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VideoConference;
use App\Models\VideoConferenceParticipant;
use App\Models\ZoomToken;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use DB;

class VCController extends Controller
{
    public function index(Request $request)
    {
        if (env('VC_OWN_URL') == null) {
            return 'Can not read env file';
        }
        $data['VC_CLIENT_ID'] = env('VC_CLIENT_ID');
        $data['VC_REDIRECT_URI'] = env('VC_REDIRECT_URI');
        $data['VC_OWN_URL'] = env('VC_OWN_URL');

        if ($this->get_meetings() != 'Token Expired') {
            $local_meeting_data = VideoConference::with('video_conference_participants')->orderBy('id', 'desc')->get();
            $data['meetings'] =  $local_meeting_data;
            $data['is_login'] = (ZoomToken::where('meeting_type', 'video_conference')->first()  != null) ? true : false;
        } else {
            $local_meeting_data = VideoConference::with('video_conference_participants')->orderBy('id', 'desc')->get();
            $data['meetings'] =  $local_meeting_data;
            $data['is_login'] = false;
        }

        $data['pageTitle'] = "Video Conference";
        return view('video_conference.video_conference_list_admin', $data);
    }
    // Get access token
    public function get_access_token()
    {
        $access_token = ZoomToken::where('meeting_type', 'video_conference')->first();
        return json_decode($access_token);
    }

    // Get referesh token
    public function get_refresh_token()
    {
        $result = $this->get_access_token();
        $refreshToken = $result->refresh_token;
        return $refreshToken;
    }

    // Update access token
    public function update_access_token($token)
    {
        $check = ZoomToken::where('meeting_type', 'video_conference')->first();
        if ($check != null) {
            $id = ZoomToken::where('meeting_type', 'video_conference')->first()->id;
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
                    'meeting_type' => 'video_conference'
                ]
            );
        }
    }

    public function callback(Request $request)
    {
        try {
            if (env('VC_OWN_URL') == null) {
                return 'Can not read env file';
            }

            $client = new Client(['base_uri' => env('ZOOM_URI')]);

            $response = $client->request('POST', 'oauth/token', [
                "headers" => [
                    "Authorization" => "Basic " . base64_encode(env('VC_CLIENT_ID') . ':' . env('VC_CLIENT_SECRET'))
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => env('VC_REDIRECT_URI')
                ],
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            $this->update_access_token($token);

            session()->put('status', 'Login');
            return redirect('/video_conference');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function get_meetings()
    {
        if (env('VC_OWN_URL') == null) {
            return 'Can not read env file';
        }
        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        if ($arr_token == '') {
            $data = "";
            return $data;
        } else {
            $accessToken = $arr_token->access_token;

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
                } else {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function create_meeting(Request $request)
    {

        if (env('VC_OWN_URL') == null) {
            return 'Can not read env file';
        }

        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        $accessToken = $arr_token->access_token;

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
                    "timezone" => "Asia/Jakarta"
                ],
            ]);


            $data = json_decode($response->getBody());

            VideoConference::create(
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
                    'perwadag_quota' => $request->perwadag_quota,
                    'buyer_quota' => $request->buyer_quota,
                    'exportir_quota' => $request->exportir_quota
                ]
            );
            DB::commit();


            return redirect('/video_conference');
        } catch (Exception $e) {
            DB::rollback();
            if (401 == $e->getCode()) {
                $refresh_token = $this->get_refresh_token();

                $client = new Client(['base_uri' => env('ZOOM_URI')]);
                $response = $client->request('POST', 'oauth/token', [
                    "headers" => [
                        "Authorization" => "Basic " . base64_encode(env('VC_CLIENT_ID') . ':' . env('VC_CLIENT_SECRET'))
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
        if (env('VC_OWN_URL') == null) {
            return 'Can not read env file';
        }

        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $arr_token = $this->get_access_token();
        $accessToken = $arr_token->access_token;
        $meeting = VideoConference::whereId($meetingId)->first();
        $meetingId = $meeting->meeting_id;
        try {
            if ($meeting->meeting_id != '') {
                $response = $client->request('DELETE', "meetings/{$meetingId}", [
                    "headers" => [
                        "Authorization" => "Bearer $accessToken"
                    ]
                ]);
            }
            $zoom_room = VideoConference::whereId($meeting->id)->first();
            VideoConference::whereId($meeting->id)->delete();
            VideoConferenceParticipant::where('video_conference_id', $zoom_room->id)->delete();
            return redirect('/video_conference');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function view_invitation(Request $request)
    {
        $dataVideoConference = VideoConference::with('itdp_company_user', 'itdp_admin_user', 'itdp_company_user_exportir', 'itdp_company_user_buyer')->where('id', $request->zoom_room_id)->first();
        $data = [];
        $maxKey = 0;
        foreach ($dataVideoConference->itdp_company_user as $key => $d) {
            if ($d->id_role == 2) {
                // Supplier
                $data[$key]['video_conference_id'] = $dataVideoConference->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile->company;
                $data[$key]['type'] = 'Supplier';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            } else if ($d->id_role == 3) {
                // Buyer
                $data[$key]['video_conference_id'] = $dataVideoConference->id;
                $data[$key]['no'] = $key + 1;
                $data[$key]['id'] = $d->id;
                $data[$key]['email'] = $d->email;
                $data[$key]['company'] = $d->profile_buyer->company;
                $data[$key]['type'] = 'Buyer';
                $data[$key]['is_verified'] = $d->pivot->is_verified;
            }

            $maxKey++;
        }

        foreach ($dataVideoConference->itdp_admin_user as $key => $d) {
            // Perwadag
            if ($d->id_group == 4) {
                if ($d->id_admin_ln != 0 && $d->id_admin_dn == 0) {
                    // Perwadag Luar Negeri
                    $data[$maxKey + $key + 1]['video_conference_id'] = $dataVideoConference->id;
                    $data[$maxKey + $key + 1]['no'] = $maxKey + $key + 1;
                    $data[$maxKey + $key + 1]['id'] = $d->id;
                    $data[$maxKey + $key + 1]['email'] = $d->email;
                    $data[$maxKey + $key + 1]['type'] = 'Perwakilan';
                    $data[$maxKey + $key + 1]['company'] = $d->name;
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

    public function approve_meeting(Request $request, $meetingId)
    {
        if (env('ZOOM_OWN_URL') == null) {
            return 'Can not read env file';
        }

        $client = new Client(['base_uri' => env('ZOOM_API_URI')]);

        $token = $this->get_access_token();
        $accessToken = $token->access_token;

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
            // $datetime = explode(" ", $request->start_time);
            // $date =  date('Y-m-d', strtotime($datetime[0]));
            // $time =  $datetime[1] . ":00";
            // if you have userid of user than change it with me in url
            $response = $client->request('POST', 'users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $request->topic,
                    "type" => 2, // a schedule meeting
                    "start_time" => $request->start_time,    // meeting start time
                    "duration" => $request->duration,                       // 30 minutes                       // 30 minutes
                    "password" => $request->password,
                    "timezone" => "Asia/Jakarta",
                ],
            ]);


            $data = json_decode($response->getBody());

            VideoConference::whereId($meetingId)->update(
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
                    'approve' => 1
                ]
            );
            DB::commit();


            return redirect('/video_conference');
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

    public function decline_meeting($meetingId)
    {

        DB::beginTransaction();
        try {
            VideoConference::whereId($meetingId)->update(
                [
                    'meeting_id' => NULL,
                    'host_id' => NULL,
                    'host_email' => NULL,
                    'status' => NULL,
                    'join_url' => NULL,
                    'password' => NULL,
                    'h323_password' => NULL,
                    'pstn_password' => NULL,
                    'encrypted_password' => NULL,
                    'pre_schedule' => NULL,
                    'approve' => false
                ]
            );
            DB::commit();
            return redirect('/video_conference');
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
        }
    }
}
