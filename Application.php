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
		$this->registerController = new RegisterNewUser($this->registerView);
		$this->dbConnection = new DatabaseConnection();
	}

	public function run() {
		if (session_status() != 2) {
			session_set_cookie_params([
				'lifetime' => 600,
				'path' => '/',
				'domain' => $_SERVER['HTTP_HOST'],
				'secure' => true,
				'httponly' => true,
				'samesite' => true
			]);
			session_start();
		}
		$response = $this->changeState();
		$this->generateOutput($response);
		
		// var_dump($_COOKIE);
		// print_r(session_get_cookie_params());
	}

	private function changeState() {

		if(isset($_GET["register"])){
			$response = $this->registerController->registerNewUser($this->dbConnection);
		} else {
			$response = $this->controller->logIn($this->dbConnection);
		}

		// echo "<br> GET ";
		// var_dump($_GET);
		// echo "<br> POST ";
		// var_dump($_POST);
		// echo "<br> COOKIE ";
		// var_dump($_COOKIE);
		return $response;
	}

	private function generateOutput($message) {
		$this->layoutView = new LayoutView();
		if(isset($_GET["register"])){
			$this->layoutView->render(false, $this->registerView, $this->dateTimeView, $message);
		} else {

			if ($this->view->userWantsToLogOut() or !$_SESSION["username"]) {
				$this->layoutView->render(false, $this->view, $this->dateTimeView, $message);
			} else {
				session_regenerate_id();
				$this->layoutView->render(true, $this->view, $this->dateTimeView, $message);
			}
		}
	}

}

