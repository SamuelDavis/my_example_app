@extends('layouts/base')
<?php
use App\Entities\Role;use App\Entities\User;

/**
 * @var User $user
 */

?>

@section('body')
    <table>
        <tr>
            <th>Id</th>
            <td><?= $user->getId() ?></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td><?= $user->getFirstName() ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?= $user->getLastName() ?></td>
        </tr>
        <tr>
            <th>Roles</th>
            <td><?= implode(', ', array_map(function (Role $role) { return $role->getName(); }, $user->getRoles())) ?></td>
        </tr>
    </table>
    <form action="/users/edit/<?= $user->getId() ?>">
        <input type="submit" value="Edit">
    </form>
@stop
