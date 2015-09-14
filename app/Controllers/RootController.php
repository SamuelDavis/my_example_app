<?php

namespace App\Controllers;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Services\AuthenticationService;
use Slim\Http\Request;
use Slim\Slim;

class RootController extends Controller
{
    private $userRepository;

    public function __construct(
        Slim $app,
        Request $request,
        AuthenticationService $authenticator,
        UserRepository $userRepository
    ) {
        parent::__construct($app, $request, $authenticator);

        $this->authenticator = $authenticator;
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        if ($this->authenticator->getCurrentUser()) {
            $this->redirect('/users');
        }

        $this->render('login');
    }

    public function postLogin()
    {
        $email = $this->request->post(User::EMAIL);
        $password = $this->request->post(User::PASSWORD);
        $user = $this->authenticator->authenticate($email, $password);

        if ($user) {
            $this->authenticator->login($user);
            $this->redirect('/users');
        }

        $this->redirect('/login', 402);
    }

    public function logout()
    {
        $this->authenticator->logout();

        $this->redirect('/login');
    }
}
