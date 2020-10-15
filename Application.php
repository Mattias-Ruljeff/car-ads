<?php
 
// INCLUDE THE FILES NEEDED...
require_once("controller/LogInOrOutController.php");
require_once("controller/RegisterNewUser.php");
require_once("controller/AdsController.php");
require_once('view/DateTimeView.php');
require_once('view/AdsView.php');
require_once('view/LoginView.php');
require_once("view/LayoutView.php");
require_once("view/RegisterView.php");
require_once("model/UserStorage.php");
require_once("model/UserName.php");
require_once("model/DatabaseConnection.php");
require_once("model/SessionModel.php"); 
require_once("model/AdsModel.php"); 

// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

class Application {
	private $dateTimeView;
	private $adsView;
	private $layoutView;
	private $registerView;
	private $controller;
	private $registerController;
	private $adsModel;
	private $adsController;
	private $sessionModel;
	private $view;
	private $dbConnection;

	public function __construct(){
		$this->dbConnection = new \Model\DatabaseConnection();
		$this->dateTimeView = new \View\DateTimeView();
		$this->adsView = new \View\AdsView();
		$this->registerView = new \View\RegisterView();
		$this->view = new \View\LoginView();
		$this->layoutView = new \View\LayoutView();
		$this->adsModel = new \Model\AdsModel($this->dbConnection);
		$this->controller = new \Controller\logInOrOut($this->view);
		$this->registerController = new \Controller\RegisterNewUser($this->registerView);
		$this->adsController = new \Controller\AdsController($this->adsView, $this->adsModel);
		$this->sessionModel = new \Model\SessionModel();
	}

	public function run() {
		$this->sessionModel->setSession();
		$response = $this->changeState();
		$this->generateOutput($response);

		// var_dump($_COOKIE);
		// print_r(session_get_cookie_params());
	}

	private function changeState() {
		$this->adsView->addNewCar();
		$this->adsView->saveCar();
		$this->adsView->editCar();
		$this->adsView->deleteCar();
		$this->adsController->addNewCar();
		$this->adsController->editCar();
		$this->adsController->deleteCar();

		if($this->registerView->checkIfRegisterIsSet()){
			$response = $this->registerController->registerNewUser($this->dbConnection);
		} else {
			$response = $this->controller->logIn($this->dbConnection);
		}
		return $response;
	}

	private function generateOutput($message) {

		if($this->registerView->checkIfRegisterIsSet()){
			$this->layoutView->render(false, $this->registerView, $this->dateTimeView, null, $message);
		} else {
			if ($this->view->userWantsToLogOut() or $this->sessionModel->checkIfNoSession()) {
				$this->layoutView->render(false, $this->view, $this->dateTimeView,  $this->adsView->showOnlyAds($this->adsModel->getAllAds()), $message);
			} else {
				session_regenerate_id();
				$this->layoutView->render(true, $this->view, $this->dateTimeView, $this->adsView->showAdsWithButtons($this->adsModel->getAllAds()), $message);
			}
		}
	}

}

