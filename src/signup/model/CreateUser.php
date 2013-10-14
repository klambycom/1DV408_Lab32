<?php

namespace signup\model;

class CreateUser {
	/**
	 * @var string $username
	 */
	private $username;

	/**
	 * @var string $password
	 */
	private $password;

	/**
	 * @var array $errors
	 */
	private $errors = array();

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $confirmation
	 */
	public function __construct($username, $password, $confirmation) {
		$this->username = $this->validate("createUsername", "username", $username);
		$this->password = $this->validate("createPassword", "password", $password);
		$this->validateConfirmation($password, $confirmation);
	}

	/**
	 * @return \login\model\UserCredentials Newly created user
	 */
	public function getUser() {
		return \login\model\UserCredentials::create($this->username, $this->password);
	}

	/**
	 * @return boolean True if there is no errors
	 */
	public function success() {
		return empty($this->errors);
	}

	/**
	 * @return boolean True if invalid username
	 */
	public function invalidUsername() {
		return in_array("username", $this->errors);
	}

	/**
	 * @return boolean True if invalid password
	 */
	public function invalidPassword() {
		return in_array("password", $this->errors);
	}

	/**
	 * @return boolean True if invalid password confirmation
	 */
	public function invalidConfirmation() {
		return in_array("confirmation", $this->errors);
	}

	/**
	 * @param string $password
	 * @param string $confirmation
	 */
	private function validateConfirmation($password, $confirmation) {
		if ($password != $confirmation)
			$this->errors[] = "confirmation";
	}

	/**
	 * @param function $fn
	 * @param string $type
	 * @param string $value
	 * @return string Validated value
	 */
	private function validate($fn, $type, $value) {
		try {
			return $this->$fn($value)->__toString();
		} catch (\Exception $e) {
			$this->errors[] = $type;
		}
	}

	/**
	 * @param string $username
	 * @return \login\model\UserName
	 */
	private function createUsername($username) {
		return new \login\model\UserName($username);
	}

	/**
	 * @param string $password
	 * @return \login\model\Password
	 */
	private function createPassword($password) {
		return \login\model\Password::fromCleartext($password);
	}
}
