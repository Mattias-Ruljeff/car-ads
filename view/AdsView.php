<?php

class AdsView {

	public function show() {

		$returnString = "Car 1: Nissan";
		$returnString .= "<br>";
		$returnString .= "Car 2: Toyota ";
		$returnString .= "<br>";
		return '<p>' . $returnString . '</p>';
	}
}