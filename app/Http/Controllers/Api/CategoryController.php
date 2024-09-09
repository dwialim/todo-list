<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Help;

use App\Models\Categorie;

class CategoryController extends Controller{
	public function getCategory(Request $request){
		try{
			$data = Categorie::getData($request);
			$request->merge([
				'payload' => [
					'message' => 'Ok',
					'code' => count($data) ? 200 : 204,
					'data' => $data
				]
			]);
			return Help::resHttp($request);
		}catch(\Throwable $e){
			# Lakukan log untuk debugging
			Log::debug(json_encode([
				'source' => $e->getFile(),
				'line' => $e->getLine(),
				'message' => $e->getMessage(),
			],JSON_PRETTY_PRINT));
			return Help::resHttp(
				$request->merge([
					'payload' => [
						'message' => 'Terjadi kesalahan sistem.',
						'code' => 500,
					]
				])
			);
		}
	}
}
