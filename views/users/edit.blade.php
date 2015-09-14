@extends('layouts/base')
<?php

use App\Entities\Role;
use App\Entities\User;

/**
 * @var User $user
 * @var Role[] $roles
 */
?>

@section('body')
    <form action="/users/edit" method="post">

        <?php if($id = $user->getId()): ?>
        <label for="id">Id: <?= $id ?></label>
        <input type="hidden" name="<?= User::ID ?>" value="<?= $user->getId() ?>">
        <br>

        <?php endif; ?>
        <label for="first_name">First Name</label>:
        <input type="text" name="<?= User::FIRST_NAME ?>" value="<?= $user->getFirstName() ?>">
        <br>

        <label for="last_name">Last Name</label>:
        <input type="text" name="<?= User::LAST_NAME ?>" value="<?= $user->getLastName() ?>">
        <br>

        <label for="roles">Roles</label>
        <ul class="unstyled">
            <?php foreach ($roles as $role): ?>
            <li>
                <label for="roles[]"><?= $role->getName() ?></label>
                <input
                        type="checkbox"
                        name="<?= User::ROLES . "[{$role->getId()}]" ?>"
                        <?= $user->hasRole($role) ? 'checked' : '' ?>
                        >
            </li>
            <?php endforeach; ?>
        </ul>
        <br>

        <input type="submit" name="save" value="Save">
        <input type="submit" name="delete" value="<?= $user->getId() ? 'Delete' : 'Cancel' ?>">
    </form>
@stop
