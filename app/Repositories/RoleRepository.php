<?php

namespace App\Repositories;

use App\Entities\Role;

/**
 * @method Role get(int $id)
 * @method Role[] getAll()
 */
class RoleRepository extends Repository
{
    const ENTITY = Role::class;
}
