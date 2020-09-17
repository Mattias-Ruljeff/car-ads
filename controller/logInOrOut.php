<?php


class logInOrOut {

    private $user;
    private $view;

    public function __construct(\Model\UserName $user,  $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function logIn() {
        
    }

}