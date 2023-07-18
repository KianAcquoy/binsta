<?php

namespace Controllers;

use Auth\AuthChecker;
use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class SettingController
{
    public function show($data)
    {
        $user = R::findOne('users', 'username = ?', [$data['username']]);
        if (!AuthChecker::isLogged()) {
            header('Location: /login');
            return;
        }
        if (AuthChecker::getUser()['id'] != $user->id) {
            header('Location: /users/' . $user->username);
            return;
        }
        $posts = R::findAll('posts', 'user_id = ? ORDER BY created_at DESC', [$user->id]);
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        $_SESSION['errors'] = [];
        $_SESSION['old'] = [];
        return ViewHelper::render('pages/settings.twig', [
            'user' => $user,
            'posts' => $posts,
            'errors' => $errors,
            'old' => $old
        ]);
    }

    public function password()
    {
        if (!AuthChecker::isLogged()) {
            header('Location: /login');
            return;
        }
        $errors = $_SESSION['errors'] ?? [];
        $_SESSION['errors'] = [];
        return ViewHelper::render('pages/updatepassword.twig', [
            'user' => AuthChecker::getUser(),
            'errors' => $errors
        ]);
    }
}
