<?php


class logInOrOut {

    private $user;
    private $view;

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function doChangeUserName($dbConnection)  {
		if ($this->view->userWantsToChangeName()) {
            try {
				$name = $dbConnection->checkUsernameAndPassword("John", "Doe");
				// echo $name;
			} catch (\Exception $e) {
                // $this->view->getMessages();
                echo $e;
			}
		}
	}

 ////
}