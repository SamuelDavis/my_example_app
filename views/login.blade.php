@extends('layouts/base')
<?php
use App\Entities\User;use App\Route;

?>

@section('body')
    <form action="<?= Route::to(Route::LOGIN_POST) ?>" method="post">
        <label for="<?= User::EMAIL ?>">Email</label>:
        <input type="text" name="<?= User::EMAIL ?>">
        <br>

        <label for="<?= User::PASSWORD ?>">Password</label>:
        <input type="password" name="<?= User::PASSWORD ?>">
        <br>

        <input type="submit" value="Login">
    </form>
@stop

