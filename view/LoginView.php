<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $savedName = "";


	public function userWantsToLogIn() : bool {
		return isset($_POST[self::$login]);
	}

	public function userWantsToLogOut() : bool {
		return isset($_POST[self::$logout]);
	}

	public function getUserName() {
		return $_POST[self::$name];
	}

	public function getPassword() {
		return $_POST[self::$password];
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
			self::$savedName = $_POST[self::$name];
		}
		if($_POST[self::$logout]){
			session_unset();
		}
		if($_SESSION["username"]) {
			$response = $this->generateLogoutButtonHTML($message);
		} else {
			$response = $this->generateLoginFormHTML($message);
		}
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
					<div id="login">
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$savedName .'" />
					<br>
					
					<label for="'  . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<br>
					
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<br>
					
					<input type="submit" name="' . self::$login . '" value="login" />
					</div>
				</fieldset>
				
			</form>
		';
	}
}