<?php

namespace App\Forms;

use Core\Form;

class TaskForm extends Form
{
	public $name;

	public $email;

	public $description;

	public $photo;

	public $status;

	public function rules() :array
	{
		return [
			'name'        => 'required',
			'email'       => 'required|email',
			'description' => 'required',
			'photo'       => 'uploaded_file:0,2MB,gif,png,jpeg',
			'status'      => 'in:complete'
		];
	}
}
