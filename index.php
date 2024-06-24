<?php

// index.php

require_once 'Router.php';
require_once 'UserController.php';

$router = new Router();

// Örnek route tanımları
$router->get('/', function() {
    echo 'Ana sayfa';
});

$router->get('/users/{id}', 'UserController@show');
$router->post('/users', 'UserController@store');

// Route işleme
$router->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
