<?php

use App\ServiceRegistry;
use Slim\Slim;
use Slim\Views\Blade;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [];
$configDir = __DIR__ . '/../app/config';
foreach (scandir($configDir) as $configFile) {
    if (substr($configFile, -4) == '.php') {
        $config[str_replace('.php', '', $configFile)] = require_once "{$configDir}/{$configFile}";
    }
}

$app = new Slim($config);


$app->view(Blade::class)->parserOptions = $app->config('view.options');

(new ServiceRegistry())->apply($app);

return $app;
