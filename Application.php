<?php

require_once("controller/LogInOrOutController.php");
require_once("controller/RegisterNewUser.php");
require_once("controller/AdsController.php");

require_once('view/DateTimeView.php');
require_once('view/AdsView.php');
require_once('view/LoginView.php');
require_once("view/LayoutView.php");
require_once("view/RegisterView.php");

require_once("model/DatabaseConnection.php");
require_once("model/SessionModel.php"); 
require_once("model/AdsModel.php"); 
require_once("model/Car.php"); 

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
	private static $isLoggedIn = true;
	private static $isNotLoggedIn = false;

	public function __construct(){
		$this->sessionModel = new \Model\SessionModel();
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
	}

	public function run() {
		$this->sessionModel->setSession();
		$response = $this->changeState();
		$this->generateOutput($response);
	}

	private function changeState() {
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
			$this->layoutView->render(self::$isNotLoggedIn, $this->registerView, $this->dateTimeView, $this->adsView->showOnlyAds($this->adsModel->getAllAds()), $message);
		} else {
			if ($this->view->userWantsToLogOut() or $this->sessionModel->checkIfNoSession()) {
				$this->layoutView->render(self::$isNotLoggedIn, $this->view, $this->dateTimeView, $this->adsView->showOnlyAds($this->adsModel->getAllAds()), $message);
			} else {
				session_regenerate_id();
				$this->layoutView->render(self::$isLoggedIn,$this->view, $this->dateTimeView, $this->adsView->showAdsWithButtons($this->adsModel->getAllAds()), $message);
			}
		}
	}
}

