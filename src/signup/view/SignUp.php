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
	 * @var string $PASSWORDAGAIN
	 */
	private static $PASSWORDAGAIN = "password_again";

	/**
	 * @var string $PASSWORD
	 */
	private static $PASSWORD = "password";

	/**
	 * @var string $NAME
	 */
	private static $NAME = "username";

	/**
	 * @var array $messages
	 */
	private $messages = array();

	/**
	 * @return string
	 */
	public function getUsername() {
		return $_POST[self::$NAME];
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $_POST[self::$PASSWORD];
	}

	/**
	 * @return string
	 */
	public function getConfirmation() {
		return $_POST[self::$PASSWORDAGAIN];
	}

	/**
	 * @return boolean True if user is showing sign up page.
	 */
	public function isSigningUp() {
		return isset($_GET[self::$SIGNUP]);
	}

	/**
	 * @return boolean True if user is confirming sign up form.
	 * @TODO: Change name!!!
	 */
	public function isConfirmingSigningUp() {
		return isset($_GET[self::$SIGNUP]) && !empty($_POST);
	}

	/**
	 * @return html
	 */
	public function getSignUpLink() {
		return "<a href='?" . self::$SIGNUP . "'>Registrera ny användare</a>";
	}

	/**
	 * Message for invalid username
	 */
	public function invalidUsername() {
		$this->messages[] = "Användarnamnet har för få tecken. Minst 3 tecken.";
	}

	/**
	 * Message for invalid password
	 */
	public function invalidPassword() {
		$this->messages[] = "Lösenorden har för få tecken. Minst 6 tecken.";
	}

	/**
	 * Message for when password and confirmation don't match
	 */
	public function invalidConfirmation() {
		$this->messages[] = "Lösenorden matchar inte.";
	}

	/**
	 * Message for when the username is already taken
	 */
	public function usernameAlreadyTaken() {
		$this->messages[] = "Användarnamnet är redan upptaget";
	}

	/**
	 * @return string Error messages
	 */
	public function getMessages() {
		if (empty($this->messages)) {
			return "";
		} else {
			return "<p>" . implode('<br/>', $this->messages) . "</p>";
		}
	}

	/**
	 * @return html
	 */
	public function getSignUpForm() {
		return "
			<form action='?" . self::$SIGNUP . "' method='post'>
				<fieldset>
				" . $this->getMessages() . "
					<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
					<label for='" . self::$NAME . "'>Namn:</label>
					<input type='text' size='20' name='" . self::$NAME . "' /><br/>
					<label for='PasswordID'>Lösenord:</label>
					<input type='password' size='20' name='" . self::$PASSWORD . "' /><br/>
					<label for='PasswordID'>Repetera Lösenord:</label>
					<input type='password' size='20' name='" . self::$PASSWORDAGAIN . "' /><br/>
					<input type='submit' value='Registrera' />
				</fieldset>
			</form>";
	}
}
