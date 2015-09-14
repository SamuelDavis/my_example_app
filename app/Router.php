<?php

namespace App;

use App\Controllers\RootController;
use App\Controllers\UserController;
use Slim\Slim;

class Router
{
    private $rootController;
    private $userController;
    /** @var Slim */
    private $app;

    public function __construct(RootController $rootController, UserController $userController)
    {
        $this->rootController = $rootController;
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

        $this->app->get('/login', function() {
            return $this->rootController->getLogin();
        });
        $this->app->post('/login', function() {
            return $this->rootController->postLogin();
        });
        $this->app->post('/logout', function() {
            return $this->rootController->logout();
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
