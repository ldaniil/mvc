<?php

namespace App\Services;

use App\Forms\AuthForm;
use App\Models\TaskModel;
use Core\Application;
use Core\Auth;
use Core\Exception\ValidateException;

class AuthService
{
	/**
	 * @param AuthForm $form
	 *
	 * @return TaskModel
	 * @throws ValidateException
	 */
	public function auth(AuthForm $form)
	{
		if ($form->validate()) {
			if ($form->login == 'admin' && $form->password == '123')
			{
				Application::getInstance()->getAuth()->auth(Auth::ROLE_ADMINISTRATOR);
				return;
			}

			$form->addError('login', 'Incorrect login or password');
		}

		throw new ValidateException();
	}
}
