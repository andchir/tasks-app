<?php

require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/routes.php';

session_start();

/** @var \Bramus\Router\Router $router */

$router->run();
