<?php

namespace Controllers;

use Auth\AuthChecker;
use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class AuthController
{
    public function login()
    {
        if (AuthChecker::isLogged()) {
            header('Location: /');
            return;
        }
        return ViewHelper::render('pages/login.twig');
    }

    public function register()
    {
        if (AuthChecker::isLogged()) {
            header('Location: /');
            return;
        }
        return ViewHelper::render('pages/register.twig');
    }

    public function authenticate()
    {
        $_SESSION['error'] = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = R::findOne('users', 'username = ?', [$username]);
        $_SESSION['userid'] = $user['id'];
        if (!$user) {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: /login');
            return;
        } else if (!password_verify($password, $user->password)) {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: /login');
            return;
        } else {
            $_SESSION['user'] = $user;
            header('Location: /');
            return;
        }
        return;
    }

    public function registerUser()
    {
        $_SESSION['error'] = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $confirm_password = $_POST['confirm_password'];
        $user = R::findOne('users', 'username = ?', [$username]);
        if ($user) {
            $_SESSION['error'] = 'Username already exists';
            header('Location: /register');
            return;
        } else if ($password != $confirm_password) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: /register');
            return;
        } else {
            $user = R::dispense('users');
            $user->username = $username;
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->biography = 'Hi, I am new here!';
            $user->avatar = 'https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg';
            $user->created_at = date('Y-m-d H:i:s');
            R::store($user);
            $_SESSION['user'] = $user;
            header('Location: /');
            return;
        }
        return;
    }

    public static function logout()
    {
        session_destroy();
        header('Location: /');
        return;
    }
}
