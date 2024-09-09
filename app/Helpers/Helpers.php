<?php
namespace App\Helpers;

use Symfony\Component\HttpFoundation\Request;

class Helpers {
	public static function timezoneSet(){
		date_default_timezone_set('Asia/Jakarta');
	}
	public static function resHttp($request = new Request()){
		$payload = is_array($request->payload) ? $request->payload : [];
		$keyData = ['message','code','data'];
		$arr = [];
		foreach($keyData as $key => $val){
			$arr[$val] = isset($payload[$val]) ? $payload[$val] : ( # Cek key, apakah sudah di set
				$val=='code' ? 500 : (
					$val=='message' ? '-' : []
				)
			);
		}
		$code = $arr['code'];
		$msg = $arr['message'];

		$metadata = [
			'code'    => $arr['code'],
			'message' => $arr['message'],
		];
		$response['metadata'] = $metadata;
		$response['data'] = $arr['data'];
		return response()->json($response,$code);
	}
}
