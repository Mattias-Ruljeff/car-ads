
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once("Application.php");
require_once("View/LoginView.php");

$app = new Application();
$app->run();

session_start();

var_dump($_SESSION);
