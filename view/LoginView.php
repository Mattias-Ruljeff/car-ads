<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $test;


	public function userWantsToChangeName() : bool {
		// return isset($_GET[self::$name]) and isset($_GET[self::$password]) ;
		return true;
	}

	public function getUserName() {
		echo " getUserName() ";
		echo "funka??";
		// return $this->dbConnection->checkUsernameAndPassword($_GET[self::$name], $_GET[self::$password]);
		return $this->dbConnection->checkUsernameAndPassword("John", "Doe");
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {

		$message = "";
		if($_POST[self::$name] == "" or $_POST[self::$password] == "") {
			self::$test = $_POST[self::$name];
			$message = "Enter name and password";
		} else {
			self::$test = $_POST[self::$name];
			$username = $_POST[self::$name];
			$password = $_POST[self::$password];
			$_SESSION["user"] = "Username: " . $username . " Password: " .  $password;		
		}
		if ($_POST) {
			$response = $this->generateLoginFormHTML($message);
		} else {
			$response = $this->generateLoginFormHTML("");
		}
		// $response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	public function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$test .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		return "username";
	}
	
}