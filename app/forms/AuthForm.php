<?php

namespace App\Forms;

use Core\Form;

class AuthForm extends Form
{
	public $login;

	public $password;

	public function rules() :array
	{
		return [
			'login'    => 'required',
			'password' => 'required',
		];
	}
}
