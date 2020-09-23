<?php

use function PHPSTORM_META\type;

class logInOrOut {

    private $view;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";
    private $isLoggedIn;

    public function __construct(\LoginView $view) {
        $this->view = $view;
        $this->isLoggedIn = false;

    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn() and !isset($_SESSION["username"])) {
            $message = "";
            try {
                $username = $this->view->getUserName();
                if(!$username) {
                    return "Username is missing";
                }
                $passwrd = $this->view->getPassword();
                
				if($dbConnection->checkUserCredentials("username", $username)) {
                    $message = "";

                    if($dbConnection->checkUserCredentials("passwrd", $passwrd)) {
                        $_SESSION["username"] = $username;
                        $this->isLoggedIn = true;
                        $message = "Welcome";
                        return $message;
                    } else {
                        if(!$passwrd) {
                            return "Password is missing";
                        }
                        $message = 'Wrong name or password';
                        return $message;
                    }
                    $message = "Wrong name or password";
                    return $message;
                } else {
                    $this->isLoggedIn = false;
                    $message = "Wrong name or password";
                    return $message;
                }
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