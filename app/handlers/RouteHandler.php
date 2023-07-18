<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Define your routes
$routes = [
    // GET /test
    [
        'method' => 'GET',
        'pattern' => '/test',
        'handler' => 'TestController@index',
    ],
    // GET /
    [
        'method' => 'GET',
        'pattern' => '/',
        'handler' => 'FeedController@index',
    ],
    // GET /create
    [
        'method' => 'GET',
        'pattern' => '/create',
        'handler' => 'PostController@create',
    ],
    // POST /store
    [
        'method' => 'POST',
        'pattern' => '/post/store',
        'handler' => 'PostController@store',
    ],
    // GET /login
    [
        'method' => 'GET',
        'pattern' => '/login',
        'handler' => 'AuthController@login',
    ],
    // GET /register
    [
        'method' => 'GET',
        'pattern' => '/register',
        'handler' => 'AuthController@register',
    ],
    // POST /register
    [
        'method' => 'POST',
        'pattern' => '/register',
        'handler' => 'AuthController@registerUser',
    ],
    // POST /authenticate
    [
        'method' => 'POST',
        'pattern' => '/authenticate',
        'handler' => 'AuthController@authenticate',
    ],
    // GET /logout
    [
        'method' => 'GET',
        'pattern' => '/logout',
        'handler' => 'AuthController@logout',
    ],
    // GET /users/{name}
    [
        'method' => 'GET',
        'pattern' => '/users/{username}',
        'handler' => 'UserController@show',
    ],
    // GET /users/{name}/settings
    [
        'method' => 'GET',
        'pattern' => '/users/{username}/settings',
        'handler' => 'SettingController@show',
    ],
    // POST /users/{name}/update
    [
        'method' => 'POST',
        'pattern' => '/users/{username}/update',
        'handler' => 'UserController@update',
    ],
    // POST /users/{name}/update-biography
    [
        'method' => 'POST',
        'pattern' => '/users/{username}/update-biography',
        'handler' => 'UserController@updateBiography',
    ],

    // POST /update-avatar
    [
        'method' => 'POST',
        'pattern' => '/update-avatar',
        'handler' => 'UserController@updateAvatar',
    ],
    
    // GET /posts/{id}
    [
        'method' => 'GET',
        'pattern' => '/posts/{id}',
        'handler' => 'PostController@show',
    ],
    // GET /posts/{id}/comments
    [
        'method' => 'GET',
        'pattern' => '/posts/{id}/comments',
        'handler' => 'PostController@showWithComments',
    ],
    // GET /posts/{id}/confirm-delete
    [
        'method' => 'GET',
        'pattern' => '/posts/{id}/confirm-delete',
        'handler' => 'PostController@confirmDelete',
    ],
    // POST /posts/{id}/delete
    [
        'method' => 'POST',
        'pattern' => '/posts/{id}/delete',
        'handler' => 'PostController@delete',
    ],
    // GET /comments/view/{id}
    [
        'method' => 'GET',
        'pattern' => '/comments/view/{id}',
        'handler' => 'CommentController@view',
    ],
    // POST /comments/post
    [
        'method' => 'POST',
        'pattern' => '/comments/post',
        'handler' => 'CommentController@store',
    ],
    // GET /likes/view/{id}
    [
        'method' => 'GET',
        'pattern' => '/likes/view/{id}',
        'handler' => 'LikeController@view',
    ],
    // GET /likes/change
    [
        'method' => 'GET',
        'pattern' => '/likes/change/{post_id}/{action}',
        'handler' => 'LikeController@changeLike',
    ],
    // GET /likes/count
    [
        'method' => 'GET',
        'pattern' => '/likes/count/{post_id}',
        'handler' => 'LikeController@count',
    ],
    // GET /serach/users
    [
        'method' => 'GET',
        'pattern' => '/search/users',
        'handler' => 'UserController@search',
    ],
    // GET /search/users/{query}
    [
        'method' => 'GET',
        'pattern' => '/search/users/{query}',
        'handler' => 'UserController@search',
    ],
    // GET /update-password
    [
        'method' => 'GET',
        'pattern' => '/update-password',
        'handler' => 'SettingController@password',
    ],
    // POST /update-password
    [
        'method' => 'POST',
        'pattern' => '/update-password',
        'handler' => 'UserController@updatePassword',
    ],
];

// Get the requested URI and method
$uri = $_SERVER['REQUEST_URI'];
if (substr($uri, -1) == '/' && strlen($uri) > 1) {
    $uri = substr($uri, 0, -1);
}
if (strpos($uri, '?') !== false) {
    $uri = substr($uri, 0, strpos($uri, '?'));
    $query = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '?') + 1);
}
$uripattern = explode('/', $uri);
$method = $_SERVER['REQUEST_METHOD'];
// Find a matching route
$route = null;
$data = null;
foreach ($routes as $routeData) {
    $pattern = preg_replace('/{[^}]+}/', '[^/]+', $routeData['pattern']);
    if (preg_match("@^{$pattern}$@", $uri) && $method == $routeData['method']) {
        $data = [];
        $patternParts = explode('/', $routeData['pattern']);
        foreach ($patternParts as $index => $part) {
            if (preg_match('/{([^}]+)}/', $part, $matches)) {
                $data[$matches[1]] = $uripattern[$index];
            }
        }
        $route = $routeData['handler'];
        break;
    }
}

// Handle the route
if ($route) {
    // Extract the controller and action from the route handler
    [$controllerName, $action] = explode('@', $route);
    $controllerName = 'Controllers\\' . $controllerName;

    // Instantiate the controller
    $controller = new $controllerName();

    // Invoke the action method
    $controller->$action($data);
} else {
    // Handle 404 error
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
}
