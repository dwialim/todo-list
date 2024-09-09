<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use Help;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class UserTodoRequest extends FormRequest{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/*
	|--------------------------------------------------------------------------
	| Get the validation rules that apply to the request
	|--------------------------------------------------------------------------
	| --- Documentation ~> https://laravel.com/docs/master/validation#rule-required-if ---
	| --- @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string> ---
	|
	| # required_if:anotherfield,value,...
	|		~> validasi akan di eksekusi jika nilai sama dengan apapun(is equal)
	| # required_unless:anotherfield,value,...
	|		~> validasi akan di eksekusi jika nilai tidak sama dengan apapun(is not equal)
	| # required_without:foo,bar,...
	|		~> validasi akan di eksekusi jika field yang ditentukan bernilai null/kosong
	*/
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'nama' => 'required',
			'username' => 'required',
			'email' => 'required',
		];
	}

	/**
	 * Custom message for validation
	 *
	 * @return array
	 */
	public function messages(): array
	{
		return [
			'nama.required'=>'<span class="fw5">Nama</span> harus diisi',
			'username.required'=>'<span class="fw5">Username</span> harus diisi',
			'email.required'=>'<span class="fw5">Email</span> harus diisi',
		];
	}

	public function failedValidation(Validator $validator){ # Error feedback
		$message = '';
		$i = 1;
		foreach (json_decode($validator->errors()) as $k => $v) {
			$message .= "$v[0]".($i%2==0 ? '.<br>' : '. ');
			$i++;
		}
		$request = new Request;
		throw new HttpResponseException(Help::resHttp($request->merge([
			'payload' => [
				'message' => $message,
				'code' => 400,
			]
		])));
	}
}
