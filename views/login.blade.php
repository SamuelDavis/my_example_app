@extends('layouts/base')
<?php
use App\Entities\User;

?>

@section('body')
    <form action="/login" method="post">
        <label for="<?= User::EMAIL ?>">Email</label>:
        <input type="text" name="<?= User::EMAIL ?>">
        <br>

        <label for="<?= User::PASSWORD ?>">Password</label>:
        <input type="password" name="<?= User::PASSWORD ?>">
        <br>

        <input type="submit" value="Login">
    </form>
@stop

