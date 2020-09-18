
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once( __DIR__  .'/view/LoginView.php');
require_once( __DIR__ . '/view/DateTimeView.php');
require_once( __DIR__  . '/view/LayoutView.php');
require_once( __DIR__  . "/view/RegisterView.php");
require_once("controller/logInOrOut.php");
require_once("model/UserStorage.php");
require_once("model/UserName.php");
require_once("model/DatabaseConnection.php");
require_once("Application.php");

$app = new Application();
$app->run();


var_dump($_SESSION);
