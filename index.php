<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require 'autoload.php';
use app\core\Router;
$route = new Router();
$route->run();
