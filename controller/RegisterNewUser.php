<?php

namespace Controller;

class RegisterNewUser {

    private $view;

    public function __construct(\View\RegisterView $view) {
        $this->view = $view;

    }

    public function registerNewUser($dbConnection)  {
		if ($this->view->userWantsToRegisterUser()) {
            try {
                $username = $this->view->getUserName();
                $passwrd = $this->view->getPassword();
                $repeatedPasswrd = $this->view->getRepeatedPassword();

                return $dbConnection->checkUserOnRegistration($username, $passwrd, $repeatedPasswrd);

			} catch (\Exception $e) {
                echo $e;
			}
		}
	}
}