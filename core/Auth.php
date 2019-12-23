<?php

namespace Core;

class Auth
{
	const ROLE_GUEST = 'guest';

	const ROLE_USER = 'user';

	const ROLE_ADMINISTRATOR = 'administrator';

	protected $session;

	/**
	 * @var bool
	 */
	protected $isGuest;

	/**
	 * @var bool
	 */
	protected $isAdministrator;

	/**
	 * Auth constructor.
	 *
	 * @param Session $session
	 */
	public function __construct(Session $session)
	{
		$this->session = $session;

		if ($this->session->get('is_guest', true)) {
			$this->auth(self::ROLE_GUEST);
		} else {
			if ($this->session->get('is_administrator', false)) {
				$this->auth(self::ROLE_ADMINISTRATOR);
			} else {
				$this->auth(self::ROLE_USER);
			}
		}
	}

	/**
	 * Аутентификация по роли
	 *
	 * @param string $role
	 */
	public function auth($role = self::ROLE_GUEST)
	{
		if ($role == self::ROLE_GUEST) {
			$this->isGuest = true;
			$this->isAdministrator = false;
		} else {
			$this->isGuest = false;

			if ($role == self::ROLE_ADMINISTRATOR) {
				$this->isAdministrator = true;
			}
		}

		$this->saveSession();
	}

	/**
	 * Выход
	 */
	public function logout()
	{
		$this->isGuest = true;
		$this->isAdministrator = false;

		$this->saveSession();
	}

	/**
	 * @return bool
	 */
	public function isGuest() :bool
	{
		return $this->isGuest;
	}

	/**
	 * @return bool
	 */
	public function isAdministrator() :bool
	{
		return $this->isAdministrator;
	}

	/**
	 * Сохраняем данные аутентификации в сессию
	 */
	protected function saveSession()
	{
		$this->session->set('is_guest', $this->isGuest);
		$this->session->set('is_administrator', $this->isAdministrator);
	}
}
