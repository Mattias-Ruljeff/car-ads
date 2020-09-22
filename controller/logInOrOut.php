<?php


class logInOrOut {

    private $user;
    private $view;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;

    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn()) {
            $message = "";
            $loggedIn = false;
            try {
                $username = $this->view->getUserName();
                $passwrd = $this->view->getPassword();

				if($dbConnection->checkUserCredentials("username", $username)) {
                    $message = "";

                    if($dbConnection->checkUserCredentials("passwrd", $passwrd)) {
                        $message = "Username and password correct";
                        $loggedIn = true;
                        return $message;
                    } else {
                        $message = 'fail';
                        // echo " password is not correct ";
                        return $message;
                    }
                    $message = "Username or password incorrect";
                    return $message;
                } else {
                    $message = "Username or password incorrect";
                    return $message;
                }
                // echo $name;
			} catch (\Exception $e) {
                // $this->view->getMessages();
                echo $e;
			}
		}
	}
}