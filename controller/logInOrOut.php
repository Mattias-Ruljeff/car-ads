<?php


class logInOrOut {

    private $user;
    private $view;

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function doChangeUserName($dbConnection)  {
        echo "loginorout 1 ";
		if ($this->view->userWantsToChangeName()) {
            try {
                echo "loginorout 2 ";
				$name = $dbConnection->checkUsernameAndPassword("John", "Doe");
				echo $name;
			} catch (\Exception $e) {
                echo "loginorout 3 ";
                // $this->view->getMessages();
                echo $e;
			}
		}
	}

 ////
}