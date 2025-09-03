<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class TrainingNonAuthController extends Controller
{

    // use AuthenticatesUsers;  
    // public function __construct()
    // {
    //    auth()->shouldUse('api_user');
    // }


    public function browseTraining()
    {
        $dataTraining = DB::table('training_admin')
            ->leftJoin('contact_person', 'training_admin.id', '=', 'contact_person.id_type')
            ->select('training_admin.id as id_training', 'training_admin.training_en', 'training_admin.training_in'
                , 'training_admin.training_chn', 'training_admin.start_date', 'training_admin.end_date', 'training_admin.duration', 'training_admin.topic_en'
                , 'training_admin.topic_in', 'training_admin.topic_chn', 'training_admin.location_en', 'training_admin.location_in'
                , 'training_admin.location_chn', 'training_admin.status', 'training_admin.param', 'training_admin.created_at'
                , 'contact_person.id as id_contact', 'contact_person.name', 'contact_person.email', 'contact_person.phone', 'contact_person.type', 'contact_person.id_type')
            ->where('training_admin.status', '=', '1')
            ->where('contact_person.type', '=', 'training')
            ->get();
//        dd($dataTraining);
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findTrainingById(Request $request)
    {
        $dataTraining = DB::table('training_admin')
            ->where('id', '=', $request->id_training)
            ->get();

        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $res['message'] = "Failed, No data.";
            return response($res);
        }
    }
}
