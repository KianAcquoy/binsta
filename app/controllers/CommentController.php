<?php

namespace Controllers;

use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class CommentController
{
    public function view($data)
    {
        $users = R::findAll('users');
        $post = R::findOne('posts', 'id = ?', [$data['id']]);
        $comments = R::findAll('comments', 'post_id = ? ORDER BY created_at DESC', [$data['id']]);
        return ViewHelper::render('components/commentview.twig', [
            'comments' => $comments,
            'post' => $post,
            'users' => $users,
        ]);
    }

    public function store()
    {
        if (str_replace(' ', '', $_POST['comment']) == '') {
            header('Location: /posts/' . $_POST['post_id'] . '/comments');
            return;
        }
        $comment = R::dispense('comments');
        $comment->user_id = intval($_POST['user_id']);
        $comment->post_id = intval($_POST['post_id']);
        $comment->content = $_POST['comment'];
        $comment->created_at = date('Y-m-d H:i:s');
        R::store($comment);
        header('Location: /posts/' . $_POST['post_id'] . '/comments');
    }
}
