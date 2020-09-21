<?php
 
// INCLUDE THE FILES NEEDED...
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once("view/LayoutView.php");
require_once("view/RegisterView.php");
require_once("controller/logInOrOut.php");
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
		$this->storage = new \model\UserStorage();
		$this->user = $this->storage->loadUser();
		$this->dateTimeView = new DateTimeView();
		$this->registerView = new RegisterView($this->user);
		$this->view = new LoginView();
		$this->controller = new logInOrOut($this->user, $this->view);
		$this->dbConnection = new DatabaseConnection();
	}

	public function run() {
		// echo $_SERVER["SERVER_NAME"] . "<br>";
		$this->changeState();
		$this->generateOutput();
	}

	private function changeState() {
		$this->controller->logIn($this->dbConnection);


		// echo "<br> GET ";
		// var_dump($_GET);
		// echo "<br> POST ";
		// var_dump($_POST);
		// echo "<br> COOKIE ";
		// var_dump($_COOKIE);
		// $this->storage->saveUser($this->user);
	}

	private function generateOutput() {
		$this->layoutView = new LayoutView();
		if(isset($_GET["register"])){
			$this->layoutView->render(false, $this->registerView, $this->dateTimeView);
		} else {
			$this->layoutView->render(false, $this->view, $this->dateTimeView);
		}
	}

}

