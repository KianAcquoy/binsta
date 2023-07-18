<?php

namespace Controllers;

use Auth\AuthChecker;
use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class UserController
{
    public function show($data)
    {
        $user = R::findOne('users', 'username = ?', [$data['username']]);
        if (!$user) {
            header('Location: /');
            return;
        }
        $posts = R::findAll('posts', 'user_id = ? ORDER BY created_at DESC', [$user->id]);
        return ViewHelper::render('pages/profile.twig', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
    
    public function update($data)
    {
        if (!AuthChecker::isLogged()) {
            header('Location: /login');
            return;
        }
        if (AuthChecker::getUser()['username'] != $data['username']) {
            header('Location: /users/' . $data['username']);
            return;
        }
        $user = R::findOne('users', 'username = ?', [$data['username']]);
        if (!$user) {
            header('Location: /');
            return;
        }
        if (R::findOne('users', 'username = ?', [$_POST['username']]) && AuthChecker::getUser()['username'] != $_POST['username']) {
            $_SESSION['errors']['username'] = 'Username is already taken';
        } else if (strlen($_POST['username']) < 3) {
            $_SESSION['errors']['username'] = 'Username must be at least 3 characters long';
        } else if (AuthChecker::getUser()['username'] != $_POST['username']) {
            $user->username = $_POST['username'];
            AuthChecker::updateUsername($_POST['username']);
        }
        $user->biography = $_POST['biography'];
        if ($_FILES['avatar']['size'] > 0) {
            $storagepath = '/storage/avatars/';
            if ($this->checkAvatarAllowed($_FILES['avatar'])) {
                $user->avatar = $storagepath . $user->id . '.png';
                R::store($user);
                move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $storagepath . $user->id . '.png');
            }
        }
        R::store($user);
        if (count($_SESSION['errors']) > 0) {
            header('Location: /users/' . $user->username . '/settings');
            $_SESSION['old'] = $_POST;
        } else {
            header('Location: /users/' . $user->username);
        }
    }

    public function updateBiography($data)
    {
        $user = R::findOne('users', 'username = ?', [$data['username']]);
        $user->biography = $_POST['biography'];
        R::store($user);
        header('Location: /users/' . $user->username);
        return;
    }

    private function checkAvatarAllowed($file)
    {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        if (getimagesize($file['tmp_name']) == false) {
            return false;
        }
        if (!in_array($file['type'], $allowed)) {
            return false;
        }
        return true;
    }

    public function search($data)
    {
        if (!isset($data['query'])) {
            return ViewHelper::render('pages/search-users.twig', [
                'users' => R::findAll('users'),
                'query' => ''
            ]);
        }
        $users = R::findAll('users', 'username LIKE ?', [$data['query'] . '%']);
        if (count($users) == 1) {
            header('Location: /users/' . $users[array_key_first($users)]->username);
            return;
        }
        return ViewHelper::render('pages/search-users.twig', [
            'users' => $users,
            'query' => $data['query']
        ]);
    }
    
    public function updatePassword($data)
    {
        if (!AuthChecker::isLogged()) {
            header('Location: /login');
            return;
        }
        $authuser = AuthChecker::getUser();
        if (!$authuser) {
            header('Location: /users/' . $data['username']);
            return;
        }
        $user = R::findOne('users', 'username = ?', [$authuser['username']]);
        if (!password_verify($_POST['currentpassword'], $user->password)) {
            $_SESSION['errors']['currentpassword'] = 'Current password is incorrect';
        } else if (strlen($_POST['newpassword']) < 8) {
            $_SESSION['errors']['newpassword'] = 'Password must be at least 8 characters long';
        } else if ($_POST['newpassword'] != $_POST['confirmpassword']) {
            $_SESSION['errors']['confirmpassword'] = 'New password and confirmation do not match';
        } else {
            $user->password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
            R::store($user);
            header('Location: /users/' . $user->username);
            return;
        }
        if (count($_SESSION['errors']) > 0) {
            header('Location: /update-password');
        }
    }
}
