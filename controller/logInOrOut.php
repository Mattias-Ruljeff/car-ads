<?php


class logInOrOut {

    private $user;
    private $view;

    public function __construct(\model\UserName $user, \LayoutView $view) {
        $this->user = $user;
        $this->view = $view;
    }



}