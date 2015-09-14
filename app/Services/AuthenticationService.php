<?php

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;

class AuthenticationService
{
    const SESSION_KEY = 'app.user';

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|false
     */
    public function authenticate($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && $user->hasPassword($password)) {
            return $user;
        }

        return false;
    }

    public function login(User $user)
    {
        $_SESSION[static::SESSION_KEY] = $user;
    }

    public function getCurrentUser()
    {
        return isset($_SESSION[static::SESSION_KEY]) ? $_SESSION[static::SESSION_KEY] : null;
    }

    public function logout()
    {
        unset($_SESSION[static::SESSION_KEY]);
    }
}
