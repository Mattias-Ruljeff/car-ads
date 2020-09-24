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
                    return "Username has too few characters, at least 3 characters.<br>Password has too few characters, at least 6 characters.";
                }

                // Check username-----------------------------------------
                if(!$username) {
                    return "Username has too few characters, at least 3 characters.";
                }

                if (strlen($username) < 3) {
                    return "Username has too few characters, at least 3 characters.";
                }

                if (preg_match_all('/[<>!_]/', $username, $result)) {
                    return "Username contains invalid characters."
                }
                
                if($dbConnection->checkUserCredentials("username", $username)) {
                    return "User exists, pick another username.";
                } 
                // Check password------------------------------------------
                if(!$passwrd) {
                    return "Password has too few characters, at least 6 characters.";
                }

                if(strlen($passwrd) < 6){
                    return "Password has too few characters, at least 6 characters.";
                }
                

                if($passwrd != $repeatedPasswrd) {
                    return "Passwords do not match.";
                }

                $dbConnection->createUsernameAndPassword($username, $passwrd);
                return "User registered!";
                // unset($_SESSION[""]);
                header("Refresh:0; url=index.php");

			} catch (\Exception $e) {
                echo $e;
			}
		}
	}
}