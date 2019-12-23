<?php

namespace App\Controllers;

use App\Forms\AuthForm;
use App\Services\AuthService;
use Core\Auth;
use Core\Controller;
use Core\Exception\ValidateException;

class AdministrationController extends Controller
{
	public function index()
	{

	}

	public function loginForm()
	{
		return $this->render('administration/login');
	}

	public function login()
	{
		$form = new AuthForm();
		$form->load($this->request->request->all());

		try {
			$service = new AuthService();
			$service->auth($form);
		} catch (ValidateException $e) {
			return $this->redirect('/login', ['erros' => $form->errors()]);
		}

		return $this->redirect('/');
	}

	public function logout()
	{
		$this->auth->logout();

		return $this->redirect('/');
	}
}
