<?php
use app\core\Route;

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

if(file_exists(__DIR__ . '/vendor/autoload.php')) 
{
	require __DIR__ . '/vendor/autoload.php';
} else 
{
	echo "Ничего не работает, но пока изучаю MVC на примере Yii2!";
}

session_start();

$route = new Route;
$route->startRouter();
//Route::startRouter();
?>