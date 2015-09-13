@extends('layouts/base')
<?php
use App\Entities\User;

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
    </table>
    <form action="/users/edit/<?= $user->getId() ?>">
        <input type="submit" value="Edit">
    </form>
@stop
