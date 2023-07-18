<?php

namespace Controllers;

use Helpers\ViewHelper;

class TestController
{
    public function index()
    {
        return ViewHelper::render('pages/test.twig');
    }
}
