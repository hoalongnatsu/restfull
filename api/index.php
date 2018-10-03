<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../core/bootstrap.php';

$router = new Router;
$router->setRoutes($routes);

$url = $_SERVER['REQUEST_URI'];
require $router->getFilename($url);