<?php

namespace App\Controllers;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Route;
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
            $this->redirect(Route::to(Route::USERS_LIST));
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
            $this->redirect(Route::to(Route::USERS_LIST));
        }

        $this->redirect('/login', 402);
    }

    public function getRegister()
    {
        $this->render('register');
    }

    public function postRegister()
    {
        $email = $this->request->post(User::EMAIL);
        if ($this->userRepository->findByEmail($email)) {
            $this->redirect(Route::to(Route::REGISTER_GET), 400);
        }

        $password = $this->request->post(User::PASSWORD);
        $firstName = $this->request->post(User::FIRST_NAME);
        $lastName = $this->request->post(User::LAST_NAME);

        $user = (new User())
            ->setEmail($email)
            ->setPassword($password)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $this->userRepository->add($user);

        if ($this->authenticator->authenticate($email, $password)) {
            $this->authenticator->login($user);
            $this->redirect(Route::to(Route::USERS_LIST));
        }

        $this->redirect(Route::to(Route::REGISTER_GET), 402);
    }

    public function logout()
    {
        $this->authenticator->logout();

        $this->redirect(Route::to(Route::LOGIN_GET));
    }
}
