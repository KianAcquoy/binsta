<?php

namespace Controllers;

use Auth\AuthChecker;
use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class PostController
{
    public function create()
    {
        return ViewHelper::render('pages/create.twig');
    }

    public function show($data)
    {
        if (!isset($data['showComments'])) {
            $data['showComments'] = false;
        }
        $post = R::findOne('posts', 'id = ?', [$data['id']]);
        $users = R::findAll('users');
        $user = R::findOne('users', 'id = ?', [$post['user_id']]);
        $comments = R::findAll('comments', 'post_id = ?', [$data['id']]);
        return ViewHelper::render('pages/post.twig', [
            'post' => $post,
            'comments' => $comments,
            'user' => $user,
            'users' => $users,
            'showComments' => $data['showComments'],
        ]);
    }

    public function showWithComments($data)
    {
        $data['showComments'] = true;
        $this->show($data);
    }

    public function store()
    {
        $post = R::dispense('posts');
        $post->user_id = AuthChecker::getUser()['id'];
        $post->caption = $_POST['caption'];
        $post->content = $_POST['content'];
        $post->language = $_POST['language'];
        $post->created_at = date('Y-m-d H:i:s');
        $id = R::store($post);
        header('Location: /posts/' . $id);
    }

    public function delete($data)
    {
        $post = R::findOne('posts', 'id = ?', [$data['id']]);
        $user = R::findOne('users', 'id = ?', [$post->user_id]);
        if (AuthChecker::getUser()['id'] != $post->user_id) {
            return false;
        }
        R::trash($post);
        header('Location: /users/' . $user['username'] . '/settings');
        return true;
    }

    public function confirmDelete($data)
    {
        $post = R::findOne('posts', 'id = ?', [$data['id']]);
        if (AuthChecker::getUser()['id'] != $post->user_id) {
            return false;
        }
        return ViewHelper::render('components/deleteconfirm.twig', [
            'post' => $post
        ]);
    }
}
