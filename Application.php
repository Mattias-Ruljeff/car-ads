<?php
 
// INCLUDE THE FILES NEEDED...

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once("view/RegisterView.php");
require_once("Controller/logInOrOut.php");
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
		$this->changeState();
		$this->generateOutput();
	}

	private function changeState() {
		$this->controller->doChangeUserName();
		// $this->storage->saveUser($this->user);
	}

	private function generateOutput() {
		
		// $body = $this->view->getBody();
		// $title = $this->view->getTitle();
		$this->layoutView = new LayoutView($this->user);
		$this->layoutView->render(false, $this->view, $this->dateTimeView, $this->registerView);
	}

}

