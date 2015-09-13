<?php

namespace App\Controllers;

use App\Entities\User;
use App\Repositories\UserRepository;
use Slim\Http\Request;
use Slim\Slim;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(Slim $app, Request $request, UserRepository $userRepository)
    {
        parent::__construct($app, $request);

        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $this->render('users/list', [
            'users' => $this->userRepository->getAll(),
        ]);
    }

    public function read($id)
    {
        $this->render('users/view', [
            'user' => $this->userRepository->get($id)
        ]);
    }

    public function getEdit($id = null)
    {
        $this->render('users/edit', [
            'user' => $id ? $this->userRepository->get($id) : $this->userRepository->build(),
        ]);
    }

    public function postEdit()
    {
        if ($id = $this->request->post(User::ID)) {
            $user = $this->userRepository->get($id);
        } else {
            $user = $this->userRepository->build();
        }

        $user->setFirstName($this->request->post(User::FIRST_NAME));
        $user->setLastName($this->request->post(User::LAST_NAME));

        if ($this->request->post('save')) {
            $this->userRepository->add($user);
        } elseif ($this->request->post('delete')) {
            $this->userRepository->remove($user);
        }

        $this->redirect('/users', 200);

    }
}
