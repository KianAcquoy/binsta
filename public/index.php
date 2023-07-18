<?php

use Auth\AuthChecker;
use Helpers\DatabaseHelper;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
session_start();
DatabaseHelper::connect();
AuthChecker::check();
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/handlers/RouteHandler.php';