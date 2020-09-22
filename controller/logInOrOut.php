<?php


class logInOrOut {

    private $user;
    private $view;
    private $savedUsername;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;

    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn()) {
            $message = "";
            try {
                $username = $this->view->getUserName();
                if(!$username) {
                    return "Username is missing";
                }
                $passwrd = $this->view->getPassword();
                
				if($dbConnection->checkUserCredentials("username", $username)) {
                    $message = "";
                    $this->savedUsername = $username;

                    if($dbConnection->checkUserCredentials("passwrd", $passwrd)) {
                        $message = "Username and password correct";
                        $loggedIn = true;
                        return $message;
                    } else {
                        if(!$passwrd) {
                            return "Password is missing";
                        }
                        $message = 'Wrong name or password';
                        // echo " password is not correct ";
                        return $message;
                    }
                    $message = "Wrong name or password";
                    return $message;
                } else {
                    $message = "Wrong name or password";
                    return $message;
                }
			} catch (\Exception $e) {
                echo $e;
			}
		}
	}
}