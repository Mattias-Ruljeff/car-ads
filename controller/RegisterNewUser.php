<?php


class RegisterNewUser {

    private $view;
    private $columnOneName = "Username";
    private $columTwoName = "Passwrd";

    public function __construct(\RegisterView $view) {
        $this->view = $view;

    }

    // public function registerNewUser($dbConnection)  {
	// 	if ($this->view->userWantsToRegisterUser()) {
    //         $message = "";
    //         try {
    //             $username = $this->view->getUserName();
    //             if(!$username) {
    //                 return "Username is missing";
    //             }
    //             $passwrd = $this->view->getPassword();
                
	// 			if($dbConnection->checkUserCredentials("username", $username)) {
    //                 $message = "";

    //                 if($dbConnection->checkUserCredentials("passwrd", $passwrd)) {
    //                     $message = "Welcome";
    //                     return $message;
    //                 } else {
    //                     if(!$passwrd) {
    //                         return "Password is missing";
    //                     }
    //                     $message = 'Wrong name or password';
    //                     return $message;
    //                 }
    //                 $message = "Wrong name or password";
    //                 return $message;
    //             } else {
    //                 $message = "Wrong name or password";
    //                 return $message;
    //             }
	// 		} catch (\Exception $e) {
    //             echo $e;
	// 		}
	// 	}
	// }
}