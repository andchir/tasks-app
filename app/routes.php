<?php

use \App\Controller\HomepageController;
use \App\Controller\AuthController;
use App\Controller\TaskController;
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

// Authorization
$router->match('GET', '/auth', function () use ($config, $entityManager) {
    $controller = new AuthController($config['app'], $entityManager);
    echo $controller->authAction();
});

// Tasks
$router->mount('/tasks', function() use ($router, $config, $entityManager) {

    $controller = new TaskController($config['app'], $entityManager);

    $router->match('GET|POST', '/add', function() use ($controller) {
        echo $controller->addPageAction();
    });
});
