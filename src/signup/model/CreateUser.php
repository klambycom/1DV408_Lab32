<?php

namespace signup\model;

class CreateUser {
	private $username;
	private $password;
	private $errors;

	public function __construct($username, $password, $confirmation) {
		$this->username = $this->validateUsername($username);
		$this->password = $this->validatePassword($password);
		$this->validateConfirmation($password, $confirmation);
	}

	public function getUser() {
		return \login\model\UserCredentials::create($this->username, $this->password);
	}

	public function success() {
		return empty($this->errors);
	}

	public function invalidUsername() {
		return in_array("username", $this->errors);
	}

	public function invalidPassword() {
		return in_array("password", $this->errors);
	}

	public function invalidConfirmation() {
		return in_array("confirmation", $this->errors);
	}

	private function validateConfirmation($password, $confirmation) {
		if ($password != $confirmation)
			$this->errors[] = "confirmation";
	}

	private function validateUsername($username) {
		try {
			$username = new \login\model\UserName($username);
			return $username->__toString();
		} catch (\Exception $e) {
			$this->errors[] = "username";
		}
	}

	private function validatePassword($password) {
		try {
			$password = \login\model\Password::fromCleartext($password);
			return $password->__toString();
		} catch (\Exception $e) {
			$this->errors[] = "password";
		}
	}

	/* @TODO

		validate(function ($username) {
			return new \login\model\UserName($username);
		}, "username", $username);
		OR
		validate('username', 'username', $username);

	private function validate($fn, $type, $value) {
		try {
			return $fn($value)->__toString();
		} catch (\Exception) {
			$this->errors[] = $type;
		}
	}

	private function username($username) {
		return new \login\model\UserName($username);
	}

	private function password($password) {
		return \login\model\Password::fromCleartext($password);
	}
	 */
}
