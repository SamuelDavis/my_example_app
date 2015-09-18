<?php

namespace App;

use Slim\Slim;

class Route
{
    const HOME = 'home';
    const LOGIN_GET = 'login-get';
    const LOGIN_POST = 'login-post';
    const LOGOUT = 'logout';
    const REGISTER_GET = 'register-get';
    const REGISTER_POST = 'register-post';
    const USERS_LIST = 'user-index';
    const USER_VIEW = 'user-view';
    const USER_EDIT = 'user-edit';
    const USER_CREATE = 'user-create';

    /** @var Slim */
    private static $app = null;

    public static function init(Slim $app)
    {
        static::$app = $app;
    }

    public static function to($routeName)
    {
        return static::$app->urlFor($routeName);
    }
}
