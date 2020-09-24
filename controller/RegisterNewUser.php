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

                $username = $this->view->getUserName();
                $passwrd = $this->view->getPassword();
                $repeatedPasswrd = $this->view->getRepeatedPassword();

                if(!$username and !$passwrd){
                    return "Username has too few characters, at least 3 characters.<br>Enter a username with 2 characters or more";

                }

                // Check username-----------------------------------------
                if(!$username) {
                    return "Username has too few characters, at least 3 characters.";
                }

                if (strlen($username) < 2) {
                    return "Enter a username with 2 characters or more";
                }

                // Check password------------------------------------------
                if(!$passwrd) {
                    return "Enter a password";
                }

                if(strlen($passwrd) < 6){
                    return "Password has too few characters, at least 6 characters.";
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