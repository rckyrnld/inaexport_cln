<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventDetail;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class EventNonAuthController extends Controller
{

    public function event_suggest(Request $request)
    {
        //$name = $request->search;
        // $offset = $request->offset;
        // $data = DB::select("select * from event_detail where event_name_en like '%".$name."%' or event_name_in like '%".$name."%' or event_name_chn like '%".$name."%' order by event_name_en asc");
        $data = DB::table('event_detail')
            //	->where('event_detail.event_name_en', 'like', '%' . $name . '%')
            //	->orwhere('event_detail.event_name_in', 'like', '%' . $name . '%')
            //	->orwhere('event_detail.event_name_chn', 'like', '%' . $name . '%')
            //	->orderBy('event_detail.event_name_en', 'asc')
            //    ->limit(10)
            //    ->offset($offset)
            ->get();
        $jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["event_name_en"] = $data[$i]->event_name_en;
            $jsonResult[$i]["event_name_in"] = $data[$i]->event_name_in;
            $jsonResult[$i]["event_name_chn"] = $data[$i]->event_name_chn;
        }
        //        dd($jsonResult);
        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

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

    public function event_list(Request $request)
    {
        $name = $request->search;

        //$offset = $request->offset;
        // $data = DB::select("select * from event_detail where event_name_en like '%".$name."%' or event_name_in like '%".$name."%' or event_name_chn like '%".$name."%' order by event_name_en asc");
        $data = EventDetail::with('contact_person')
            ->where('end_date', '>=', date('Y-m-d'))
            ->where(
                function ($q) use ($name) {
                    $q->where('event_detail.event_name_en', 'ilike', '%' . $name . '%')
                        ->orwhere('event_detail.event_name_in', 'ilike', '%' . $name . '%')
                        ->orwhere('event_detail.event_name_chn', 'ilike', '%' . $name . '%');
                }
            )
            ->orderBy('event_detail.start_date', 'desc')
            ->get();

        if (count($data) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];

            $getJSON = array();
            foreach ($data as $item) {
                $register_open = "";
                if ($item->limit != '') {
                    $nowDate = Carbon::now();
                    $limit = Carbon::parse($item->limit)->endOfDay();
                    if ($limit->gte($nowDate)) {
                        $register_open = "REGISTER OPEN";
                    }
                }

                $cp_name_array = [];
                $cp_email_array = [];
                $cp_phone_array = [];
                foreach ($item->contact_person as $cp) {
                    $cp_name_array[] = $cp->name;
                    $cp_email_array[] = $cp->email;
                    $cp_phone_array[] = $cp->phone;
                }

                // Cek limit registration
                $btn_show = false;
                if ($item->limit != '') {
                    $limit_date = Carbon::parse($item->limit);
                    $now = Carbon::now();
                    if ($limit_date->gte($now)) {
                        $btn_show = true;
                    } else {
                        $btn_show = false;
                    }
                }


                array_push($getJSON, array(
                    "id" => $item->id,
                    "start_date" => $item->start_date,
                    "end_date" => $item->end_date,
                    "event_name_en" => $item->event_name_en,
                    "event_name_in" => $item->event_name_in,
                    "event_name_chn" => $item->event_name_chn,
                    "event_type_en" => $item->event_type_en,
                    "event_type_in" => $item->event_type_in,
                    "event_type_chn" => $item->event_type_chn,
                    "id_event_organizer" => $item->id_event_organizer,
                    "event_organizer_text_en" => $item->event_organizer_text_en,
                    "even_organizer_text_in" => $item->even_organizer_text_in,
                    "even_organizer_text_chn" => $item->even_organizer_text_chn,
                    "id_event_place" => $item->id_event_place,
                    "event_place_text_en" => $item->event_place_text_en,
                    "event_place_text_in" => $item->event_place_text_in,
                    "event_place_text_chn" => $item->event_place_text_chn,
                    "image_1" => $path = ($item->image_1) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_1) : url('image/nia3.png'),
                    "website" => $item->website,
                    "jenis_en" => $item->jenis_en,
                    "jenis_in" => $item->jenis_in,
                    "jenis_chn" => $item->jenis_chn,
                    "event_comodity" => $item->event_comodity,
                    "event_scope_en" => $item->event_scope_en,
                    "event_scope_in" => $item->event_scope_in,
                    "event_scope_chn" => $item->event_scope_chn,
                    "id_prod_cat" => $item->id_prod_cat,
                    "id_articles" => $item->id_articles,
                    "id_prod_sub1_kat" => $item->id_prod_sub1_kat,
                    "id_prod_sub2_kat" => $item->id_prod_sub2_kat,
                    "status_en" => $item->status_en,
                    "status_in" => $item->status_in,
                    "status_chn" => $item->status_chn,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "image_2" => $path = ($item->image_2) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_2) : url('image/nia3.png'),
                    "image_3" => $path = ($item->image_3) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_3) : url('image/nia3.png'),
                    "image_4" => $path = ($item->image_4) ? url('uploads/Event/Image/' . $item->id . '/' . $item->image_4) : url('image/nia3.png'),
                    "name" => implode(', ', $cp_name_array),
                    "email" => implode(', ', $cp_email_array),
                    "phone" => implode(', ', $cp_phone_array),
                    "label" => $register_open,
                    "btn_show" => $btn_show

                    //                    "type" => $item->type,
                    //                    "id_type" => $item->id_type
                ));
            }

            $res['meta'] = $meta;
            $res['data'] = $getJSON;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
}
