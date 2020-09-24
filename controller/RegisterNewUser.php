<?php


class RegisterNewUser {

    private $view;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";

    public function __construct(\RegisterView $view) {
        $this->view = $view;

    }

    public function registerNewUser($dbConnection)  {
		if ($this->view->userWantsToRegisterUser()) {
            try {

                // Check username-----------------------------------------
                $username = $this->view->getUserName();
                if(!$username) {
                    return "Username is missing";
                }

                if (strlen($username) < 2) {
                    return "Enter a username with 2 characters or more";
                }

                // Check password------------------------------------------
                $passwrd = $this->view->getPassword();
                $repeatedPasswrd = $this->view->getRepeatedPassword();
                if(!$passwrd) {
                    return "Enter a password";
                }

                if(strlen($passwrd) < 6){
                    return "Enter a password  with 6 characters or more";
                }
                
				if($dbConnection->checkUserCredentials("username", $username)) {
                    return "Username taken";
                } 

                if($passwrd != $repeatedPasswrd) {
                    return "Password not matching!";
                }

                $dbConnection->createUsernameAndPassword($username, $passwrd);
                return "User registered!";

			} catch (\Exception $e) {
                echo $e;
			}
		}
	}
}