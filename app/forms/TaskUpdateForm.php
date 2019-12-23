<?php

namespace App\Forms;

use Core\Form;

class TaskUpdateForm extends Form
{
	public $description;

	public $status;

	public function rules() :array
	{
		return [
			'description' => 'required',
			'status'      => 'in:complete'
		];
	}
}
