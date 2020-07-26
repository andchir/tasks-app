<?php

use \App\Controller\HomepageController;
use \App\Controller\AuthController;
use \Doctrine\ORM\EntityManagerInterface;
use \Bramus\Router\Router;

/** @var array $config */
/** @var EntityManagerInterface $entityManager */

$router = new Router();

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Page not found!';
});

// Home page
$router->match('GET', '/', function () use ($config, $entityManager) {
    $controller = new HomepageController($config['app'], $entityManager);
    echo $controller->indexAction();
});

$router->match('GET', '/auth', function () use ($config, $entityManager) {
    $controller = new AuthController($config['app'], $entityManager);
    echo $controller->authAction();
});

//$router->mount('/', function() use ($router, $config, $entityManager) {
//    var_dump('home');
//});

//$router->get('/', function() { echo 'Index'; });
$router->get('/hello', function() { echo 'Hello!'; });
