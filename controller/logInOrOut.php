<?php

namespace Controller;

class logInOrOut {

    private $user;
    private $view;

    public function __construct(\Model\UserName $user, \View\LayoutView $view) {
        $this->user = $user;
        $this->view = $view;
    }

    public function logIn() {
        
    }

}