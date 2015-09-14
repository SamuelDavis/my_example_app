<?php

namespace App\Controllers;

use App\Services\AuthenticationService;
use Slim\Http\Request;
use Slim\Slim;

class Controller
{
    private $app;
    protected $request;
    protected $authenticator;

    public function __construct(Slim $app, Request $request, AuthenticationService $authenticator)
    {
        $this->app = $app;
        $this->request = $request;
        $this->authenticator = $authenticator;
    }

    protected function render($template, $data = [], $status = 200)
    {
        $data = array_merge($data, [
            'currentUser' => $this->authenticator->getCurrentUser(),
        ]);
        $this->app->render($template, $data, $status);
    }

    protected function redirect($url, $status = 200)
    {
        $this->app->redirect($url, $status);
    }
}
