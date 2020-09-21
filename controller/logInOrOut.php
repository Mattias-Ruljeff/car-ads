<?php


class logInOrOut {

    private $user;
    private $view;
    private $columnOneName = "username";
    private $columTwoName = "passwrd";

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;

    }

    public function logIn($dbConnection)  {
		if ($this->view->userWantsToLogIn()) {
            try {
                $username = $this->view->getUserName();
                $passwrd = $this->view->getPassword();

				if($dbConnection->checkUserCredentials($this->columnOneName, "$username")) {
                    echo " username exists ";
                    if($dbConnection->checkUserCredentials($this->columTwoName, "$passwrd")) {
                        echo " password is correct ";
                    } else {
                        echo " password is not correct ";
                    }
                } else {
                    echo " username do not exists ";

                }
				// echo $name;
			} catch (\Exception $e) {
                // $this->view->getMessages();
                echo $e;
			}
		}
	}
}