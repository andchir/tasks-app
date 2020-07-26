<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use \Doctrine\ORM\ORMException;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/config.php';

$isDevMode = true;
$doctrineConfig = Setup::createYAMLMetadataConfiguration([
    __DIR__ . '/config/yml-mappings'
], $isDevMode);

try {
    $entityManager = EntityManager::create($config['conn'], $doctrineConfig);
} catch (ORMException $e) {
    echo $e->getMessage();
}
