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
			// $data = [];
			$request->merge([
				'payload' => [
					'message' => 'Ok',
					'code' => count($data) ? 200 : 204,
					'data' => $data
				]
			]);
			return Help::resHttp($request);
		}catch(\Throwable $e){
			$request->merge([
				'payload' => [
					'message' => 'Terjadi kesalahan sistem.',
					'code' => 500,
				]
			]);
			return Help::resHttp($request);
		}
	}
}
