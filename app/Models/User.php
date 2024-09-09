<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'username',
		'email',
	];


	/*
	|--------------------------------------------------------------------------
	| Mutators & Accessors
	|--------------------------------------------------------------------------
	| # Fungsi: 
	|		1. Accessor: mengubah nilai atribut Eloquent ketika diakses (ready)
	|		2. Mutators: mengubah nilai atribut Eloquent ketika disetel (create / update)
	|
	*/
	// public function name():Attribute{ # Instance attribute
	// 	return Attribute::make(
	// 		set: fn($value)=>strtolower($value), # Mutator method.
	// 	);
	// }

	public static function store($request){
		$store = new User;
		$store->name = $request->nama;
		$store->username = $request->username;
		$store->email = $request->email;
		$store->save();
		return $store ? : false;
	}



	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	// protected $hidden = [
	// 	'password',
	// 	'remember_token',
	// ];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	// protected function casts(): array
	// {
	// 	return [
	// 		'email_verified_at' => 'datetime',
	// 		'password' => 'hashed',
	// 	];
	// }
}
