@extends('layouts/base')
<?php
use App\Entities\User;use App\Route;

?>

@section('body')
    <form action="<?= Route::to(Route::REGISTER_POST) ?>" method="post">
        <label for="<?= User::EMAIL ?>">Email</label>:
        <input type="text" name="<?= User::EMAIL ?>">
        <br>

        <label for="<?= User::FIRST_NAME ?>">First Name</label>:
        <input type="text" name="<?= User::FIRST_NAME ?>">
        <br>

        <label for="<?= User::LAST_NAME ?>">Last Name</label>:
        <input type="text" name="<?= User::LAST_NAME ?>">
        <br>

        <label for="<?= User::PASSWORD ?>">Password</label>:
        <input type="password" name="<?= User::PASSWORD ?>">
        <br>

        <input type="submit" value="Register">
    </form>
@stop

