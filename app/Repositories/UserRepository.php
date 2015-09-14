<?php

namespace App\Repositories;

use App\Entities\User;

/**
 * @method User get(int $id)
 * @method User build()
 */
class UserRepository extends Repository
{
    const ENTITY = User::class;

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->repo->findOneBy([
            User::EMAIL => $email,
        ]);
    }
}
