<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller{
	public function index(){
		return view('index');
	}

	public function store(Request $request){
		// return $request->all();
		try{
			// $store
			$user = User::store($request);
			foreach($request->judul_todo as $key => $val){
			}
		}catch(\Throwable $e){
			$e->getFile(); # Get location file error
			$e->getMessage(); # Get error message
			$e->getLine(); # Get line error
		}
	}
}
