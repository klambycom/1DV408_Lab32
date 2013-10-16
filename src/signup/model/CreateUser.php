<?php

namespace signup\model;

require_once("common/model/UserDAL.php");

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
		$this->username = $this->validateUsername($username);
		$this->password = $this->validatePassword($password);
		$this->validateConfirmation($password, $confirmation);
		$this->validateUniqueUsername($username);
	}

	/**
	 * @return \login\model\UserCredentials Newly created user
	 */
	public function getUser() {
		return \login\model\UserCredentials::create($this->username, $this->password);
	}

	/**
	 * Create user in database
	 */
	public function create() {
		\common\model\UserDAL::create($this->getUser());
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
	 * @return boolean True if tags in username
	 */
	public function tagsInUsername() {
		return in_array("html", $this->errors);
	}

	/**
	 * @return boolean True if username is already taken
	 */
	public function usernameIsAlreadyTaken() {
		return in_array("notunique", $this->errors);
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
	 * @param string $username
	 * @return \login\model\UserName
	 */
	private function validateUsername($username) {
		try {
			return new \login\model\UserName($username);
		} catch (\Exception $e) {
			if (\Common\Filter::hasTags($username)) {
				$this->errors[] = "html";
			} else {
				$this->errors[] = "username";
			}
		}
	}

	/**
	 * @param string $password
	 * @return \login\model\Password
	 */
	private function validatePassword($password) {
		try {
			return \login\model\Password::fromCleartext($password);
		} catch (\Exception $e) {
			$this->errors[] = "password";
		}
	}

	/**
	 * Check that the username not exists in database
	 */
	private function validateUniqueUsername($username) {
		$user = \login\model\UserCredentials::createFromClientData($username, "");
		try {
			\common\model\UserDAL::find($user);
			$this->errors[] = "notunique";
		} catch (\Exception $e) {
		}
	}	
}
