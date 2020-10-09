<?php

namespace View;

class AdsView {

	public function show($isLoggedIn) {

		if($isLoggedIn){

			$returnString = "Car 1: Nissan";
			$returnString .= "<br>";
			$returnString .= "Car 2: Toyota ";
			$returnString .= "<br>";
			return '<h2>My cars</h2>
					<a href="?newcar">New car</a>
					<p>' . $returnString . '</p>';
		} else {
			return "";
		}
	}
}
