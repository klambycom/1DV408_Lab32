<?php

namespace signup\controller;

require_once("signup/model/CreateUser.php");

class SignUp {
  /**
   * @var \signup\view\SignUp
   */
  private $view;

	/**
	 * Constructor
	 */
	public function __construct($signupView) {
		$this->view = $signupView;
	}

	/**
	 * @return \signup\model\CreateUser
	 */
	public function getCreatedUser() {
		$user = new \signup\model\CreateUser($this->view->getUsername(),
																				 $this->view->getPassword(),
																				 $this->view->getConfirmation());

		if ($user->success()) {
			// User created, save it!
		} else {
			if ($user->invalidUsername())
				$this->view->invalidUsername();
			if ($user->invalidPassword())
				$this->view->invalidPassword();
			if ($user->invalidConfirmation())
				$this->view->invalidConfirmation();
		}

		return $user;
	}
}
