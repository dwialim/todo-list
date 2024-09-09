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
	public function displayName():Attribute{ # Instance attribute
		return Attribute::make(
			set: fn($value)=>$this->attributes['id'], # Mutator method.
		);
	}

   public static function store($request){
      $store = new User;
      $user->name = $request->nama;
      $user->username = $request->username;
      $user->email = $request->email;
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
