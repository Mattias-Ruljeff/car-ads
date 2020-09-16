<?php

class DateTimeView {


	public function show() {

		$timeString = date("y/m/d");

		return '<p>' . $timeString . '</p>';
	}
}