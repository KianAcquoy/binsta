<?php

namespace Helpers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFilter;
use Auth\AuthChecker;
use Twig\TwigFunction;
use RedBeanPHP\R as R;

final class ViewHelper
{
    private static $twig;
    private static $loader;

    private static function initialize()
    {
        if (self::$twig === null) {
            self::$loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/resources/views');
            self::$twig = new Environment(self::$loader);
            self::addCustoms();
        }
    }

    public static function render($template, $data = [])
    {
        self::initialize();
        echo self::$twig->render($template, $data);
    }

    private static function addCustoms()
    {
        self::$twig->addGlobal('session', $_SESSION);
        // Ago filter returns the time passed since the date given
        self::$twig->addFilter(
            new TwigFilter('ago', function ($date) {
                $time = strtotime($date);
                $time = time() - $time; // to get the time since that moment
                $time = ($time < 1) ? 1 : $time;
                $tokens = [
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second',
                ];
                foreach ($tokens as $unit => $text) {
                    if ($time < $unit) {
                        continue;
                    }
                    $numberOfUnits = floor($time / $unit);
                    return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '') . ' ago';
                }
            })
        );

        self::$twig->addFilter(
            new TwigFilter('ago_single', function ($date) {
                $time = strtotime($date);
                $time = time() - $time; // to get the time since that moment
                $time = ($time < 1) ? 1 : $time;
                $tokens = [
                31536000 => 'y',
                2592000 => 'mo',
                604800 => 'w',
                86400 => 'd',
                3600 => 'h',
                60 => 'm',
                1 => 's',
                ];
                foreach ($tokens as $unit => $text) {
                    if ($time < $unit) {
                        continue;
                    }
                    $numberOfUnits = floor($time / $unit);
                    return $numberOfUnits . $text;
                }
            })
        );

        // Gets the current logged in user
        self::$twig->addFunction(
            new TwigFunction('user', function () {
                return AuthChecker::getUser();
            })
        );

        // Gets likes of post
        self::$twig->addFunction(
            new TwigFunction('likes', function ($postid) {
                return R::findAll('likes', 'post_id = ?', [$postid]);
            })
        );

        // Gets all likes of a user
        self::$twig->addFunction(
            new TwigFunction('checkLiked', function ($userid, $postid) {
                return R::findOne('likes', 'user_id = ? AND post_id = ?', [$userid, $postid]);
            })
        );
    }
}
