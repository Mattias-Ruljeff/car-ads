<?php

namespace Model;

class SessionModel {

    public function setSession() {
        if (session_status() != 2) {
			session_start();
			setcookie("hej", "hopp", 5000 , "/", "https://infinite-tundra-79934.herokuapp.com/", true, true);
		}
    }
    
    public function checkIfNoSession() {
        return !$_SESSION["username"];
    }
    public function checkIfSession() {
        return $_SESSION["username"];
    }
}