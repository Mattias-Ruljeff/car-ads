<?php
 
// INCLUDE THE FILES NEEDED...


require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view\LayoutView.php');
require_once("Controller/logInOrOut.php");

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

class Application {
	private $view;
	private $dateTimeView;
	private $layoutView;
	private $contoller;

	
	//CREATE OBJECTS OF THE VIEWS
	public function run() {
		$this->view = new LoginView();
		$this->dateTimeView = new DateTimeView();
		$this->layoutView = new LayoutView();
		// $this->contoller = new \Controller\logInOrOut($this->user, $this->view);
		
		$this->layoutView->render(false, $this->view, $this->dateTimeView);

	}
}

