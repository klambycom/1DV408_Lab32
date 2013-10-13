<?php

namespace application\view;

require_once("common/view/Page.php");
require_once("SwedishDateTimeView.php");



class View {
	private $loginView;

	private $timeView;
	
	public function __construct($loginView, $signupView) {
		$this->loginView = $loginView;
		$this->signupView = $signupView;
		$this->timeView = new SwedishDateTimeView();
	}
	
	public function getLoggedOutPage() {
		$html = $this->getHeader(false);
		$loginBox = $this->loginView->getLoginBox(); 
		$signupLink = $this->signupView->getSignUpLink();

    $html .= "$signupLink
							<h2>Ej Inloggad</h2>
							$loginBox";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inte inloggad", $html);
	}
	
	public function getLoggedInPage($user) {
		$html = $this->getHeader(true);
		$logoutButton = $this->loginView->getLogoutButton(); 
		$userName = $user->getUserName();

		$html .= "
				<h2>$userName är inloggad</h2>
				 	$logoutButton
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inloggad", $html);
	}

	/**
	 * @return \common\view\Page
	 */
	public function getSignUpPage() {
		$html = $this->getHeader(false);
		$form = $this->signupView->getSignUpForm();
		$backLink = "..."; // @TODO $this->loginView->loginLink(); ???

		$html .= "$backLink
							<h2>Ej Inloggad, Registrerar användare</h2>
							$form";
		$html .= $this->getFooter();

		return new \common\view\Page("Registrering av ny användare", $html);
	}
	
	private function getHeader($isLoggedIn) {
		$ret =  "<h1>Laborationskod xx222aa</h1>";
		return $ret;
		
	}

	private function getFooter() {
		$timeString = $this->timeView->getTimeString(time());
		return "<p>$timeString<p>";
	}
	
	
	
}
