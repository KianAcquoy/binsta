<?php

namespace Controllers;

use Auth\AuthChecker;
use Helpers\ViewHelper;
use RedBeanPHP\R as R;

class LikeController
{
    public function view($data)
    {
        $users = R::findAll('users');
        $likes = R::findAll('likes', 'post_id = ? ORDER BY created_at DESC', [$data['id']]);
        return ViewHelper::render('components/likeview.twig', [
            'users' => $users,
            'likes' => $likes,
        ]);
    }

    public function changeLike($data)
    {
        $user = AuthChecker::getUser();
        $action = $data['action'];
        $post_id = $data['post_id'];
        $like = R::findOne('likes', 'user_id = ? AND post_id = ?', [$user->id, $post_id]);
        if ($action == 'like') {
            if (!$like) {
                $like = R::dispense('likes');
                $like->user_id = $user->id;
                $like->post_id = $post_id;
                $like->created_at = date('Y-m-d H:i:s');
                R::store($like);
            }
        } else {
            if ($like) {
                R::trash($like);
            }
        }
        return json_encode([
            'status' => 'success',
        ]);
    }

    public function count($data)
    {
        $likes = R::findAll('likes', 'post_id = ?', [$data['post_id']]);
        echo count($likes);
    }
}
