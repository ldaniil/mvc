<?php

namespace Core;

use Symfony\Component\HttpFoundation\ParameterBag;

class Controller
{
	/**
	 * @var Application
	 */
	protected $app;

	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @var ParameterBag
	 */
	protected $request;

	/**
	 * @var View
	 */
	protected $view;

	/**
	 * @var Auth
	 */
	protected $auth;

	/**
	 * @var string
	 */
	protected $responseType;

	/**
	 * @var mixed
	 */
	protected $responseContent;

	/**
	 * @var array
	 */
	protected $oldRequestParams = [];

	/**
	 * Controller constructor.
	 */
	public function __construct()
	{
		$this->app = Application::getInstance();

		$this->session = $this->app->getSession();
		$this->request = $this->app->getRequest();
		$this->view = $this->app->getView();
		$this->auth = $this->app->getAuth();

		$this->oldRequestParams = $this->session->getFlashBag()->get('old');
		$this->session->getFlashBag()->set('old', $this->request->request->all());
	}

	/**
	 *
	 */
	public function redirect($url, $flash = [])
	{
		$this->session->getFlashBag()->set('redirectFlash', $flash);

		$this->app->responseType = Application::RESPONSE_TYPE_REDIRECT;
		$this->app->responseContent = $url;

		return;
	}

	/**
	 * @param string $template
	 * @param array $params
	 */
	public function render($template, $params = [])
	{
		if ($redirectFlash = $this->session->getFlashBag()->get('redirectFlash')) {
			$params = array_merge($redirectFlash, $params);
		}

		$params['old'] = $this->oldRequestParams;

		$this->app->responseType = Application::RESPONSE_TYPE_HTML;
		$this->app->responseContent = $this->view->render($template, $params);

		return;
	}
}
