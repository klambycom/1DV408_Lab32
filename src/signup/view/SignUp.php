<?php

namespace signup\view;

require_once("./common/Filter.php");
require_once("./login/model/LoginObserver.php");

class SignUp {
	/**
	 * @var string $SIGNUP
	 */
	private static $SIGNUP = "signup";

	/**
	 * @var string $CONFIRM
	 */
	private static $CONFIRM = "confirmsignup";

	/**
	 * @return boolean True if user is showing sign up page.
	 */
	public function isSigningUp() {
		return isset($_GET[self::$SIGNUP]);
	}

	/**
	 * @return boolean True if user is confirming sign up form.
	 * @TODO: Should maybe be a post
	 */
	public function isConfirmingSigningUp() {
		return isset($_GET[self::$CONFIRM]);
	}

	/**
	 * @return html
	 */
	public function getSignUpLink() {
		return "<a href='?" . self::$SIGNUP . "'>Registrera ny användare</a>";
	}

	/**
	 * @return html
	 * @TODO
	 */
	public function getSignUpForm() {
		return "todo";
	}
}
