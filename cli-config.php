<?php

use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Slim;

/**
 * @var Slim $app
 */

$app = require_once __DIR__ . '/app/bootstrap.php';

$driver = new StaticPHPDriver([__DIR__ . '/app/Entities']);

/** @var EntityManager $entityManager */
$entityManager = $app->container->get(EntityManager::class);
$entityManager->getConfiguration()->setMetadataDriverImpl($driver);

return ConsoleRunner::createHelperSet($entityManager);
