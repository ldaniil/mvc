<?php

namespace Core;

class Application
{
	const RESPONSE_TYPE_HTML = 'html';

	const RESPONSE_TYPE_REDIRECT = 'redirect';

	private static $_instance = null;

	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @var Request
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
	public $responseType;

	/**
	 * @var mixed
	 */
	public $responseContent;

	static public function getInstance(\Closure $callback = null) {

		if(null === self::$_instance)
		{
			self::$_instance = new self();

			if ($callback) {
				$callback->call(self::$_instance, self::$_instance);
			}
		}

		return self::$_instance;
	}

	private function __construct() {

	}

	protected function __clone() {

	}

	public function setSession(Session $session)
	{
		$this->session = $session;
	}

	public function getSession() :Session
	{
		return $this->session;
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	public function getRequest() :Request
	{
		return $this->request;
	}

	public function setView(View $view)
	{
		$this->view = $view;
	}

	public function getView() :View
	{
		return $this->view;
	}

	public function setAuth(Auth $auth)
	{
		$this->auth = $auth;
	}

	public function getAuth() :Auth
	{
		return $this->auth;
	}
}
