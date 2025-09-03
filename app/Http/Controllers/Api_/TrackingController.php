<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class TrackingController extends Controller
{

    public function tracking(Request $request){
		
		$client = new Client();
		$api = explode('|', $request->type);
		if($api[0] == 'mytm'){
			// Real Time Tracking ( Method POST )
	      //   $res = $client->request('POST', 'http://api.trackingmore.com/v2/trackings/realtime', [
	      //       'headers' => [
			    //     'Content-Type' 			=> 'application/json',
			    //     'Accept'     			=> 'application/json',
			    //     'Trackingmore-Api-Key' 	=> 'cc9ef652-5eca-4c5e-bea2-89a10572ec84'
			    // ],
			    // 'json' => ['tracking_number' =>  $request->number, 'carrier_code' =>  $api[1]]
	      //   ]);

			// Method Get
	        $res = $client->request('GET', 'https://api.trackingmore.com/v2/trackings/', [
	            'headers' => [
			        'Content-Type' 			=> 'application/json',
			        'Accept'     			=> 'application/json',
			        'Trackingmore-Api-Key' 	=> '79a09807-2760-4689-9336-26cc4655c4e4'
			    ],
			    'query' => ['tracking_number' =>  $request->number, 'carrier_code' =>  $api[1]]
	        ]);

			return response($res->getBody());

		} else if($api[0] == 'dhl') {
			$res = $client->request('GET', 'https://api-eu.dhl.com/track/shipments', [
	            'headers' => [
			        'Content-Type' 		=> 'application/json',
			        'Accept'     		=> 'application/json',
			        'DHL-API-Key' 		=> 'dhl-try-it-out-key'
			    ],
			    'query' => ['trackingNumber' => $request->number, 'service' => $api[1]]
	        ]);
			
			$tampung =  $res->getBody();
			return response($tampung->getContents());
		}		
	}
    
}
