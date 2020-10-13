<?php

namespace Controller;

class LogInOrOut {

    private $view;

    public function __construct(\View\LoginView $view) {
        $this->view = $view;
        $this->isLoggedIn = false;
    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn() and !isset($_SESSION["username"])) {
            try {
                return $dbConnection->checkUsernameAndPasswordOnLogin($this->view->getUserName(), $this->view->getPassword());
                
			} catch (\Exception $e) {
                echo $e;
			}
        } else if($this->view->userWantsToLogOut()  and isset($_SESSION["username"])) {
         return "Bye bye!";
        }
    }
    public function checkIfLoggedIn () {
        return $this->isLoggedIn;
    }
}