<?php

namespace App\Observers;

use App\Models\User;

class UserObserver{
	public function created(User $user){
		$user->created_by = $user->id;
		$user->save();
	}

	public function updated(User $user){
	}

	public function deleted(User $user){
		$user->deleted_by = $user->id;
		$user->save();
	}
}
