<?php
 
// INCLUDE THE FILES NEEDED...
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once("view/LayoutView.php");
require_once("view/RegisterView.php");
require_once("controller/logInOrOut.php");
require_once("controller/RegisterNewUser.php");
require_once("model/UserStorage.php");
require_once("model/UserName.php");
require_once("model/DatabaseConnection.php");

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

class Application {
	private $dateTimeView;
	private $layoutView;
	private $registerView;
	private $controller;
	private $view;
	private $dbConnection;

	public function __construct(){
		$this->dateTimeView = new DateTimeView();
		$this->registerView = new RegisterView();
		$this->view = new LoginView();
		$this->controller = new logInOrOut($this->view);
		$this->dbConnection = new DatabaseConnection();
	}

	public function run() {
		if (session_status() == 1) {
			session_start();
		  }
		$response = $this->changeState();
		// $checkIfLoggedIn = $this->checkIfLoggedIn();
		$this->generateOutput($response);
	}

	private function changeState() {
		$response = $this->controller->logIn($this->dbConnection);

		// echo "<br> GET ";
		// var_dump($_GET);
		// echo "<br> POST ";
		// var_dump($_POST);
		// echo "<br> COOKIE ";
		// var_dump($_COOKIE);
		return $response;
	}

	// private function checkIfLoggedIn() {
	// 	$response = $this->controller->checkIfLoggedIn();
	// 	return $response;
	// }

	private function generateOutput($message) {
		$this->layoutView = new LayoutView();
			// if($_POST[$this->view->userWantsToLogOut()]){
			// 	session_unset();
			// };
		if(isset($_GET["register"])){
			$this->layoutView->render(false, $this->registerView, $this->dateTimeView, $message);
		} else {
		if ($this->view->userWantsToLogOut()) {
			$this->layoutView->render(false, $this->view, $this->dateTimeView, $message);
			
		} else {
			$this->layoutView->render(true, $this->view, $this->dateTimeView, $message);

		}
		}
	}

}

