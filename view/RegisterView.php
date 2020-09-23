<?php

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $logout = 'RegisterView::Logout';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';
	private static $keep = 'RegisterView::KeepMeLoggedIn';
	private static $messageId = 'RegisterView::Message';
	private $savedName;

	public function userWantsToRegisterUser() : bool {
		return isset($_POST[self::$register]);
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
		
		// if($_POST[self::$name] == "" and $_POST[self::$password] == "") {
		// 	self::$savedName = $_POST[self::$name];
		// 	$message = "Enter name and password";
		// } else if($_POST[self::$name] == "") {
		// 	$message = "Enter name";
		// } else if($_POST[self::$password] == "") {
		// 	self::$savedName = $_POST[self::$name];
		// 	$message = "Enter password";
		// } else {
		// 	self::$savedName = $_POST[self::$name];
		// 	$username = $_POST[self::$name];
		// 	$password = $_POST[self::$password];
		// 	$_SESSION["user"] = "Username: " . $username . " Password: " .  $password;		
		// }

		$response = $this->generateLoginFormHTML($message);
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<a href="/">Log in</a>
			<form method="post" > 
				<fieldset>
					<legend>Register - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />
					<br>
					
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<br>
					
					<label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					<br>
					
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}
	
}