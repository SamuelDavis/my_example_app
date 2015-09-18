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
        })->name(Route::HOME);

        $this->app->get('/login', function () {
            return $this->rootController->getLogin();
        })->name(Route::LOGIN_GET);
        $this->app->post('/login', function () {
            return $this->rootController->postLogin();
        })->name(Route::LOGIN_POST);
        $this->app->get('/logout', function () {
            return $this->rootController->logout();
        })->name(Route::LOGOUT);
        $this->app->get('/register', function () {
            return $this->rootController->getRegister();
        })->name(Route::REGISTER_GET);
        $this->app->post('/register', function () {
            return $this->rootController->postRegister();
        })->name(Route::REGISTER_POST);
    }

    private function routeUsers()
    {
        $this->app->get('', function () {
            return $this->userController->index();
        })->name(Route::USERS_LIST);

        $this->app->get('/edit(/:id)', function ($id = null) {
            return $this->userController->getEdit($id);
        })->name(Route::USER_EDIT);

        $this->app->post('/edit', function () {
            return $this->userController->postEdit();
        })->name(Route::USER_CREATE);

        $this->app->get('/:id', function ($id) {
            return $this->userController->read($id);
        })->name(Route::USER_VIEW);
    }
}
