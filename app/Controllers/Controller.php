<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Slim;

class Controller
{
    protected $request;
    private $app;

    public function __construct(Slim $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    protected function render($template, $data = [], $status = 200)
    {
        $this->app->render($template, $data, $status);
    }

    protected function redirect($url, $status = 200)
    {
        $this->app->redirect($url, $status);
    }
}
