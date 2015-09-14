<?php

namespace App\Controllers;

use App\Entities\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\AuthenticationService;
use Slim\Http\Request;
use Slim\Slim;

class UserController extends Controller
{
    private $authenticator;
    private $userRepository;
    private $roleRepository;

    public function __construct(
        Slim $app,
        Request $request,
        AuthenticationService $authenticator,
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        parent::__construct($app, $request);

        $this->authenticator = $authenticator;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $this->render('users/list', [
            'users' => $this->userRepository->getAll(),
            'currentUser' => $this->authenticator->getCurrentUser(),
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
            'roles' => $this->roleRepository->getAll(),
        ]);
    }

    public function postEdit()
    {
        if ($id = $this->request->post(User::ID)) {
            $user = $this->userRepository->get($id);
        } else {
            $user = $this->userRepository->build();
        }

        $firstName = $this->request->post(User::FIRST_NAME);
        $lastName = $this->request->post(User::LAST_NAME);
        $email = $this->request->post(User::EMAIL);
        $password = $this->request->post(User::PASSWORD);

        $user
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email);

        if ($password) {
            $user->setPassword($password);
        }

        $postedRoleIds = array_keys($this->request->post(User::ROLES, []));

        foreach ($this->roleRepository->getAll() as $role) {
            if (in_array($role->getId(), $postedRoleIds)) {
                $user->addRole($role);
            } else {
                $user->removeRole($role);
            }
        }

        if ($this->request->post('save')) {
            $this->userRepository->add($user);
        } elseif ($this->request->post('delete')) {
            $this->userRepository->remove($user);
        }

        $this->redirect('/users');

    }
}
