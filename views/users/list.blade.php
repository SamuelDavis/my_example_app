@extends('layouts/base')
<?php
use App\Entities\User;

/**
 * @var User[] $users
 */
?>

@section('body')
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td>
                <a href="/users/<?= $user->getId() ?>">
                    <?= $user->getFullName() ?>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="/users/edit"><button>Add New User</button></a>
@stop
