<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("signup/view/SignUp.php");
//require_once("signup/controller/SignUp.php"); @TODO???



class Application {
	private $view;

	private $loginController;

  /**
   * @var \signup\view\SignUp
   */
  private $signupView;
	
	public function __construct() {
		$loginView = new \login\view\LoginView();
    $this->signupView = new \signup\view\SignUp();
		
		$this->loginController = new \login\controller\LoginController($loginView);
    //$this->signupController = new \signup\controller\SignUp($signupView); @TODO???

		$this->view = new \application\view\View($loginView, $this->signupView);
	}
	
	public function doFrontPage() {
		$this->loginController->doToggleLogin();
	
		if ($this->loginController->isLoggedIn()) {
			$loggedInUserCredentials = $this->loginController->getLoggedInUser();
			return $this->view->getLoggedInPage($loggedInUserCredentials);	
		} else if ($this->signupView->isConfirmingSigningUp()) {
			echo "Try att registrera user";
			die();
		} else if ($this->signupView->isSigningUp()) {
      return $this->view->getSignUpPage();
		} else {
			return $this->view->getLoggedOutPage();
		}
	}
}
