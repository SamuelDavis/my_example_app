<?php

use Slim\Slim;
use App\Router;

/** @var Slim $app */
$app = require_once __DIR__ . '/../app/bootstrap.php';
$app->container->get(Router::class)->apply($app);

$app->run();
