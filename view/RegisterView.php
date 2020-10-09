<?php

namespace View;

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
	private static $savedName;

	public function userWantsToRegisterUser() : bool {
		return isset($_POST[self::$register]);
	}

	public function getUserName() {
		return $_POST[self::$name];
	}

	public function getPassword() {
		return $_POST[self::$password];
	}
	public function getRepeatedPassword() {
		return $_POST[self::$passwordRepeat];
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($message) {
		if($_POST[self::$name]) {

			self::$savedName = strip_tags(trim($_POST[self::$name]));
		}
		$response = $this->generateRegisterFormHTML($message);

		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
		return '
			<h2>Register new user</h2>
			<form method="post" > 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. self::$savedName . '" />
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