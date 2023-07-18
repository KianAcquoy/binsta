<?php

namespace Auth;

use Controllers\AuthController;
use RedBeanPHP\R;

class AuthChecker
{
    public static function check()
    {
        $user = AuthChecker::getUser();
        if ($user) {
            $data = R::findOne('users', 'id = ?', [$user['id']]);
            if (!$data || $data->username != $user['username']) {
                AuthController::logout();
                return;
            }
        }
    }

    public static function isLogged()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUser()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }

    public static function updateUsername($username)
    {
        $_SESSION['user']['username'] = $username;
    }
}
