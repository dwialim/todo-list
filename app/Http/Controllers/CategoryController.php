<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Help;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\UserTodoRequest;

class CategoryController extends Controller{
	public function index(){
		return view('index');
	}

	public function store(Request $request){
	// public function store(UserTodoRequest $request){
		DB::beginTransaction();
		try{
			if(User::where('username',$request->username)->orWhere('email',$request->email)->count()){
				return Help::resHttp(
					$request->merge([
						'payload' => [
							'message' => 'Username atau email sudah digunakan',
							'code' => 409,
						]
					])
				);
			}
			if(!($user = User::store($request))){
				DB::rollBack();
				return Help::resHttp(
					$request->merge([
						'payload' => [
							'message' => 'Data user gagal disimpan',
							'code' => 500,
						]
					])
				);
			}
			$request->merge(['user_id'=>$user->id]);
			foreach($request->judul_todo as $key => $val){
				$task = new Task;
				$task->user_id = $request->user_id;
				$task->category_id = $request->kategori[$key];
				$task->description = $val;
				$task->created_by = $request->user_id;
				if(!$task->save()){
					DB::rollBack();
					return Help::resHttp(
						$request->merge([
							'payload' => [
								'message' => 'Data to-do gagal disimpan',
								'code' => 500,
							]
						])
					);
				}
			}
			DB::commit();
			return Help::resHttp(
				$request->merge([
					'payload' => [
						'message' => 'Data berhasil disimpan',
						'code' => 201,
					]
				])
			);
		}catch(\Throwable $e){
			DB::rollBack();
			# Lakukan log untuk debugging
			Log::debug(json_encode([
				'source' => $e->getFile(),
				'line' => $e->getLine(),
				'message' => $e->getMessage(),
			],JSON_PRETTY_PRINT));
			return Help::resHttp(
				$request->merge([
					'payload' => [
						'message' => 'Terjadi kesalahan sistem',
						'code' => 500,
					]
				])
			);
		}
	}
}
