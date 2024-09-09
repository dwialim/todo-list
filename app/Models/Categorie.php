<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categorie extends Model{
	use HasFactory;

	protected $table = 'categories';

	protected $attribute = ['name'];

	# menambahkan nilai ke dalam representasi array/JSON model
	protected $appends = ['display_name'];

	/*
	|--------------------------------------------------------------------------
	| Mutators & Accessors
	|--------------------------------------------------------------------------
	| # Fungsi: 
	|		1. Accessor: mengubah nilai atribut Eloquent ketika diakses (ready)
	|		2. Mutators: mengubah nilai atribut Eloquent ketika disetel (create / update)
	|
	*/
	public function displayName():Attribute{ # Instance attribute
		return Attribute::make(
			get: fn($value)=>ucwords(
				implode(" ",explode("_",$this->attributes['name']))
			), # Accessor method.
		);
	}

	public static function getData($request){
		return Categorie::select(
			'id',
			'name',
		)->get();
	}
}
