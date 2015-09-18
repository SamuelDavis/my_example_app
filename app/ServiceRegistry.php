<?php

namespace App;

use App\Controllers\RootController;
use App\Controllers\UserController;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\AuthenticationService;
use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\Slim;

class ServiceRegistry
{
    public function apply(Slim $app)
    {
        $this->setServerVars();

        $dev = $app->config('app')['env'] == 'development';
        $dbParams = $app->config('database');
        $entitiesPath = [__DIR__ . '/Entities'];
        $config = Setup::createAnnotationMetadataConfiguration($entitiesPath, $dev);
        $entityManagerDriver = new StaticPHPDriver($entitiesPath);

        $entityManager = EntityManager::create($dbParams, $config);
        $entityManager->getConfiguration()->setMetadataDriverImpl($entityManagerDriver);

        $userRepository = new UserRepository($entityManager);
        $roleRepository = new RoleRepository($entityManager);

        $authenticator = new AuthenticationService($userRepository);

        $rootController = new RootController($app, $app->request, $authenticator, $userRepository);
        $userController = new UserController($app, $app->request, $authenticator, $userRepository, $roleRepository);

        $router = new Router($rootController, $userController);
        Route::init($app);

        $this->setBindings($app, [
            $entityManager,
            $userRepository,
            $roleRepository,
            $authenticator,
            $rootController,
            $userController,
            $router,
        ]);
    }

    private function setBindings(Slim $app, array $bindings)
    {
        foreach ($bindings as $binding) {
            $app->container->set(get_class($binding), $binding);
        }
    }

    private function setServerVars()
    {
        switch (php_sapi_name()) {
            case 'cli':
                $server = [
                    'REQUEST_URI' => getcwd(),
                    'REMOTE_ADDR' => getcwd(),
                    'REQUEST_METHOD' => 'GET',
                    'SERVER_NAME' => 'localhost',
                ];
                break;
            default:
                $server = [];
        }
        $_SERVER = array_merge($server, $_SERVER);
    }
}
