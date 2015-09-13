@extends('layouts/base')
<?php
use App\Entities\User;

/**
 * @var User $user
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

        <input type="submit" name="save" value="Save">
        <input type="submit" name="delete" value="<?= $user->getId() ? 'Delete' : 'Cancel' ?>">
    </form>
@stop
