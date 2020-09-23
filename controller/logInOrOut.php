<?php


class logInOrOut {

    private $view;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";
    private $isLoggedIn = false;

    public function __construct(\LoginView $view) {
        $this->view = $view;

    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn() and !$this->isLoggedIn) {
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
                        if (session_status() != 2) {
                            session_start();
                        }
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
        }  
    }
    public function checkIfLoggedIn () {
        return $this->isLoggedIn;
    }
}