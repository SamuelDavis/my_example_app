<?php

namespace App;

use App\Controllers\UserController;
use Slim\Slim;

class Router
{
    private $userController;
    /** @var Slim */
    private $app;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function apply(Slim $app)
    {
        $this->app = $app;

        $this->routeRoot();

        $this->app->group('/users', function () {
            $this->routeUsers();
        });
    }

    private function routeRoot()
    {
        $this->app->get('/', function () {
            die ("Hello world!");
        });
    }

    private function routeUsers()
    {
        $this->app->get('', function () {
            return $this->userController->index();
        });

        $this->app->get('/edit(/:id)', function ($id = null) {
            return $this->userController->getEdit($id);
        });

        $this->app->post('/edit', function () {
            return $this->userController->postEdit();
        });

        $this->app->get('/:id', function ($id) {
            return $this->userController->read($id);
        });
    }
}
