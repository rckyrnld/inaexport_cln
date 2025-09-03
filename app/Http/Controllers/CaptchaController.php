<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Validation\Validator;


class CaptchaController extends Controller
{
   public function captchaValidate(Request $request){
//       dd($request, Session::All());
       $validator = Validator::make($request->all(), [
           'captcha' => 'required|captcha'
       ]);

       if ($validator->fails())
       {
           return response()
           ->json(['jawab' => 'gagal']);
       }else{
           return response()
               ->json(['jawab' => 'berhasil']);
       }
   }
   public function refreshCaptcha (){
       return captcha_img();
   }
}
