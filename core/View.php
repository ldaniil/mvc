<?php

namespace Core;

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtmlBootstrap;

class View
{
	/**
	 * @var BladeOne
	 */
	protected $templateEngine;

	/**
	 * @var Auth
	 */
	protected $auth;

	/**
	 * View constructor.
	 *
	 * @param BladeOne $templateEngine
	 */
	public function __construct(BladeOne $templateEngine, Auth $auth)
	{
		$this->templateEngine = $templateEngine;
		$this->auth = $auth;
	}

	/**
	 * @param string $template
	 * @param array $params
	 */
	public function render($template, $params = [])
	{
		$params['auth'] = $this->auth;

		return $this->templateEngine->run($template, $params);
	}
}
