<?php


class logInOrOut {

    private $user;
    private $view;

    public function __construct(\model\UserName $user, \LoginView $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function doChangeUserName()  {
		if ($this->view->userWantsToChangeName()) {
			try {
				$name = $this->view->getUserName();
				echo $name;
			} catch (\Exception $e) {
                // $this->view->getMessages();
                echo $e;
			}
		}
	}

 ////
}