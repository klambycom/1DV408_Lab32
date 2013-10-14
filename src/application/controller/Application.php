<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("signup/view/SignUp.php");
require_once("signup/controller/SignUp.php");



class Application {
	private $view;

	private $loginController;

  /**
   * @var \signup\view\SignUp
   */
  private $signupView;

	/**
	 * @var \signup\controller\SignUp
	 */
	private $signupController;
	
	public function __construct() {
		$loginView = new \login\view\LoginView();
    $this->signupView = new \signup\view\SignUp();
		
		$this->loginController = new \login\controller\LoginController($loginView);
    $this->signupController = new \signup\controller\SignUp($this->signupView);

		$this->view = new \application\view\View($loginView, $this->signupView);
	}
	
	public function doFrontPage() {
		$this->loginController->doToggleLogin();
	
		if ($this->loginController->isLoggedIn()) {
			$loggedInUserCredentials = $this->loginController->getLoggedInUser();
			return $this->view->getLoggedInPage($loggedInUserCredentials);	
		} else if ($this->signupView->isConfirmingSigningUp()) {
			return $this->signup();
		} else if ($this->signupView->isSigningUp()) {
      return $this->view->getSignUpPage();
		} else {
			return $this->view->getLoggedOutPage();
		}
	}

	private function signup() {
		$user = $this->signupController->getCreatedUser();
		if ($user->success()) {
			$savedUser = $user->getUser();
			return $this->view->getLoggedOutPage($savedUser->getUserName());
		} else {
			return $this->view->getSignUpPage();
		}
	}
}
