<?php

use App\Controllers\FormController;
use App\Controllers\IndexController;
use App\Http\Router;

$router = new Router();

$router->add('get', '/', IndexController::class, 'index');
$router->add('get', '/forms', FormController::class, 'index');
$router->add('get', '/forms/view', FormController::class, 'view');
$router->add('post', '/forms/create', FormController::class, 'create');
$router->add('get', '/forms/delete', FormController::class, 'delete');

return $router;
