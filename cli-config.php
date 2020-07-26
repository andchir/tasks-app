<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/app/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
