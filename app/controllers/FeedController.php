<?php

namespace Controllers;

use Helpers\ViewHelper;
use RedBeanPHP\R as R;
use Helpers\DatabaseHelper;

class FeedController
{
    public function index()
    {
        $posts = R::findAll('posts', 'ORDER BY created_at DESC');
        $users = R::findAll('users');
        return ViewHelper::render('pages/feed.twig', [
            'posts' => $posts,
            'users' => $users,
        ]);
    }
}
